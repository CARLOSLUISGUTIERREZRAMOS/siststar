<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Capsule\Manager as Capsule;

$active_group = 'default';
$query_builder = TRUE;

$db['db_local_testing'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'user_db_staradm',
    'password' => 'p3ruST4R2O17',
    'database' => 'db_staradm',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
//	'db_debug' => (ENVIRONMENT !== 'production'),
    'db_debug' => FALSE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
$db['default'] = array(
    'dsn' => '',
    'hostname' => '104.198.247.7',
    'username' => 'root',
    'password' => 'DK7C54HCkQ4GXWh',
    'database' => 'db_staradm',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
//	'db_debug' => (ENVIRONMENT !== 'production'),
    'db_debug' => FALSE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
$db['db_file'] = array(
    'dsn' => '',
    'hostname' => '127.0.0.1',
    'username' => 'user_db_file',
    'password' => 'f1L3_p3ruST4R2O17',
    'database' => 'db_file',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);
$db['db_refund'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'user_db_refund',
    'password' => 'r3funD_st4rp3ru2019',
    'database' => 'db_refund',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => FALSE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);
$db['db_web_test_'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'user_db_web_test',
    'password' => 'dBW3bT3st',
    'database' => 'db_web_test',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => FALSE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);
$db['db_pasarela_prod'] = array(
    'dsn' => '',
    'hostname' => '130.211.151.54',
    'username' => 'root',
    'password' => 'StarPeru12',
    'database' => 'db_pasarela',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => TRUE,
    'db_debug' => FALSE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);
//$db['db_web_production'] = array(
$db['db_web_test57'] = array(
    'dsn' => '',
    'hostname' => '104.197.244.1',
    'username' => 'root',
    'password' => 'bBmocaGjAtmmj5qA',
    'database' => 'db_web',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
$db['db_web_prod'] = array(
    'dsn' => '',
    'hostname' => '104.198.247.7',
    // 'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'DK7C54HCkQ4GXWh',
    // 'password' => '',
    'database' => 'db_web',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
$db['db_local'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_web',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['db_local_adm'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_staradm',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['db_compartido'] = array(
        'dsn' => '',
        'hostname' => '104.198.247.7',
        'username' => 'root',
        'password' => 'DK7C54HCkQ4GXWh',
        'database' => 'db_compartido',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => TRUE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array()
);

$db['db_agencia'] = array(
    'dsn' => '',
    'hostname' => '104.198.247.7',
    // 'hostname' => 'localhost',
    'username' => 'root',
    // 'password' => '',
    'password' => 'DK7C54HCkQ4GXWh',
    'database' => 'db_agencia',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $db['db_web_prod']['hostname'],
    'database'  => $db['db_web_prod']['database'],
    'username'  => $db['db_web_prod']['username'],
    'password'  => $db['db_web_prod']['password'],
    'charset'   => $db['db_web_prod']['char_set'],
    'collation' => $db['db_web_prod']['dbcollat'],
    'prefix'    => $db['db_web_prod']['dbprefix'],
],'default');

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $db['db_agencia']['hostname'],
    'database'  => $db['db_agencia']['database'],
    'username'  => $db['db_agencia']['username'],
    'password'  => $db['db_agencia']['password'],
    'charset'   => $db['db_agencia']['char_set'],
    'collation' => $db['db_agencia']['dbcollat'],
    'prefix'    => $db['db_agencia']['dbprefix'],
],'db_agencia');

$capsule->setAsGlobal();
$capsule->bootEloquent();