<?php
/***************************************************************************
 *                             rss_parser.php
 *                            -------------------
 *   Author  		: 	netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Created 		: 	Monday, Sept 23, 2002
 *	 Last Updated	:	Thursday, Aug 07, 2003
 *
 *	 Version		: 	1.0.2
 *
 ***************************************************************************/

// This rssParser will take a url to an RSS feed and instantiate an xml parser
// to read it. The channel details will be stored in three variable, $channel, 
// $channel_description & $channel_link. The news items from the rss feed will 
// be stored in three arrays $titles, $descriptions & $liks.

class rssParser 
{
	// private - an _ (underscore) will hide these fields from public view
	//					effectivly making them private fields.
	
	var $_insideitem = false;
	var $_insidechannel = false;
	var $_insideimage = false;
	var $_tag = '';

    var $_item = array();

	var $_image_url='';
	var $_image_link='';
	var $_image_width='0';
	var $_image_height='0';
	var $_image_title='';

	var $_channel='';
	var $_channel_description='';
	var $_channel_link='';

	var $_xml_parser;
	var $_fp;

	// public
	var $image_url='';
	var $image_link='';
	var $image_width='0';
	var $image_height='0';
	var $image_title='';
    
	var $channel='';
	var $channel_description='';
	var $channel_link='';
	
    var $items = array();
	
	var $error_msg='';

	
	// our class constructor
	function rssParser()
	{
		// instantiate an xml parser and setup the resuired events
		$this->_xml_parser = xml_parser_create();
		xml_set_object($this->_xml_parser,&$this);
		xml_set_element_handler($this->_xml_parser, 'startElement', 'endElement');
		xml_set_character_data_handler($this->_xml_parser, 'characterData');
	}
	
	// our class destructor (kind of)
	function destroy()
	{
		// close the data source
		if ($this->_fp)
		{
			fclose($this->_fp);
		}
		
		// destroy our xml parser
		xml_parser_free($this->_xml_parser);
	}
	
	// parse the xml
	function parse($RSS_URL)
	{
		$prev_error_reporting = error_reporting();
		error_reporting(E_ERROR);
		
		$result = false;
		$data = '';
		
		// retrieve the data from the given url
		if ($this->_fp = @fopen($RSS_URL,'r'))
		{
			// read the file into our data in 4k chunks
			while ($data = fread($this->_fp, 4096))
			{
				// parse our xml data until we find the end of our file
				xml_parse($this->_xml_parser, $data, feof($this->_fp))
					or die(sprintf('XML error: %s at line %d', 
					xml_error_string(xml_get_error_code($this->_xml_parser)), 
					xml_get_current_line_number($this->_xml_parser)));

				$result = true;
			}	
		}
		error_reporting($prev_error_reporting);

		return $result;	
	}
	
	// this event is fired when the xml parser comes across and opening element in the xml
	function startElement($parser, $tagName, $attrs) 
	{
		// if we are already inside an item then	
		if ($this->_insideitem) 
		{
			// take a copy of the tag name
			$this->_tag = $tagName;
			
			// set insidechannel to false - this is done to get around the problem of 
			// some rss feeds wrapping their news items inside a channel while others
			// just declare the channel on it's own at the top of the rss feed.
			$this->_insidechannel = false;
		} 
		
		// if we are on an ITEM tag
		elseif ($tagName == 'ITEM') 
		{
			// set insideitem to true
			$this->_insideitem = true;
		}
		
		// if we are on a CHANNEL tag
		elseif ($tagName =='CHANNEL')
		{
			// set insidechannel to true
			$this->_insidechannel = true;
		}
		
		// if we are on an IMAGE tag
		elseif ($tagName == 'IMAGE') 
		{
			$this->_insideimage = true;
			$this->_insidechannel = false;
			$this->_insideitem = false;
		}
		
		// if we are inside an image
		elseif ($this->_insideimage)
		{
			$this->_tag = $tagName;
			$this->_insidechannel = false;
		}

		// if we are inside a channel - do this bit last just in case the channel tag 
		// wraps the whole news feed, then we'd just be inside a channel all the time
		elseif ($this->_insidechannel)
		{
			$this->_tag = $tagName;
		}
	}

	// this event is fired when the xml parser comes across a closing element in the xml
	function endElement($parser, $tagName) 
	{
		// if it's an item then we want to add the item details to our item details arrays
		if ($tagName == 'ITEM') 
		{
            $this->_item['title'] = trim($this->_item['title']);
            $this->_item['description'] = trim($this->_item['description']);
            $this->_item['link'] = trim($this->_item['link']);
            array_push($this->items, $this->_item);

			// reset our item detail variables
            $this->_item = array();
			$this->_insideitem = false;
		}
		
		// if it's an image
		elseif ($tagName == 'IMAGE')
        {
			$this->image_url = trim($this->_image_url);
			$this->image_link = trim($this->_image_link);
			$this->image_title = trim($this->_image_title);
			$this->image_height = intval(trim($this->_image_height));
			$this->image_width = intval(trim($this->_image_width));

			// reset our image detail variables
			$this->_image_url = '';
			$this->_image_link = '';
			$this->_image_title = '';
			$this->_image_height = '0';
			$this->_image_width = '0';
        }

		// if it's a channel then we want to add the channel details to our channel details fields
		elseif ($tagName == 'CHANNEL')
		{
			$this->channel = trim($this->_channel);
			$this->channel_description = trim($this->_channel_description);
			$this->channel_link = trim($this->_channel_link);

			// reset our channel detail variables
			$this->_channel = '';
			$this->_channel_description = '';
			$this->_channel_link = '';
			$this->_insidechannel = false;
		}
	}

	// this event is fired for each character of data which is read from the xml
	// use it to read the bits of information we are interested in
	function characterData($parser, $data) 
	{
		// if we are inside an item
		if ($this->_insideitem) 
		{
			// depending on what tag we are looking at
			// set the appropriate bit variable - notice that the data
			// is added on to the end of the variable, this is because 
			// it's read one bit at a time.
			switch ($this->_tag) 
			{
				case 'TITLE':
					$this->_item['title'] .= $data;
					break;
				case 'DESCRIPTION':
					$this->_item['description'] .= $data;
					break;
				case 'LINK':
					$this->_item['link'] .= $data;
					break;
			}
		}
		
        // if was inside an image
        elseif ($this->_insideimage)
        {
			// depending on what tag we are looking at
			// set the appropriate bit variable - notice that the data
			// is added on to the end of the variable, this is because 
			// it's read one bit at a time.
			switch ($this->_tag) 
			{
				case 'URL':
					$this->_image_url .= $data;
					break;
				case 'LINK':
					$this->_image_link .= $data;
					break;
				case 'WIDTH':
					$this->_image_width .= $data;
					break;
				case 'HEIGHT':
					$this->_image_height .= $data;
					break;
				case 'TITLE':
					$this->_image_title .= $data;
					break;
			}
        }

		// if we are inside a channel
		elseif ($this->_insidechannel)
		{
			// depending on what tag we are looking at
			// set the appropriate bit variable - notice that the data
			// is added on to the end of the variable, this is because 
			// it's read one bit at a time.
			switch ($this->_tag) 
			{
				case 'TITLE':
					$this->_channel .= $data;
					break;
				case 'DESCRIPTION':
					$this->_channel_description .= $data;
					break;
				case 'LINK':
					$this->_channel_link .= $data;
					break;
			}
		}
	}
}

?>