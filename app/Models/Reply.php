<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use ModelActionsTrait;
    protected $primaryKey = 'reply_id';

    protected $fillable = [
        'comment_id',
        'content'
    ];

    public $table = "replies";

    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function id()
    {
        return $this->reply_id;
    }
}
