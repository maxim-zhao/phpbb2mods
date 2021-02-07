<?php
/***************************************************************************
 *                                serve.php
 *                            -------------------
 *   begin                : Wednesday, Mar 3, 2005
 *   copyright            : (C) MMV TerraFrost
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

if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']))
{
	echo 'transpare';
}
else if (isset($HTTP_SERVER_VARS['HTTP_VIA']) || isset($HTTP_SERVER_VARS['HTTP_PROXY_CONNECTION']))
{
	echo 'anonymous';
}
else
{
	echo 'high_anon';
}

?>