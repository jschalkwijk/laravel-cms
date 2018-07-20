<?php

namespace CMS\Models\Elasticsearch;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class FolderIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        //
    ];
}