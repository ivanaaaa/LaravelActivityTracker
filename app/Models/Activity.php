<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;


    protected $fillable = [
        'duration',
        'description',
    ];

    protected $casts = [
        'activity_date' => 'date:m-d-Y',
        'created_at' => 'date:m-d-Y'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
