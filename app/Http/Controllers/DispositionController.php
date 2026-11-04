<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispositionController extends Controller
{
    public function create(IncomingLetter $incomingLetter)
    {
        $departments = Department::where('is_active', true)
            ->orderBy('department_name')
            ->get();

        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dispositions.create', compact(
            'incomingLetter',
            'departments',
            'users'
        ));
    }

    public function store(Request $request, IncomingLetter $incomingLetter)
    {
        $validated = $request->validate([
            'to_user_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'to_department_id' => [
                'nullable',
                'integer',
                'exists:departments,id',
            ],
            'instruction' => [
                'required',
                'string',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
            'deadline' => [
                'nullable',
                'date',
            ],
        ]);

        // Tujuan disposisi harus memilih tepat satu:
        // pengguna tertentu atau departemen.
        $toUserId = $validated['to_user_id'] ?? null;
        $toDepartmentId = $validated['to_department_id'] ?? null;

        if (($toUserId && $toDepartmentId) || (!$toUserId && !$toDepartmentId)) {
            return back()
                ->withInput()
                ->withErrors([
                    'destination' => 'Pilih satu tujuan disposisi, yaitu pengguna atau departemen.',
                ]);
        }

        // Pastikan pengguna tujuan masih aktif.
        if ($toUserId && !User::where('id', $toUserId)->where('is_active', true)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'to_user_id' => 'Pengguna tujuan tidak aktif atau tidak ditemukan.',
                ]);
        }

        // Pastikan departemen tujuan masih aktif.
        if ($toDepartmentId && !Department::where('id', $toDepartmentId)->where('is_active', true)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'to_department_id' => 'Departemen tujuan tidak aktif atau tidak ditemukan.',
                ]);
        }

        Disposition::create([
            'incoming_letter_id' => $incomingLetter->id,
            'from_user_id' => Auth::id(),
            'to_user_id' => $toUserId,
            'to_department_id' => $toDepartmentId,
            'instruction' => $validated['instruction'],
            'notes' => $validated['notes'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('incoming-letters.show', $incomingLetter->id)
            ->with('success', 'Disposisi surat berhasil dibuat.');
    }
}
