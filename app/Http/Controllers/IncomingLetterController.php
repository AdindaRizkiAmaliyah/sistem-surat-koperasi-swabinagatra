<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\LetterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\LetterAttachment;

class IncomingLetterController extends Controller
{
    
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:150'],
            'category_id' => ['nullable', 'integer', 'exists:letter_categories,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $query = IncomingLetter::with('category', 'creator')
            ->orderBy('received_date', 'desc');

        // Pencarian berdasarkan nomor agenda, nomor surat,
        // pengirim, atau perihal.
        if (!empty($validated['search'])) {
            $search = $validated['search'];

            $query->where(function ($q) use ($search) {
                $q->where('agenda_number', 'like', "%{$search}%")
                    ->orWhere('letter_number', 'like', "%{$search}%")
                    ->orWhere('sender', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori surat.
        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        // Filter berdasarkan tanggal diterima.
        if (!empty($validated['start_date'])) {
            $query->whereDate('received_date', '>=', $validated['start_date']);
        }

        if (!empty($validated['end_date'])) {
            $query->whereDate('received_date', '<=', $validated['end_date']);
        }

        $letters = $query->paginate(10)->withQueryString();

        $categories = LetterCategory::where('is_active', true)
            ->orderBy('category_name')
            ->get();

        return view('incoming-letters.index', compact(
            'letters',
            'categories'
        ));
    }

    public function create()
    {
        $categories = LetterCategory::where('is_active', true)
            ->orderBy('category_name')
            ->get();

        return view('incoming-letters.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_number' => [
                'required',
                'string',
                'max:50',
                'unique:incoming_letters,agenda_number',
            ],
            'letter_number' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'exists:letter_categories,id'],
            'sender' => ['required', 'string', 'max:150'],
            'subject' => ['required', 'string', 'max:200'],
            'letter_date' => ['nullable', 'date'],
            'received_date' => ['required', 'date'],
            'summary' => ['nullable', 'string'],
            'destination' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],

            // File scan wajib PDF, maksimal 5 MB
            'scan_file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:5120',
            ],
        ]);

        $scanFile = $validated['scan_file'];
        unset($validated['scan_file']);

        // Simpan file ke penyimpanan lokal/private Laravel
        $filePath = $scanFile->store('incoming-letters', 'local');

        try {
            DB::transaction(function () use ($validated, $scanFile, $filePath) {
                // Simpan informasi surat masuk
                $letter = IncomingLetter::create([
                    ...$validated,
                    'status' => 'registered',
                    'created_by' => Auth::id(),
                ]);

                // Simpan informasi file ke tabel letter_attachments
                $letter->attachments()->create([
                    'original_name' => $scanFile->getClientOriginalName(),
                    'file_path' => $filePath,
                    'mime_type' => $scanFile->getMimeType(),
                    'file_size' => $scanFile->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            });
        } catch (\Throwable $exception) {
            // Hapus file jika penyimpanan database gagal
            Storage::disk('local')->delete($filePath);

            throw $exception;
        }

        return redirect()
            ->route('incoming-letters.index')
            ->with('success', 'Surat masuk dan arsip PDF berhasil ditambahkan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        $incomingLetter->load([
            'category',
            'creator',
            'attachments',
            'dispositions.sender',
            'dispositions.recipient',
            'dispositions.department',
        ]);

        return view('incoming-letters.show', compact('incomingLetter'));
    }

    public function viewAttachment(
    IncomingLetter $incomingLetter,
    LetterAttachment $attachment
) {
    abort_unless(
        $incomingLetter->attachments()
            ->whereKey($attachment->id)
            ->exists(),
        404
    );

    abort_unless(
        Storage::disk('local')->exists($attachment->file_path),
        404
    );

    return Storage::disk('local')->response(
        $attachment->file_path,
        $attachment->original_name,
        ['Content-Type' => 'application/pdf']
    );
}

    public function downloadAttachment(
        IncomingLetter $incomingLetter,
        LetterAttachment $attachment
    ) {
        abort_unless(
            $incomingLetter->attachments()
                ->whereKey($attachment->id)
                ->exists(),
            404
        );

        abort_unless(
            Storage::disk('local')->exists($attachment->file_path),
            404
        );

        return Storage::disk('local')->download(
            $attachment->file_path,
            $attachment->original_name
        );
    }
}