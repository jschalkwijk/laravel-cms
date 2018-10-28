<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Support\Collection;
use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Storage;
use ScoutElastic\Searchable;
use JornSchalkwijk\LaravelCMS\Models\Elasticsearch\FolderIndexConfigurator;

class Folder extends Model
{
    use ModelActionsTrait;

    use Searchable;

    protected $indexConfigurator = FolderIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    // Here you can specify a mapping for a model fields.
    protected $mapping = [
        'properties' => [
            'folder_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'name' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'english'
                    ]
                ]
            ],
            'description' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'english'
                    ]
                ]
            ],
            'parent_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'created_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'index' => 'not_analyzed',
            ],
            'updated_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'index' => 'not_analyzed'
            ]
        ]
    ];

    protected $primaryKey = 'folder_id';
    public $table = 'folders';

    protected $fillable = [
        'name',
    ];

    public function files() {
        return $this->belongsToMany(Upload::class,"folders_uploads","folder_id","upload_id");
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
        } else if(!isset($r['parent']) && empty($r['name']) && $r['destination'] == 0){
            return back();
        }
        // if: upload to destination folder instead of current parent folder.
        // else: upload to new folder inside the destination folder.
        if($r['destination'] != 0 && !empty($r['name']) ){
            $create = true;
            $parent = Folder::findOrFail($r['destination']);
//            $folder->path = $parent->path.'/'.$folder->name;
            $folder->parent_id = $parent->id();
        } else if($r['destination'] != 0 && empty($r['name'])){
            $folder = Folder::findOrFail($r['destination']);
        } else if($r['destination'] == 0 && empty($r['name']) && isset($r['parent'])){
            $folder = Folder::findOrFail($r['parent']);
        }  else if($r['destination'] == 0 && isset($r['parent']) && !empty($r['name'])){
            $create = true;
            $parent = Folder::findOrFail($r['parent']);
//            $folder->path = $parent->path.'/'.$folder->name;
            $folder->parent_id = $parent->id();
        }
        if ($create) {
                $folder->save($r->all());

        }

        return $folder;
    }

    public function createPathFromFileName($file_name): string
    {
        $path = substr_replace($file_name,'/',1,0);
        $path = substr_replace($path,'/',4,0);
        $path = substr_replace($path,'/',8,0);
        $path = substr($path,0,9);
        return $path;
    }

    public function createDirFromFileName($file_name)
    {
        $destination = $this->createPathFromFileName($file_name);
        $paths = [
            "/public/uploads/original/".$destination,
            "/public/uploads/thumbnail/".$destination,
            "/public/uploads/small/".$destination,
            "/public/uploads/medium/".$destination,
            "/public/uploads/medium_large/".$destination,
            "/public/uploads/large/".$destination,
        ];
        foreach ($paths as $path){
            if(!Storage::exists($path)){
                if(!Storage::makeDirectory($path, 0775)){
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
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
         * Then again Mowe check if there are folders with a parent_id of 24
         * if there is, add it to the array of folder_id's to delete.
         * In this case there is.
         * $row['folder_id'] = 22 (admins contacts folder) has a parent_id of 24
         * This goes on until there are no folders left with a parent_id of 22 in this case.
        */
        $folders = array();
        // The Upload models of al the files that are to be deleted
        $uploads = [];
        // The Upload model id's of al the folders that are to be deleted
        $upload_ids = [];
        foreach ($parents as $parent){
            $folders[] = $parent;
            $folder = Folder::find($parent);
            foreach ($folder->files as $upload){
                if(!in_array($upload,$uploads)) {
                    $upload_ids[] = $upload->upload_id;
                    $uploads[] = $upload;
                }
            }
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
                    foreach ($f->files as $upload){
                        if(!in_array($upload,$uploads)) {
                            $upload_ids[] = $upload->upload_id;
                            $uploads[] = $upload;
                        }
                    }
                }
            }
        }

        Folder::destroy($folders);
        // The folders where deleted and the filesdetached from the pivot table, but the file still remains in the uploads table.

        // Get the uploads that are still existing in the pivot table that are in the upload_ids array. If there are files that where
        // detached from the pivot table when the folder was deleted but still are attached to another folder, we should not delete those from
        //the uploads table and the filesystem. We compare all the id's gatherd from the delete folders and get back an array with the existing ones.
        $reference = DB::table('folders_uploads')->select()->whereIn('upload_id',$upload_ids)->pluck('upload_id')->toArray();

        // Get array with the uploads that are not present in any folder. This will return all the upload id's except that are not attached to any folder anymore.
        $uploads_to_delete = array_diff($upload_ids,$reference);;

        // Make a collection of the array with Upload models.
        $uploads = Collection::make($uploads);

        // delete the uploads that are not attached to any folder from the filesystem and the uploads table.
        foreach ($uploads->whereIn('upload_id',$uploads_to_delete) as $upload ) {
            Storage::delete([
                'public/' . $upload->path('original'),
                'public/' . $upload->path('thumbnail'),
                'public/' . $upload->path('small'),
                'public/' . $upload->path('medium'),
                'public/' . $upload->path('medium_large'),
                'public/' . $upload->path('large')
            ]);
        }

        //delete the reference to the upload in the uploads table.
        Upload::destroy($uploads_to_delete);

    }

//    /**
//     * @param array $parents
//     */
//    public static function delete_recursive(array $parents)
//    {
////          $sql= "WITH folder_recursive(folder_id) AS (SELECT a.folder_id, a.parent_id FROM folders a WHERE folder_id IN (".rtrim(str_repeat ( '?' , count($parents) ),',').") UNION ALL SELECT a.folder_id, a.parent_id FROM folders a JOIN folder_recursive c ON a.parent_id = c.folder_id) SELECT * FROM folder_recursive";
////          $folders = DB::select($sql,$parents);
//        $sql = "WITH folder_recursive(folder_id) AS (SELECT a.folder_id, a.parent_id FROM folders a WHERE folder_id IN (".implode(',',$parents).") UNION ALL SELECT a.folder_id, a.parent_id FROM folders a JOIN folder_recursive c ON a.parent_id = c.folder_id) SELECT * FROM folder_recursive";
//        $folders = DB::raw($sql);
//
//        dd($folders);
////        try {
////            $dbc = new PDO("mysql:host=127.0.0.1;dbname=laravelcms", 'jorn', 'root');
////            // set the PDO error mode to exception
////            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
////            $query = $dbc->query($sql);
////            $query->setFetchMode(PDO::FETCH_ASSOC);
////            $results = $query->fetchAll();
////            $dbc = null;
////        }
////        catch(PDOException $e)
////        {
////            echo "Connection failed: " . $e->getMessage();
////        }
////        $dbc = mysqli_connect('localhost','jorn','root123','laravelcms');
////        $result = mysqli_query($dbc,$sql);
////        if(!$result){ echo("Error description: " . mysqli_error($dbc));}
////        dd($result);
////        $rows = mysqli_fetch_array($result);
//        Folder::destroy($folders);
//        // Remove possible uploaded files in the removed folders from the database
////        Upload::whereIn('folder_id',$folders)->delete();
//    }

    public function removeMany(array $keys)
    {
        $key = $this->primaryKey;

        $parents = $keys;
//        // Delete all folders/files and subdirectories
//        foreach($parents as $parent){
//            $folder = Folder::findOrFail($parent);
//            Storage::deleteDirectory($folder->path);
//        }
        Folder::delete_recursive($parents,$key);
    }
}
