<?php

return array(
    'displayErrorDetails' => DEBUG_MODE,
    'views' => __DIR__ . '/../views/',
    'db_attributes' => array(
        'driver' => 'sqlite',
        'filename' => __DIR__ . '/../db/development.db'
    )
);
