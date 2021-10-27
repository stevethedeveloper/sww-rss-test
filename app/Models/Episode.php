<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Episode extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Define relation: Episode belongs to Podcast
     *
     * @return Podcast
     */
    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }
}
