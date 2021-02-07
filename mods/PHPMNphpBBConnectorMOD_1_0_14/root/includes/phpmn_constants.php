<?php
/***************************************************************************
 *                               phpmn_constants.php
 *                            -------------------
 *   begin                : Friday, Sep 30, 2005
 *   copyright            : (C) 2005 Martin Truckenbrodt
 *   email                : webmaster@martin-truckenbrodt.com
 *
 *   $Id: phpmn_constants.php,v 1.0.1 $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

//TABLE NAMES
$phpmn_table_prefix = "news_"; //change this entry only if neccessary

define('PHPMN_MEMBER_TABLE', $phpmn_table_prefix.'member');
define('PHPMN_NEWSLETTER_TABLE', $phpmn_table_prefix.'newsletter');
define('PHPMN_ARCHIVE_TABLE', $phpmn_table_prefix.'archive');


// URL PARAMETERS
define('PHPMN_ID', 'id');
define('PHPMN_TOPICAL', 'topical');
define('PHPMN_DO', 'do');
define('PHPMN_EDIT', 'edit');
define('PHPMN_NEWSID', 'newsid');

?>