<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Skill Model
 * Handle skill entity and relationships
 */
class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
    return $query;
    }

    public function scopeOrdered($query)
    {
    return $query->orderBy('name');
    }
}