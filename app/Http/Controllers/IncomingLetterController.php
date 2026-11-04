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
    public function index()
    {
        $letters = IncomingLetter::with('category', 'creator')
            ->orderBy('received_date', 'desc')
            ->paginate(10);

        return view('incoming-letters.index', compact('letters'));
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
        $incomingLetter->load('category', 'creator', 'dispositions', 'attachments');

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