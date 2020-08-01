<?php

return array(
    'mysql'=>array(
        'host'=>'127.0.0.1',
        'username'=>'mysql_username',
        'password'=>'mysql_password',
        'database'=>'database_name',
        'charset'=>'utf-8'
    ),
    'http_server'=>array(
        'host'=>'0.0.0.0',
        'port'=>9999,
        'setting'=>array(
            'worker_num'=>10
        )
    ),
    'rpc_server'=>array(
        'host'=>'0.0.0.0',
        'port'=>9998,
        'setting'=>array(
            'worker_num'=>10
        )
    )
);
