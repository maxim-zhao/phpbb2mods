<?php

/***************************************************************************
 *	Cache Module Language File
 *      Original author: Dave Rathbun (copyright www.phpBBDoctor.com)
 *
 *	This is the language file for the Cache system from the phpBBDoctor.
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 ***************************************************************************/

// You know, this isn't really necessary, since there's nothing
// going on here except for a bunch of assignment statements, 
// but why not, it doesn't hurt anything...
if (!defined('IN_PHPBB'))
{
        die('Hacking attempt');
}

$lang['phpbbdoctor_cache_file_missing'] = '%s is missing!';
$lang['phpbbdoctor_cache_cannot_open'] = 'Cannot open %s for writing';
$lang['phpbbdoctor_cache_failed_write'] = 'Failed writing contents to %s';
$lang['phpbbdoctor_cache_not_writable'] = 'The file %s is not writeable, try chmod 666 to fix';

?>
