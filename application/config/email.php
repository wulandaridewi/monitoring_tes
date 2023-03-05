<?php defined('BASEPATH') OR exit('No direct script access allowed');
// Turn off all error reporting
error_reporting(0);

$config = array(
    'mailtype' => 'html', // 'mail', 'sendmail', or 'smtp'
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => '172.31.152.95',     
    'smtp_user' => 'Chairul.Elyasa@astragraphia.co.id',
    'smtp_pass' => 'April2022-1',
    'smtp_port' => 25,
    //'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'charset' => 'utf-8',
    'smtp_timeout' => '15', //in seconds    
    'newline' => "\r\n",
    'crlf' => "\r\n",
    //'wordwrap' => TRUE
);