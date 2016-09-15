<?php
return array (
    'backend' =>
        array (
            'frontName' => 'admin_139p1v',
        ),
    'crypt' =>
        array (
            'key' => '6535b2203837a39fba550b789b9783d0',
        ),
    'session' =>
        array (
            'save' => 'files',
        ),
    'db' =>
        array (
            'table_prefix' => '',
            'connection' =>
                array (
                    'default' =>
                        array (
                            'host' => 'db:1989',
                            'dbname' => 'magento2dbname',
                            'username' => 'magento2user',
                            'password' => 'magento2pass',
                            'model' => 'mysql4',
                            'engine' => 'innodb',
                            'initStatements' => 'SET NAMES utf8;',
                            'active' => '1',
                        ),
                ),
        ),
    'resource' =>
        array (
            'default_setup' =>
                array (
                    'connection' => 'default',
                ),
        ),
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'default',
    'cache_types' =>
        array (
            'config' => 1,
            'layout' => 1,
            'block_html' => 1,
            'collections' => 1,
            'reflection' => 1,
            'db_ddl' => 1,
            'eav' => 1,
            'config_integration' => 1,
            'config_integration_api' => 1,
            'full_page' => 1,
            'translate' => 1,
            'config_webservice' => 1,
            'compiled_config' => 1,
        ),
    'install' =>
        array (
            'date' => 'Tue, 13 Sep 2016 10:18:06 +0000',
        ),
);
