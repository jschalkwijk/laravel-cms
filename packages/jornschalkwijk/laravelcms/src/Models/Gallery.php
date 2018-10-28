<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $primaryKey = 'gallery_id';

    protected $fillable = [
        'name',
    ];

    public $table = "galleries";

    public function uploads()
    {
        return $this->belongsToMany(Upload::class,"galleries_uploads","gallery_id","upload_id");
    }
}
