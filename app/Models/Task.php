<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'priority', 'project_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            if (!$task->priority) {
                $maxPriority = static::where('project_id', $task->project_id)
                    ->max('priority') ?? 0;
                $task->priority = $maxPriority + 1;
            }
        });

        static::deleted(function ($task) {
            static::where('project_id', $task->project_id)
                ->where('priority', '>', $task->priority)
                ->decrement('priority');
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeForProject($query, $projectId = null)
    {
        if ($projectId) {
            return $query->where('project_id', $projectId);
        }
        return $query;
    }
}