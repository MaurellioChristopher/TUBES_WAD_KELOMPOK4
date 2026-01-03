<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningGoal extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'user_id',
        'skill_id',
        'topic_id',
        'title',
        'description',
        'target_date',
        'status',
        'progress',
        'notes',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'target_date' => 'date',
        'progress'    => 'integer',
    ];

    /**
     * ======================
     * Relationships
     * ======================
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * ======================
     * Query Scopes
     * ======================
     */

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeNotStarted($query)
    {
        return $query->where('status', 'not_started');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['not_started', 'in_progress']);
    }

    /**
     * ======================
     * Accessors
     * ======================
     */

    public function getStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    /**
     * ======================
     * Mutators / Helpers
     * ======================
     */

    public function updateProgressAutomatically()
    {
        if ($this->status === 'completed') {
            $this->progress = 100;
        } elseif ($this->status === 'in_progress' && $this->progress === 0) {
            $this->progress = 50;
        }

        $this->save();
    }
}
