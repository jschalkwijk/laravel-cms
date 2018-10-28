<?php
    /**
     * Created by PhpStorm.
     * User: jorn
     * Date: 03-11-17
     * Time: 11:11
     */

    namespace JornSchalkwijk\LaravelCMS\Models;

    use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
    use Illuminate\Database\Eloquent\Model;
    class Comment extends Model
    {
        use ModelActionsTrait;
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

        public function user()
        {
            return $this->belongsTo(User::class,'user_id');
        }

        public function id()
        {
//          return $this->${$this->primaryKey};
            return $this->comment_id;
        }

    }