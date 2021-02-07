<?php
/******************************************************************************************
 Wicher, www.detecties.com/phpbb2018
 bignum.php version 1.1.8	
 Guest See Only First Post 1.1.8	
******************************************************************************************/
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

function bignum( $num )
{
	$s = "";
	for ($t = 1000000000; $t >= 1; $t/=1000)
	{
		$o = (int) (($num/$t) % 1000);
		if ($s != "" || $o != 0)
		{
			if ($o < 10 && $s != "")
			{
				$s .= "00";
			}
			else if ($o < 100 && $s != "")
			{
				$s .= "0";
			}
			$s .= $o;
			if ($t != 1)
			{
				$s .= ".";
			}
		}
	}
	return $s;
}

?>