<?php

namespace CMS\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Storage;

class Action
{
    public static function trash(Request $r,$table)
    {
        $key = Pluralizer::singular($table).'_id';
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['trashed' => 1]);
    }
    public static function restore(Request $r,$table)
    {
        $key = Pluralizer::singular($table).'_id';
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['trashed' => 0]);
    }
    public static function hide(Request $r,$table)
    {
        $key = Pluralizer::singular($table).'_id';
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['approved' => 0]);
    }
    public static function approve(Request $r,$table)
    {
        $key = Action::createKey($table);
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['approved' => 1]);
    }

    public static function remove(Request $r,$table)
    {
        $parents = $r['checkbox'];
        $key = Pluralizer::singular($table).'_id';
        if($table == 'folders'){
            // Delete all folders/files and subdirectories
            foreach($parents as $parent){
                $folder = Folder::findOrFail($parent);
                Storage::deleteDirectory($folder->path);
            }
        }

        Folder::delete_recursive($parents,$table,$key);
       
    }
}
