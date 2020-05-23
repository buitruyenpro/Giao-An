<?php
	
	// Đường dẫn thư mục chứa ứng dụng
	define('PATH_APPLICATION', realpath(dirname(__DIR__)));
	
	// Đường dẫn thư mục chứa thư viện
	define('PATH_LIBRARY', PATH_APPLICATION . '/library');
	
	// Đường dẫn thư mục chứa vendor
	define('PATH_VENDOR', PATH_APPLICATION . '/vendor');
	define('HTMLPURIFIER_PREFIX', PATH_VENDOR);
	
	// Đường dẫn thư mục public
	define('PATH_PUBLIC', PATH_APPLICATION . '/public');
	
	// Đường dẫn thư mục captcha
	define('PATH_CAPTCHA', PATH_PUBLIC . '/captcha');
	
	// Đường dẫn thư mục template
	define('PATH_TEMPLATE', PATH_PUBLIC . '/template');
	
	define('URL_APPLICATION', '/bookonline');
	define('URL_PUBLIC', URL_APPLICATION . '/public');
	define('URL_TEMPLATE', URL_PUBLIC . '/template');
	
	