<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'title',
        'short_desc',
        'full_desc',
        'deadline',
        'funding_goal',
        'status',
        'image'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function tiers()
    {
        return $this->hasMany(Tier::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function affectedLogs()
    {
        return $this->hasMany(AdminLog::class, 'project_affected_id');
    }

    public function refund()
    {
        foreach ($this->tiers->flatMap->donations as $donation) {
            $donation->update(['refunded' => true]);
        }
    }
}