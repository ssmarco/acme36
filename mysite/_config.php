<?php

global $project;
$project = 'mysite';

global $database;
$database = '';

require_once 'conf/ConfigureFromEnv.php';

// Set the site locale
i18n::set_locale('en_US');

FulltextSearchable::enable();

Solr::configure_server(array(
    'host' => 'localhost', // default: localhost | The host or IP Solr is listening on
    'port' => '8983', // default: 8983 | The port Solr is listening on
    'path' => '/solr', // default: /solr | The suburl the solr service is available on
    'version' => '4', // default: 4 | Solr server version - currently only 3 and 4 supported
    'service' => 'Solr4Service', // default: depends on version, Solr3Service for 3, Solr4Service for 4 | the class that provides actual communcation to the Solr server
    'extraspath' => BASE_PATH .'/fulltextsearch/conf/solr/4/extras/', // default: <basefolder>/fulltextsearch/conf/solr/{version}/extras/ | Absolute path to the folder containing templates which are used for generating the schema and field definitions.
    'templates' => BASE_PATH . '/fulltextsearch/conf/solr/4/templates/', // default: <basefolder>/fulltextsearch/conf/solr/{version}/templates/ | Absolute path to the configuration default files, e.g. solrconfig.xml
    'indexstore' => array(
        'mode' => 'file', // a classname which implements SolrConfigStore, or 'file' or 'webdav'
        'path' => BASE_PATH . '/.solr', // The (locally accessible) path to write the index configurations to OR The suburl on the solr host that is set up to accept index configurations via webdav
    )
));
