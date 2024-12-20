<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ShortURL extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'short_urls'; 

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function findByUrlKey(string $urlKey): ?self
    {
        return self::where('url_key', $urlKey)->first();
    }
}
