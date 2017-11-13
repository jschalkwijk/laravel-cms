<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $primaryKey = 'reply_id';

    protected $fillable = [
        'comment_id',
        'content'
    ];

    protected $table = "replies";

    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id');
}
}
