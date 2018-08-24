<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use ScoutElastic\Searchable;
use CMS\Models\Elasticsearch\UploadIndexConfigurator;

class Upload extends Model
{
    use ModelActionsTrait;
    use Searchable;

    protected $indexConfigurator = UploadIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    // Here you can specify a mapping for a model fields.
    protected $mapping = [
        'properties' => [
            'upload_id' => [
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
            'file_name' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'type' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'folder_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'user_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'size' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
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

    public function folders()
    {
        return $this->belongsToMany(Folder::class,"folders_uploads","upload_id","folder_id");
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class,"galleries_uploads","upload_id","gallery_id");
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
