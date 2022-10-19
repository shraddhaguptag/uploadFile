<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * 
     */
    protected $fillable = [
        'user_id',
        'title',
    ];


}