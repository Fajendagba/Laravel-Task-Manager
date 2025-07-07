<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $project->slug = Str::slug($project->name);
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('priority');
    }

    public function getTaskCountAttribute()
    {
        return $this->tasks()->count();
    }
}