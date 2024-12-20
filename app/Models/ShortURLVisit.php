<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ShortURLVisit extends Model
{
    use HasFactory;
    protected $table = 'short_urls_visits'; 
    protected $guarded = [];

    public const DEVICE_TYPE_MOBILE = 'mobile';

    public const DEVICE_TYPE_DESKTOP = 'desktop';

    public const DEVICE_TYPE_TABLET = 'tablet';

    public const DEVICE_TYPE_ROBOT = 'robot'; 
}
