<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // hasMany
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
