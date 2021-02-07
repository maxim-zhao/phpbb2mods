<?php
/***************************************************************************
 *                               phpmn_footer.php
 *                            -------------------
 *   begin                : Friday, Sep 16, 2005
 *   copyright            : (C) 2005 Martin Truckenbrodt
 *   email                : webmaster@martin-truckenbrodt.com
 *
 *   $Id: phpmn_footer.php,v 1.0.0 $
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

//
// Show the overall footer.
//
$template->set_filenames(array(
	'phpmn_footer' => 'phpmn_footer.tpl')
);

$template->assign_vars(array(
	'PHPMN_ADMIN_LINK' => $lang['PHPMN_ADMIN_LINK']
));

$template->pparse('phpmn_footer');

?>