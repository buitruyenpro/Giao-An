<?php
//	error_reporting( error_reporting() & ~E_NOTICE );
//	error_reporting(E_ERROR | E_PARSE);
return array(
	'modules'	=> array(
			//'ZendDeveloperTools',
			'RtHeadtitle',
			'AcMailer',
			'Admin',
	),
	'module_listener_options'	=> array(
			'module_paths'		=> array(
					'./module',
					'./vendor'
			),
			'config_glob_paths'	=> array(
					'config/autoload/{,*.}{global,local}.php'
			),
	),
	'service_manager'			=> array()
);