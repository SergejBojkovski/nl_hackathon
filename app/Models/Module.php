<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = ["name", "order"];

    public function courses(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
