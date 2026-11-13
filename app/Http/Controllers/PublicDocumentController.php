<?php

namespace App\Http\Controllers;

use App\Models\LetterAttachment;
use App\Models\OutgoingLetter;
use Illuminate\Support\Facades\Storage;

class PublicDocumentController extends Controller
{
    /**
     * Menampilkan halaman verifikasi dokumen publik.
     */
    public function verify(string $token)
    {
        $attachment = LetterAttachment::with('letter')
            ->where('public_token', $token)
            ->where('letter_type', (new OutgoingLetter())->getMorphClass())
            ->where('is_public', true)
            ->whereNotNull('published_at')
            ->whereNull('revoked_at')
            ->first();

        abort_unless($attachment, 404);

        abort_unless(
            Storage::disk('local')->exists($attachment->file_path),
            404
        );

        return view('public-documents.verify', compact('attachment'));
    }

    /**
     * Menampilkan PDF yang sudah diterbitkan.
     */
    public function view(string $token)
    {
        $attachment = LetterAttachment::query()
            ->where('public_token', $token)
            ->where('letter_type', (new OutgoingLetter())->getMorphClass())
            ->where('is_public', true)
            ->whereNotNull('published_at')
            ->whereNull('revoked_at')
            ->first();

        abort_unless($attachment, 404);

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
}