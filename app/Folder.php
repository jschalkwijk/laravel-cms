<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $primaryKey = 'folder_id';
    public $table = 'folders';

    public function files() {
        return $this->hasMany(File::class);
    }

    public function id()
    {
        return $this->folder_id;
    }
    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->name);
    }
}
