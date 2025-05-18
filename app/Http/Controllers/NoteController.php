<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Auth::user()->notes()
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest();

        $sharedNotes = Auth::user()->sharedNotes()
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest();

        $notes = $query->paginate(10);
        $shared = $sharedNotes->paginate(10);

        return view('notes.index', compact('notes', 'shared'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Auth::user()->notes()->create($validated);

        return redirect()->route('notes.index')
            ->with('success', 'Note created successfully.');
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note);
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $this->authorize('update', $note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($validated);

        return redirect()->route('notes.show', $note)
            ->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Note deleted successfully.');
    }

    public function share(Request $request, Note $note)
    {
        $this->authorize('share', $note);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'permission' => 'required|in:view,edit',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot share a note with yourself.');
        }

        $note->sharedWith()->syncWithoutDetaching([
            $user->id => ['permission' => $validated['permission']]
        ]);

        return back()->with('success', 'Note shared successfully.');
    }

    public function unshare(Request $request, Note $note, User $user)
    {
        $this->authorize('share', $note);
        $note->sharedWith()->detach($user->id);

        return back()->with('success', 'Note sharing removed successfully.');
    }
} 