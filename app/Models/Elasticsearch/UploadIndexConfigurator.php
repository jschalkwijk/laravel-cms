<?php

namespace CMS\Models\Elasticsearch;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class UploadIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        //
    ];
}