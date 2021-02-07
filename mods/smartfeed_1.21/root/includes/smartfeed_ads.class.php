<?php
/***************************************************************************
                             smartfeed_ads_class.php
                             -----------------------
    begin                : Mon, Jan 15, 20077
    copyright            : (c) Mark D. Hamill
    email                : mhamill@computer.org

    $Id: $

***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// Written by Mark D. Hamill, mhamill@computer.org
// This software is designed to work with phpBB Version 2.0.22

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class Smartfeed_Ad_Configuration {

	// This class is used to store persistent advertising data for Smartfeed. Data is serialized.

	var $display_ads;
	var $show_ads_to_public_only;
	var $enable_block_1;
	var $enable_block_2;
	var $enable_block_3;
	var $block_1_title;
	var $block_2_title;
	var $block_3_title;
	var $block_1_link;
	var $block_2_link;
	var $block_3_link;
	var $block_1_desc;
	var $block_2_desc;
	var $block_3_desc;
	var $block_2_num_items_to_skip;	
		
	function Smartfeed_Ad_Configuration () 
	
	{
	
		$this->display_ads = false;
		$this->show_ads_to_public_only = false;;
		$this->enable_block_1 = false;
		$this->enable_block_2 = false;
		$this->enable_block_3 = false;
		$this->block_1_title = '';
		$this->block_2_title = '';
		$this->block_3_title = '';
		$this->block_1_link = '';
		$this->block_2_link = '';
		$this->block_3_link = '';
		$this->block_1_desc = '';
		$this->block_2_desc = '';
		$this->block_3_desc = '';
		$this->block_2_num_items_to_skip = 5;	
		
	}
	
}

?>