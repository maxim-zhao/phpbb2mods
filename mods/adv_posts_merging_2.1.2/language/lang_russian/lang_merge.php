<?php
/***************************************************************************
 *                         lang_merge.php [russian]
 *                            -------------------
 *   begin                : Wednesday Apr 28, 2004
 *   copyright            : (C) 2004 Xpert
 *   email                : xpert@phpbbguru.net
 *
 *   $Id: lang_merge.php,v 1.2.0 2004/12/14 9:01 xpert Exp $
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

/* 
	Important note:
	If you want to customize message separator, be sure that you use \r\n as a new line.
	Using \n will cause problems with smilies parsing. I've found no explanation for this
	phenomena, but text data at database dumps contains \r\n, so i think that's ok.  	
*/

// For Admin Center

$lang['Merge_time_limit'] = '»нтервал дл€ склеивани€ сообщений';
$lang['Merge_time_limit_explain'] = '¬рем€ (в часах), в течение которого будет возможна склейка добавленных подр€д сообщений от одного пользовател€. ќставьте поле пустым, если не хотите использовать эту возможность.';

$lang['Merge_flood_interval'] = '«адержка отсылки сообщений при склеивании';
$lang['Merge_flood_interval_explain'] = '¬рем€ (в секундах), которое должно пройти между двум€ сообщени€ми пользовател€ в одной теме.';


// Basic language variables

// The string that separates original message and added one. 
// Parametres %s are: day, hour, minute and second strings. 
// For example, %s%s%s%s will give you, 1 day 3 hours 5 minutes
// 27 seconds.

$lang['Merge_separator'] = "\r\n\r\n[color=green][size=9]ƒобавлено спуст€%s%s%s%s:[/size][/color]\r\n\r\n";

// Subject of the added message 

$lang['Merge_post_subject'] = "[i]%s[/i]\r\n\r\n";


// Next 4 functions are lexical analysers.
// They are specific for every language, that's why they are here.

function seconds_st($nm)
{
	switch ($nm)
	{
		case 1:
		case 21:
		case 31:
		case 41:
		case 51:
			$st = 'секунду';
		break;

		case 2:
		case 3:
		case 4:
		case 22:
		case 23:
		case 24:
		case 32:
		case 33:
		case 34:
		case 42:
		case 43:
		case 44:
		case 52:
		case 53:
		case 54:
			$st = 'секунды';
		break;

		default:
			$st = 'секунд';
		break;
	}
	return ' ' . $nm . ' ' . $st;
}

function minutes_st($nm)
{
	switch ($nm)
	{
		case 1:
		case 21:
		case 31:
		case 41:
		case 51:
			$st = 'минуту';
		break;

		case 2:
		case 3:
		case 4:
		case 22:
		case 23:
		case 24:
		case 32:
		case 33:
		case 34:
		case 42:
		case 43:
		case 44:
		case 52:
		case 53:
		case 54:
			$st = 'минуты';
		break;

		default:
			$st = 'минут';
		break;
	}
	return ' ' . $nm . ' ' . $st;
}

function hours_st($nm)
{
	switch ($nm)
	{
		case 1:
		case 21:
			$st = 'час';
		break;

		case 2:
		case 3:
		case 4:
		case 22:
		case 23:
			$st = 'часа';
		break;
 
		default:
			$st = 'часов';
		break;
	}
	return ' ' . $nm . ' ' . $st;
}

function days_st($nm)
{
	switch ( $nm )
	{
		case 1:
		case 21:
			$st = 'день';
		break;

		case 2:
		case 3:
		case 4:
		case 22:
		case 23:
			$st = 'дн€';
		break;
 
		default:
			$st = 'дней';
		break;
	}
	return ' ' . $nm . ' ' . $st;
}

?>