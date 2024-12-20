<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortURLVisitCount extends Model
{
    use HasFactory;


    protected $fillable = ['short_url_id', 'user_id', 'count'];
}