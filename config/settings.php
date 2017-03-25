<?php

return array(
    'displayErrorDetails' => DEBUG_MODE,
    'views' => __DIR__ . '/../views/',
    'db_attributes' => array(
        'driver' => DB_DRIVER,
        'filename' => __DIR__ . '/../db/nucleon.sqlite'
    ),
    'globals' => array(
        'site_url' => $GLOBALS['SITE_PATH']
    )
);
