<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;
    protected $table = 'user_activities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'points',
        'activity_date',
    ];

    protected $hidden = [];
    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
