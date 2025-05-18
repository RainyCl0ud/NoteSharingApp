<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Note $note)
    {
        if ($user->id === $note->user_id) {
            return true;
        }

        return $note->sharedWith()
            ->where('shared_with_user_id', $user->id)
            ->exists();
    }

    public function update(User $user, Note $note)
    {
        if ($user->id === $note->user_id) {
            return true;
        }

        return $note->sharedWith()
            ->where('shared_with_user_id', $user->id)
            ->where('permission', 'edit')
            ->exists();
    }

    public function delete(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }

    public function share(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }
} 