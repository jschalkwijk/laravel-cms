<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use CMS\Models\Traits\ModelActionsTrait;
class Page extends Model
{
    use ModelActionsTrait;
    protected $primaryKey = 'page_id';
    public $table = 'pages';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'template',
        'created_at',
        'updated_at'
    ];

    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->title);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function id()
    {
        return $this->page_id;
    }
}
