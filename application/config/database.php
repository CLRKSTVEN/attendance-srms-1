<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',

	'hostname' => '127.0.0.1',
	'username' => 'root',
	// 'password' => 'moth34board',
	// 'database' => 'srmsportal_tyrn',
	//  'database' => 'srmsportal_amya',
	// 'database' => 'srmsportal_vmc',
	// 'database' => 'srmsportal_vmc1',
	// 'database' => 'srmsportal_demo2',
	'database' => 'srms_attendance',
	// 'database' => 'knpsrms',
	// 'database' => 'knpsrms_db',

	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_unicode_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
