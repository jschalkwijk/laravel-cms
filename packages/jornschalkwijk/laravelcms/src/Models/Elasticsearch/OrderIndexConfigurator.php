<?php

    namespace JornSchalkwijk\LaravelCMS\Models\Elasticsearch;

    use ScoutElastic\IndexConfigurator;
    use ScoutElastic\Migratable;

class OrderIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        //
    ];
}