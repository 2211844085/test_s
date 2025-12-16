<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'project_id',
        'amount',
        'title',
        'desc'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
