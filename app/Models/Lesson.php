<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = ["title", "content", "video_url", "order_number"];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
