<?php 
/*****************************************************************************
 *                AVC Version Checker Config File -- Version 3.0
 *                      -------------------------------
 *   This file contains config data for Advanced Version Check. AVC will read
 *   this file to add a version checker to the Version Check system.
 *   
 *   This file is provided as a template for MOD Authors in the mod-authors/
 *   directory in the Advanced Version Check zip download. Instructions are
 *   provided in mod-authors/mod_authors_guide.txt on how fill in the
 *   configuration options in this file for use with their MOD.
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// DO NOT ALTER THESE FIRST LINES!!! These lines are required.
//
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
$file = basename(__FILE__); 

/* MOD Info: (enter your details here if you want)
MOD Name: Registration Stopper
MOD Author: Fountain of Apples
Website: http://www.foamods.info
*/

$mod_name = 'Registration Stopper';
$mod_current_version = '1.2.0';
$mod_dev_status = 'stable';
$mod_domain_loc = 'http://www.foamods.info';
$mod_file_name = 'regstopper.xml';
$mod_file_loc = 'versioncheck';

?>