<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('department')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('users.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                Rule::in(['admin', 'sekretaris', 'ketua', 'bendahara', 'staff']),
            ],
            'department_id' => ['nullable', 'exists:departments,id'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'department_id' => $validated['department_id'] ?? null,
            'is_active' => true,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $departments = Department::orderBy('name')->get();

        return view('users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => [
                'required',
                Rule::in(['admin', 'sekretaris', 'ketua', 'bendahara', 'staff']),
            ],
            'department_id' => ['nullable', 'exists:departments,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->department_id = $validated['department_id'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak dapat menonaktifkan akun sendiri.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Status pengguna berhasil diperbarui.');
    }
}
