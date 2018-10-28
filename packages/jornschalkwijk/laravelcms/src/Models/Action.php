<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Storage;

class Action
{
    public static function trash($model,$keys)
    {
        $key = Pluralizer::singular($model->table).'_id';
        $keys = (!is_array($keys)) ? [(int)$keys] : $keys;

        $model->whereIn($key, $keys)->update(['trashed' => 1,'approved' => 0]);
    }
    public static function restore($model,$keys)
    {
        $key = Pluralizer::singular($model->table).'_id';
        $keys = (!is_array($keys)) ? [(int)$keys] : $keys;

        $model->whereIn($key, $keys)->update(['trashed' => 0]);
    }
    public static function hide($model,$keys)
    {
        $key = Pluralizer::singular($model->table).'_id';
        $keys = (!is_array($keys)) ? [(int)$keys] : $keys;

        $model->whereIn($key, $keys)->update(['approved' => 0]);
    }
    public static function approve($model,$keys)
    {
        $key = Pluralizer::singular($model->table).'_id';
        $keys = (!is_array($keys)) ? [(int)$keys] : $keys;

        $model->whereIn($key, $keys)->update(['approved' => 1]);
    }


    public static function remove(Request $r,$table)
    {
        $key = Pluralizer::singular($table).'_id';

        if($table == 'folders'){
            $parents = $r['checkbox'];
            // Delete all folders/files and subdirectories
            foreach($parents as $parent){
                $folder = Folder::findOrFail($parent);
                Storage::deleteDirectory($folder->path);
            }
            Folder::delete_recursive($parents,$key);
        }

        if($table == 'uploads'){
            $data = DB::table($table)->select('file_path')->whereIn($key, $r['checkbox'])->get();
            foreach ($data as $path) {
               $paths[] = 'public/'.$path->file_path;
            };
            Storage::delete($paths);

            DB::table($table)->whereIn($key, $r['checkbox'])->delete();
        }
    }
}
