<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = 'default';
$db['default']  = array(
 'dsn' 		    => '',
 //'hostname'     => '10.21.4.3',
 'hostname'     => '127.0.0.1',
 'port' 	    => '1433',
 'username'     => 'sa',
 'password'     => 'P@ssw0rdswi',
 'database'     => 'digitizedocument',
 'dbdriver'     => 'sqlsrv',
 'dbprefix'     => '',
 'pconnect'     => FALSE,
 //'db_debug'     => (ENVIRONMENT !== 'production'),
 'db_debug'     => FALSE,
 'cache_on'     => FALSE,
 'cachedir'     => '',
 'char_set'     => 'utf8',
 'dbcollat'     => 'utf8_general_ci',
 'swap_pre'     => '',
 'encrypt'      => FALSE,
 'compress'     => FALSE,
 'stricton'     => FALSE,
 'failover'     => array(),
 'save_queries' => TRUE
);
