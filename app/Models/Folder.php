<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Storage;

class Folder extends Model
{
    use ModelActionsTrait;
    protected $primaryKey = 'folder_id';
    public $table = 'folders';
    protected $fillable = [
        'name',
    ];

    public function files() {
        return $this->hasMany(Upload::class);
    }

    public function id()
    {
        return $this->folder_id;
    }
    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->name);
    }

    /**
     * @param Request $r
     * @return Folder
     */
    public static function create(Request $r): Folder {
        $create = false;
        $folder = new Folder($r->all());
        $folder->user_id = Auth::user()->user_id;
        if(!isset($r['parent']) && !empty($r['name'])) {
            $create = true;
            $folder->path = "/public/uploads/".$folder->name;
        } else if(!isset($r['parent']) && empty($r['name']) && $r['destination'] == 0){
            return back();
        }
        // if: upload to destination folder instead of current parent folder.
        // else: upload to new folder inside the destination folder.
        if($r['destination'] != 0 && !empty($r['name']) ){
            $create = true;
            $parent = Folder::findOrFail($r['destination']);
            $folder->path = $parent->path.'/'.$folder->name;
            $folder->parent_id = $parent->id();
        } else if($r['destination'] != 0 && empty($r['name'])){
            $folder = Folder::findOrFail($r['destination']);
        } else if($r['destination'] == 0 && empty($r['name']) && isset($r['parent'])){
            $folder = Folder::findOrFail($r['parent']);
        }  else if($r['destination'] == 0 && isset($r['parent']) && !empty($r['name'])){
            $create = true;
            $parent = Folder::findOrFail($r['parent']);
            $folder->path = $parent->path.'/'.$folder->name;
            $folder->parent_id = $parent->id();
        }


        if ($create) {
            $result = Storage::makeDirectory($folder->path, 0775);
            $result = Storage::makeDirectory($folder->path.'/thumbs', 0775);
            if ($result) {
                $folder->save($r->all());
            } else {
                echo "Folder not created";
            }
        }
        return $folder;
    }

    /**
     * @param array $parents
     */
    public static function delete_recursive(array $parents)
    {
        //(!empty($row['folder_id']))? $folders_id = [$id,$row['folder_id']] : $folders_id = [$id];
        // checks if the row from the db is not empty,
        // if not, selects the id to the parent id,row[id], so we can get,
        // all children from the top deleted folder.
        /* Example:
         * $id = 5 (Folder Users)
         * $row[folder_id] = 24 ( user admin has parent_id 5, the folder Users)
         * Then again we check if there are folders with a parent_id of 24
         * if there is, add it to the array of folder_id's to delete.
         * In this case there is.
         * $row['folder_id'] = 22 (admins contacts folder) has a parent_id of 24
         * This goes on until there are no folders left with a parent_id of 22 in this case.
        */
        $folders = array();
        foreach ($parents as $parent){
            $folders[] = $parent;
        }

        while(sizeof($parents) > 0){
            $folder = Folder::whereIn('parent_id',$parents)->get();
            $parents = array();
            // because we now have a new row[folder_id], we need to check again if its empty,
            // if it is not, push it to the array.
            //if it is, don't push it, en the loop will end with the while clause.
            if(!$folder->isEmpty()){
                foreach($folder as $f) {
                    // For each rows doen! multiple albums ids might be returned
                    $folders[] = $f->folder_id;
                    $parents[] = $f->folder_id;
                }
            }
        }

        Folder::destroy($folders);
        // Remove possible uploaded files in the removed folders from the database
        Upload::whereIn('folder_id',$folders)->delete();
    }

    public function removeMany(array $keys)
    {
        $key = $this->primaryKey;

        $parents = $keys;
        // Delete all folders/files and subdirectories
        foreach($parents as $parent){
            $folder = Folder::findOrFail($parent);
            Storage::deleteDirectory($folder->path);
        }
        Folder::delete_recursive($parents,$key);
    }
}
