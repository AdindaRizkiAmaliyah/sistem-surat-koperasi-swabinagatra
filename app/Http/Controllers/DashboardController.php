<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\Disposition;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $incoming = IncomingLetter::query();
        $outgoing = OutgoingLetter::query();
        $dispositions = Disposition::query();

        // Admin dan sekretaris dapat melihat seluruh data.
        // Staff hanya melihat data yang berkaitan dengan dirinya.
        if (!in_array($user->role, ['admin', 'sekretaris'], true)) {

            $incoming->whereHas('dispositions', function ($query) use ($user) {
                $query->where(function ($target) use ($user) {
                    $target->where('to_user_id', $user->id);

                    if ($user->department_id) {
                        $target->orWhere(
                            'to_department_id',
                            $user->department_id
                        );
                    }
                });
            });

            $dispositions->where(function ($query) use ($user) {
                $query->where('to_user_id', $user->id);

                if ($user->department_id) {
                    $query->orWhere(
                        'to_department_id',
                        $user->department_id
                    );
                }
            });

            if ($user->department_id) {
                $outgoing->where(
                    'department_id',
                    $user->department_id
                );
            } else {
                $outgoing->whereRaw('1 = 0');
            }
        }

        // =========================
        // SURAT MASUK
        // =========================

        $incomingCount = (clone $incoming)->count();

        $todayIncomingCount = (clone $incoming)
            ->whereDate('received_date', today())
            ->count();

        $undisposedCount = (clone $incoming)
            ->whereDoesntHave('dispositions')
            ->count();

        $latestAgenda = (clone $incoming)
            ->latest('received_date')
            ->value('agenda_number') ?? '—';

        $latestIncoming = (clone $incoming)
            ->with(['category', 'creator', 'attachments'])
            ->latest('received_date')
            ->paginate(8, ['*'], 'incoming_page')
            ->withQueryString();

        // =========================
        // DISPOSISI
        // =========================

        $dispositionCount = (clone $dispositions)->count();

        $pendingDispositionCount = (clone $dispositions)
            ->where('status', 'pending')
            ->count();

        $completedDispositionCount = (clone $dispositions)
            ->whereNotNull('completed_at')
            ->count();

        $processingDispositionCount = max(
            0,
            $dispositionCount
            - $pendingDispositionCount
            - $completedDispositionCount
        );

        $latestDispositions = (clone $dispositions)
            ->with(['incomingLetter', 'department', 'recipient'])
            ->latest()
            ->take(8)
            ->get();

        // =========================
        // SURAT KELUAR
        // =========================

        $outgoingCount = (clone $outgoing)->count();

        $thisMonthOutgoingCount = (clone $outgoing)
            ->whereMonth('letter_date', now()->month)
            ->whereYear('letter_date', now()->year)
            ->count();

        $draftOutgoingCount = (clone $outgoing)
            ->where('status', 'draft')
            ->count();

        $latestOutgoing = (clone $outgoing)
            ->with(['category', 'department', 'creator', 'attachments'])
            ->latest('letter_date')
            ->take(8)
            ->get();

        // =========================
        // ARSIP SURAT
        // =========================

        $archiveItems = collect();

        $incomingArchives = (clone $incoming)
            ->with(['category', 'attachments'])
            ->get();

        foreach ($incomingArchives as $letter) {
            foreach ($letter->attachments as $attachment) {
                $archiveItems->push([
                    'number' => $letter->letter_number
                        ?: $letter->agenda_number,

                    'type' => 'Surat Masuk',
                    'subject' => $letter->subject,

                    'category' => $letter->category->category_name
                        ?? '—',

                    'date' => optional($letter->received_date)
                        ->format('d M Y'),
                ]);
            }
        }

        $outgoingArchives = (clone $outgoing)
            ->with(['category', 'attachments'])
            ->get();

        foreach ($outgoingArchives as $letter) {
            foreach ($letter->attachments as $attachment) {
                $archiveItems->push([
                    'number' => $letter->letter_number,
                    'type' => 'Surat Keluar',
                    'subject' => $letter->subject,

                    'category' => $letter->category->category_name
                        ?? '—',

                    'date' => optional(
                        $letter->sent_date ?: $letter->letter_date
                    )->format('d M Y'),
                ]);
            }
        }

        $archiveCount = $archiveItems->count();

        // =========================
        // KIRIM DATA KE DASHBOARD
        // =========================

        return view('dashboard.index', compact(
            'user',

            'incomingCount',
            'todayIncomingCount',
            'undisposedCount',
            'latestAgenda',
            'latestIncoming',

            'dispositionCount',
            'pendingDispositionCount',
            'completedDispositionCount',
            'processingDispositionCount',
            'latestDispositions',

            'outgoingCount',
            'thisMonthOutgoingCount',
            'draftOutgoingCount',
            'latestOutgoing',

            'archiveItems',
            'archiveCount'
        ));
    }
}
