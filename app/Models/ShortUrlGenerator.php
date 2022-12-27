<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrlGenerator extends Model
{
    use HasFactory;


    protected $table = 'shortest_url';
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $guarded = [];
}
