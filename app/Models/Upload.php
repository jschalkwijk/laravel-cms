<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use ModelActionsTrait;
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
        return $this->belongsTo(User::class,'user_id');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function id()
    {
        return $this->upload_id;
    }

    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->name);
    }

    public function path(string $size = null): string
    {
        if($size == null || $size == 'original'){
            $sizePath = 'uploads/original/';
        } else {
            $sizePath = 'uploads/'.$size.'/';
        }
        $path = substr_replace($this->file_name,'/',1,0);
        $path = substr_replace($path,'/',4,0);
        $path = substr_replace($path,'/',8,0);
        $path = substr($path,0,9);

        return $sizePath.$path.$this->file_name;
    }

    public function removeMany(array $keys)
    {
        $key = $this->primaryKey;

        if($this->table == 'uploads'){
            $data = $this->whereIn($key, $keys)->get('file_path');
            foreach ($data as $path) {
                $paths[] = 'public/'.$path->file_path;
            };
            Storage::delete($paths);

            $this->whereIn($key, $keys)->delete();
        }
    }
}
