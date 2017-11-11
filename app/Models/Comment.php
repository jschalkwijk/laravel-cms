<?php
    /**
     * Created by PhpStorm.
     * User: jorn
     * Date: 03-11-17
     * Time: 11:11
     */

    namespace CMS\Models;

    use Illuminate\Database\Eloquent\Model;
    class Comment extends Model
    {
        protected $primaryKey = 'comment_id';

        protected $fillable = [
            'post_id',
            'title',
            'content'
        ];

        public $table = "comments";

        public function replies()
        {
         return $this->hasMany(Reply::class,'comment_id');
        }

        public function post()
        {
            return $this->belongsTo(Post::class,'post_id');
        }

    }