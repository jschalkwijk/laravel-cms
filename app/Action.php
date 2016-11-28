<?php

namespace CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Action extends Model
{
    public static function trash(Request $r,$table)
    {
        $key = substr($table, 0, -1).'_id';
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['trashed' => 1]);
    }
    public static function restore(Request $r,$table)
    {
        $key = substr($table, 0, -1).'_id';
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['trashed' => 0]);
    }
    public static function hide(Request $r,$table)
    {
        $key = substr($table, 0, -1).'_id';
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['approved' => 0]);
    }
    public static function approve(Request $r,$table)
    {
        $key = substr($table, 0, -1).'_id';
        DB::table($table)->whereIn($key, $r['checkbox'])->update(['approved' => 1]);
    }
}
