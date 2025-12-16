<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null;
    protected $fillable = [
        'backer_id',
        'tier_id',
        'amount'
    ];

    public function backer()
    {
        return $this->belongsTo(User::class, 'backer_id');
    }
    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }
}
