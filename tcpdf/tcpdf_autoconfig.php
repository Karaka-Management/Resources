<?php declare(strict_types=1);
//============================================================+
// File name   : tcpdf_autoconfig.php
// Version     : 1.1.1
// Begin       : 2013-05-16
// Last Update : 2014-12-18
// Authors     : Nicola Asuni - Tecnick.com LTD - www.tecnick.com - info@tecnick.com
// License     : GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2011-2014 Nicola Asuni - Tecnick.com LTD
//
// This file is part of TCPDF software library.
//
// TCPDF is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// TCPDF is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the License
// along with TCPDF. If not, see
// <http://www.tecnick.com/pagefiles/tcpdf/LICENSE.TXT>.
//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description : Try to automatically configure some TCPDF
//               constants if not defined.
//
//============================================================+

/**
 * @file
 * Try to automatically configure some TCPDF constants if not defined.
 * @package com.tecnick.tcpdf
 * @version 1.1.1
 */

// DOCUMENT_ROOT fix for IIS Webserver
if ((!isset($_SERVER['DOCUMENT_ROOT'])) || (empty($_SERVER['DOCUMENT_ROOT']))) {
	if(isset($_SERVER['SCRIPT_FILENAME'])) {
		$_SERVER['DOCUMENT_ROOT'] = \str_replace('\\', '/', \substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - \strlen($_SERVER['PHP_SELF'])));
	} elseif(isset($_SERVER['PATH_TRANSLATED'])) {
		$_SERVER['DOCUMENT_ROOT'] = \str_replace('\\', '/', \substr(\str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - \strlen($_SERVER['PHP_SELF'])));
	} else {
		// define here your DOCUMENT_ROOT path if the previous fails (e.g. '/var/www')
		$_SERVER['DOCUMENT_ROOT'] = '/';
	}
}
$_SERVER['DOCUMENT_ROOT'] = \str_replace('//', '/', $_SERVER['DOCUMENT_ROOT']);
if (\substr($_SERVER['DOCUMENT_ROOT'], -1) != '/') {
	$_SERVER['DOCUMENT_ROOT'] .= '/';
}

// Load main configuration file only if the K_TCPDF_EXTERNAL_CONFIG constant is set to false.
if (!\defined('K_TCPDF_EXTERNAL_CONFIG') || !K_TCPDF_EXTERNAL_CONFIG) {
	// define a list of default config files in order of priority
	$tcpdf_config_files = [__DIR__ . '/config/tcpdf_config.php', '/etc/php-tcpdf/tcpdf_config.php', '/etc/tcpdf/tcpdf_config.php', '/etc/tcpdf_config.php'];
	foreach ($tcpdf_config_files as $tcpdf_config) {
		if (\is_file($tcpdf_config) && \is_readable($tcpdf_config)) {
			require_once($tcpdf_config);
			break;
		}
	}
}

if (!\defined('K_PATH_MAIN')) {
	\define('K_PATH_MAIN', __DIR__ . '/');
}

if (!\defined('K_PATH_FONTS')) {
	\define('K_PATH_FONTS', K_PATH_MAIN.'fonts/');
}

if (!\defined('K_PATH_URL')) {
	$k_path_url = K_PATH_MAIN; // default value for console mode
	if (isset($_SERVER['HTTP_HOST']) && (!empty($_SERVER['HTTP_HOST']))) {
		if(isset($_SERVER['HTTPS']) && (!empty($_SERVER['HTTPS'])) && (\strtolower($_SERVER['HTTPS']) != 'off')) {
			$k_path_url = 'https://';
		} else {
			$k_path_url = 'http://';
		}
		$k_path_url .= $_SERVER['HTTP_HOST'];
		$k_path_url .= \str_replace('\\', '/', \substr(K_PATH_MAIN, (\strlen($_SERVER['DOCUMENT_ROOT']) - 1)));
	}
	\define('K_PATH_URL', $k_path_url);
}

if (!\defined('K_PATH_IMAGES')) {
	$tcpdf_images_dirs = [K_PATH_MAIN.'examples/images/', K_PATH_MAIN.'images/', '/usr/share/doc/php-tcpdf/examples/images/', '/usr/share/doc/tcpdf/examples/images/', '/usr/share/doc/php/tcpdf/examples/images/', '/var/www/tcpdf/images/', '/var/www/html/tcpdf/images/', '/usr/local/apache2/htdocs/tcpdf/images/', K_PATH_MAIN];
	foreach ($tcpdf_images_dirs as $tcpdf_images_path) {
		if (\is_dir($tcpdf_images_path)) {
			\define('K_PATH_IMAGES', $tcpdf_images_path);
			break;
		}
	}
}

if (!\defined('K_PATH_CACHE')) {
	$K_PATH_CACHE = \ini_get('upload_tmp_dir') ? \ini_get('upload_tmp_dir') : \sys_get_temp_dir();
	if (\substr($K_PATH_CACHE, -1) != '/') {
		$K_PATH_CACHE .= '/';
	}
	\define('K_PATH_CACHE', $K_PATH_CACHE);
}

// defined in tcpdf_config.php
if (!\defined('K_BLANK_IMAGE')) {
	\define('K_BLANK_IMAGE', '_blank.png');
	\define('PDF_PAGE_FORMAT', 'A4');
	\define('PDF_PAGE_ORIENTATION', 'P');
	\define('PDF_CREATOR', 'TCPDF');
	\define('PDF_AUTHOR', 'TCPDF');
	\define('PDF_HEADER_TITLE', 'TCPDF Example');
	\define('PDF_HEADER_STRING', "by Nicola Asuni - Tecnick.com\nwww.tcpdf.org");
	\define('PDF_UNIT', 'mm');
	\define('PDF_MARGIN_HEADER', 5);
	\define('PDF_MARGIN_FOOTER', 10);
	\define('PDF_MARGIN_TOP', 27);
	\define('PDF_MARGIN_BOTTOM', 25);
	\define('PDF_MARGIN_LEFT', 15);
	\define('PDF_MARGIN_RIGHT', 15);
	\define('PDF_FONT_NAME_MAIN', 'helvetica');
	\define('PDF_FONT_SIZE_MAIN', 10);
	\define('PDF_FONT_NAME_DATA', 'helvetica');
	\define('PDF_FONT_SIZE_DATA', 8);
	\define('PDF_FONT_MONOSPACED', 'courier');
	\define('PDF_IMAGE_SCALE_RATIO', 1.25);
	\define('HEAD_MAGNIFICATION', 1.1);
	\define('K_CELL_HEIGHT_RATIO', 1.25);
	\define('K_TITLE_MAGNIFICATION', 1.3);
	\define('K_SMALL_RATIO', 2 / 3);
	\define('K_THAI_TOPCHARS', true);
	\define('K_TCPDF_CALLS_IN_HTML', false);
	\define('K_TCPDF_THROW_EXCEPTION_ERROR', false);
	\define('K_TIMEZONE', @\date_default_timezone_get());
}

//============================================================+
// END OF FILE
//============================================================+
