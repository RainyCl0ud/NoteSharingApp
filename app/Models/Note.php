<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'content',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($note) {
            $note->uuid = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'note_shares', 'note_id', 'shared_with_user_id')
            ->withPivot('permission')
            ->withTimestamps();
    }
} 