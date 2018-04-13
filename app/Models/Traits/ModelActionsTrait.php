<?php

namespace CMS\Models\Traits;

use Illuminate\Http\Request;


Trait Actions
{
    public function destroy()
    {
        $this->delete();
    }

    public function hide()
    {
        $this->approved = 0;
        $this->save();
    }

    public function approve()
    {
        $this->approved = 1;
        $this->save();

        return back();
    }

    public function trash($keys= null)
    {
        if($keys != null && is_array($keys)){

            $this->whereIn($this->primaryKey, $keys)->update(['trashed' => 1,'approved' => 0]);
        } else {
            $this->trashed = 1;
            $this->approved = 0;
            $this->save();
        }

        return back();
    }

    public function restore($keys)
    {
        $this->trashed = 0;
        $this->approved = 1;
        $this->save();

        return back();
    }

    public function actions(Request $r)
    {
        if(isset($r['trash-selected'])){
            $this->trash($r['checkbox']);
        }
        if(isset($r['approve-selected'])){

            Action::approve($r['checkbox']);
        }
        if(isset($r['hide-selected'])){

            Action::hide($r['checkbox']);
        }
        if(isset($r['restore-selected'])){

            Action::restore($r['checkbox']);
        }
        if(isset($r['delete-selected'])){
            Action::remove($r['checkbox']);
        }
    }
//    public static function hide($this,$keys)
//    {
//        $key = Pluralizer::singular($this->table).'_id';
//        $keys = (!is_array($keys)) ? [(int)$keys] : $keys;
//
//        $this->whereIn($key, $keys)->update(['approved' => 0]);
//    }
//    public static function approve($this,$keys)
//    {
//        $key = Pluralizer::singular($this->table).'_id';
//        $keys = (!is_array($keys)) ? [(int)$keys] : $keys;
//
//        $this->whereIn($key, $keys)->update(['approved' => 1]);
//    }
//
//
//    public static function remove(Request $r,$table)
//    {
//        $key = Pluralizer::singular($table).'_id';
//
//        if($table == 'folders'){
//            $parents = $r['checkbox'];
//            // Delete all folders/files and subdirectories
//            foreach($parents as $parent){
//                $folder = Folder::findOrFail($parent);
//                Storage::deleteDirectory($folder->path);
//            }
//            Folder::delete_recursive($parents,$key);
//        }
//
//        if($table == 'uploads'){
//            $data = DB::table($table)->select('file_path')->whereIn($key, $r['checkbox'])->get();
//            foreach ($data as $path) {
//               $paths[] = 'public/'.$path->file_path;
//            };
//            Storage::delete($paths);
//
//            DB::table($table)->whereIn($key, $r['checkbox'])->delete();
//        }
//    }
}
