<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LetterCategory;
use App\Models\OutgoingLetter;
use App\Models\LetterAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OutgoingLetterController extends Controller
{
    /**
     * Menampilkan daftar surat keluar.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:letter_categories,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $query = OutgoingLetter::with(['category', 'department', 'creator'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                    ->orWhere('recipient', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('sent_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('sent_date', '<=', $request->end_date);
        }

        $outgoingLetters = $query->paginate(10)->withQueryString();

        $categories = LetterCategory::where('is_active', true)
            ->orderBy('category_name')
            ->get();

        $departments = Department::where('is_active', true)
            ->orderBy('department_name')
            ->get();

        return view('outgoing-letters.index', compact(
            'outgoingLetters',
            'categories',
            'departments'
        ));
    }

    /**
     * Menampilkan form tambah surat keluar.
     */
    public function create()
    {
        $categories = LetterCategory::where('is_active', true)
            ->orderBy('category_name')
            ->get();

        $departments = Department::where('is_active', true)
            ->orderBy('department_name')
            ->get();

        return view('outgoing-letters.create', compact(
            'categories',
            'departments'
        ));
    }

    /**
     * Menyimpan surat keluar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_number' => ['required', 'string', 'max:100', 'unique:outgoing_letters,letter_number'],
            'category_id' => ['nullable', 'integer', 'exists:letter_categories,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'recipient' => ['required', 'string', 'max:150'],
            'subject' => ['required', 'string', 'max:200'],
            'letter_date' => ['nullable', 'date'],
            'sent_date' => ['nullable', 'date'],
            'summary' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,sent'],
            'notes' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $storedPath = null;

        try {
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');

                $storedPath = $file->storeAs(
                    'outgoing-letters',
                    Str::uuid() . '.pdf',
                    'local'
                );
            }

            DB::transaction(function () use ($validated, $storedPath, $request) {
                $outgoingLetter = OutgoingLetter::create([
                    'letter_number' => $validated['letter_number'],
                    'category_id' => $validated['category_id'] ?? null,
                    'department_id' => $validated['department_id'] ?? null,
                    'recipient' => $validated['recipient'],
                    'subject' => $validated['subject'],
                    'letter_date' => $validated['letter_date'] ?? null,
                    'sent_date' => $validated['sent_date'] ?? null,
                    'summary' => $validated['summary'] ?? null,
                    'status' => $validated['status'],
                    'notes' => $validated['notes'] ?? null,
                    'created_by' => Auth::id(),
                ]);

                if ($storedPath) {
                    $file = $request->file('attachment');

                    $outgoingLetter->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $storedPath,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'uploaded_by' => Auth::id(),
                    ]);
                }
            });
        } catch (\Throwable $e) {
            if ($storedPath) {
                Storage::disk('local')->delete($storedPath);
            }

            throw $e;
        }

        return redirect()
            ->route('outgoing-letters.index')
            ->with('success', 'Surat keluar berhasil disimpan.');
    }

    /**
     * Menampilkan detail surat keluar.
     */
    public function show(OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load([
            'category',
            'department',
            'creator',
            'attachments',
        ]);

        return view('outgoing-letters.show', compact('outgoingLetter'));
    }

    /**
     * Melihat lampiran PDF.
     */
    public function viewAttachment(
        OutgoingLetter $outgoingLetter,
        LetterAttachment $attachment
    ) {
        abort_unless(
            $outgoingLetter->attachments()
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


    /**
     * Menerbitkan lampiran PDF agar dapat diverifikasi secara publik.
     */
    public function publishAttachment(
        OutgoingLetter $outgoingLetter,
        LetterAttachment $attachment
    ) {
        // Memastikan lampiran benar-benar milik surat keluar ini.
        $attachment = $outgoingLetter->attachments()
            ->whereKey($attachment->id)
            ->firstOrFail();

        // Hanya PDF yang boleh diterbitkan.
        abort_unless(
            strtolower(pathinfo($attachment->original_name, PATHINFO_EXTENSION)) === 'pdf',
            422,
            'Hanya file PDF yang dapat diterbitkan.'
        );

        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($attachment->file_path),
            404,
            'File PDF tidak ditemukan.'
        );

        // Menghitung hash SHA-256 dari file PDF.
        $fileHash = hash_file(
            'sha256',
            $disk->path($attachment->file_path)
        );

        abort_if(
            $fileHash === false,
            500,
            'Gagal menghitung hash dokumen.'
        );

        // Membuat ID publik jika belum pernah dibuat.
        $publicId = $attachment->public_id;

        if (!$publicId) {
            do {
                $publicId = 'SIRKA-OUT-' . strtoupper(Str::random(10));
            } while (
                LetterAttachment::where('public_id', $publicId)->exists()
            );
        }

        // Membuat token baru setiap kali dokumen diterbitkan.
        // Token lama otomatis tidak berlaku lagi setelah penerbitan ulang.
        do {
            $publicToken = Str::random(64);
        } while (
            LetterAttachment::where('public_token', $publicToken)->exists()
        );

        $attachment->update([
            'public_id' => $publicId,
            'public_token' => $publicToken,
            'file_hash' => $fileHash,
            'is_public' => true,
            'published_at' => now(),
            'revoked_at' => null,
        ]);

        return redirect()
            ->route('outgoing-letters.show', $outgoingLetter)
            ->with('success', 'Dokumen berhasil diterbitkan dan dapat diverifikasi.');
    }

    /**
     * Mencabut akses publik dokumen.
     */
    public function revokeAttachment(
        OutgoingLetter $outgoingLetter,
        LetterAttachment $attachment
    ) {
        $attachment = $outgoingLetter->attachments()
            ->whereKey($attachment->id)
            ->firstOrFail();

        abort_unless(
            $attachment->is_public,
            404,
            'Dokumen belum diterbitkan.'
        );

        $attachment->update([
            'is_public' => false,
            'revoked_at' => now(),
        ]);

        return redirect()
            ->route('outgoing-letters.show', $outgoingLetter)
            ->with('success', 'Akses publik dokumen berhasil dicabut.');
    }


    /**
     * Mengunduh lampiran PDF.
     */
    public function downloadAttachment(
        OutgoingLetter $outgoingLetter,
        LetterAttachment $attachment
    ) {
        abort_unless(
            $outgoingLetter->attachments()
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