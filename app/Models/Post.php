<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;
use CMS\Models\Elasticsearch\PostIndexConfigurator;

class Post extends Model
{
    use ModelActionsTrait;
    use Searchable;

    protected $indexConfigurator = PostIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    // Here you can specify a mapping for a model fields.
    protected $mapping = [
        'properties' => [
            'post_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'title' => [
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
            'content' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'standard'
                    ]
                ]
            ],
            'keywords' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'approved' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'category_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'trashed' => [
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
            'locked_till' => [
                'type' => 'date',
                'fields' => [
                    'raw' => [
                        'type' => 'date',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'created_at' => [
                'type' => 'date',
                'fields' => [
                    'raw' => [
                        'type' => 'date',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'updated_at' => [
                'type' => 'date',
                'fields' => [
                    'raw' => [
                        'type' => 'date',
                        'index' => 'not_analyzed'
                    ]
                ]
            ]
        ]
    ];

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'title',
        'content',
        'description',
        'keywords',
        'category_id',
    ];

    public $table = "posts";

    # Relations

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

    public function tags()
    {
        return $this->morphToMany('CMS\Models\Tag', 'taggable',null,null,'tag_id');
    }
    # Getters
    public function id()
    {
        return $this->post_id;
    }
    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->title);
    }

}
