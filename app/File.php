<?php

namespace CMS;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $primaryKey = 'file_id';
    public $table = 'files';
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
    public function id()
    {
        return $this->file_id;
    }
    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->name);
    }
}
