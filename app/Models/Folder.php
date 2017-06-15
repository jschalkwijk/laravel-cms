<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folder extends Model
{
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
}
