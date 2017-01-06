<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $primaryKey = 'upload_id';
    public $table = 'uploads';
    protected $fillable = [
        'name',
        'type',
        'size',
        'file_name',
        'file_path'
    ];

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
