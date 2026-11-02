<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\LetterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'destination' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
        ]);

        IncomingLetter::create([
            ...$validated,
            'status' => 'registered',
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('incoming-letters.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }
}
