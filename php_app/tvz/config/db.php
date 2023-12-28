<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mariadb:3306;dbname=tvz_app_db',
    'username' => 'root',
    'password' => 'root_password!',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
