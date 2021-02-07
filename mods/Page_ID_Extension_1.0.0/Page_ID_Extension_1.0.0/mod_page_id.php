<?php
/***************************************************************************
 * Filename:          mod_page_id.php
 * Description:       Provides a simple means for MOD Authors to add new
 *                    page ID's for use in their MODs to provide more
 *                    accurate session tracking without the need for each MOD
 *                    to alter constants.php, viewonline.php and admin/index.php
 * Author:            Graham Eames (phpbb@grahameames.co.uk)
 * Last Modified:     01-Nov-2003
 * File Version:      1.1
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
 
//
// Each entry in this file should be in the format of the sample below
// This example defines a generic constant PAGE_MOD which can be used if you
// do not wish to define any extra ones
//
// CONSTANT_VALUE should be the ID number (please refer to the list at
//   http://www.phpbb.com/kb/article.php?article_id=149 to find 
//    information on the values available for private use and on those which have been
//    allocated to a particular MOD Author)
// CONSTANT_NAME is the name you will use in the call to session_pagestart in your MOD
// PAGE_URL is the URL to your MOD, relative to the location of viewonline.php
// LANG_STRING is the name of the string you have added to lang_main.php which you wish
//   to be displayed on viewonline.php
//
$page_id[] = array(
	'CONSTANT_VALUE' => -1025,
	'CONSTANT_NAME' => 'PAGE_MOD',
	'PAGE_URL' => "index.$phpEx",
	'LANG_STRING' => 'Viewing_Page_MOD');

//
// Insert new above entries here
//

//
// You should not modify anything below this point
//

// This defines the constants ready for use
$page_id_count = count($page_id);

for ($i=0; $i<$page_id_count; $i++)
{
	define($page_id[$i]['CONSTANT_NAME'], $page_id[$i]['CONSTANT_VALUE']);
}

?>