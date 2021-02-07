<?php
/**************************************************************************
 *
 *   phpdomxml-0.9.0 - an XML Document Object Model implementation
 *   for PHP 4.10+.
 *   
 *   (c) copyright 2002-2004, webtweakers.com. All rights reserved.
 *   By: Bas van Gaalen (bas at webtweakers dot com)
 *   
 *   $Id: xml.php 7 2006-04-13 18:05:54Z vic $
 * 
 *   Modified by Vic D'Elfant (phpBB Group) to obey the phpBB 3 coding
 *   guidelines
 *
 **************************************************************************/
 
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
	die("Hacking attempt");
}

// Define element type constants
define('XML_ELEMENT_NODE', 1);
define('XML_TEXT_NODE', 3);
define('XML_CDATA_SECTION_NODE', 4);
define('XML_COMMENT_NODE', 8);
define('XML_DOCUMENT_NODE', 9);

// Define exceptions codes
define('XML_INDEX_SIZE_ERR', 1);
define('XML_NOT_FOUND_ERR', 8);

define('XML_NO_FILE_ERR', 100);
define('XML_FILE_NOT_FOUND_ERR', 101);
define('XML_UNABLE_TO_OPEN', 102);
define('XML_UNABLE_TO_WRITE', 103);

define('XML_UNABLE_TO_CONNECT', 110);
define('XML_UNKNOWN_RESPONSE', 111);

define('XML_TYPE_MISMATCH', 120);


	// -------------------------------------------------------------------------
	/**
	 * XML_dom_exception class
	 *
	 * A static class, used to raise DOM Exceptions.
	 *
	 * @package phpdomxml
	 */
	class XML_dom_exception {

		/**
		 * Trigger a PHP error message.
		 *
		 * @param int $err_code the error code
		 * @param string $err_text the error message
		 */
		function raise($err_code, $err_text) {
			die('<p>DOMException: '.$err_code.': '.$err_text.'</p>');
		}

	}



// -------------------------------------------------------------------------
/**
 * XML_node interface
 *
 * The XML_node interface is the primary datatype for the entire Document
 * Object Model. It represents a single node in the document tree.
 *
 * @package phpdomxml
 */
class XML_node
{
	// Name of this node
	var $node_name;

	// Value of this node
	var $node_value;

	/** the type of this node */
	var $node_type;

	var $parent_node		= null;
	var $child_nodes		= array();
	var $first_child		= null;
	var $last_child			= null;
	var $previous_sibling	= null;
	var $next_sibling		= null;
	var $attributes			= null;
	var $owner_document		= null;

	/**
	 * XML_node class constructor
	 */
	function XML_node()
	{
		$this->_id = rand();
	}

	/**
	 * Appends the specified child node to the XML object's child list.
	 * @param $new_child the new child to add
	 */
	function append_child(&$new_child)
	{
		// set parent and owner
		$new_child->owner_document =& $this->owner_document;
		$new_child->parent_node =& $this;

		// Add child to list of child_nodes
		$this->child_nodes[] =& $new_child;

		// Set child's previous_sibling
		$new_child->previous_sibling =& $this->last_child;

		// Set current last_child's next_sibling to this child
		if ( !is_null($this->last_child) )
		{
			$this->last_child->next_sibling =& $new_child;
		}

		// Now (re)set first_child and last_child
		$this->first_child =& $this->child_nodes[0];
		$this->last_child =& $new_child;

		return $new_child;

	}

	function has_attributes()
	{
		return !is_null($this->attributes);
	}

	function has_child_nodes()
	{
		return !empty($this->child_nodes);
	}

	// Inserts the node new_child before the existing child node ref_child.
	// If ref_child is null, insert new_child at the end of the list of
	// children.
	function insert_before(&$new_child, $ref_child = null)
	{
		if ( is_null($ref_child) )
		{
			// append to end
			return $this->append_child($new_child);
		}

		// set parent and owner
		$new_child->owner_document =& $this->owner_document;
		$new_child->parent_node =& $this;

		// browse child_nodes list and create new structure
		$len = count($this->child_nodes);
		$new_list = array();
		
		for ( $i = 0; $i < $len; $i++ )
		{
			$child =& $this->child_nodes[$i];
			
			if ( $child->_id == $ref_child->_id )
			{
				if ( $i == 0 )
				{
					// new_child is first in list
					$this->first_child =& $new_child;
					$new_child->previous_sibling = null;

				}
				else
				{
					// get previous in list and set refs
					$prev_child =& $this->child_nodes[$i-1];
					$prev_child->next_sibling =& $new_child;
					$new_child->previous_sibling =& $prev_child;
				}

				// insert new_child before child
				$new_child->next_sibling =& $child;
				$child->previous_sibling =& $new_child;

				// insert in child_nodes list
				$new_list[] =& $new_child;
			}

			$new_list[] =& $child;
		}

		// replace old list with new one
		$this->child_nodes = $new_list;

		// return inserted child
		return $new_child;

	}

	function remove_child($old_child)
	{
		// browse child_nodes list and create new structure
		$found = false;
		$len = count($this->child_nodes);
		$new_list = array();
		
		for ( $i = 0; $i < $len; $i++ )
		{
			$child =& $this->child_nodes[$i];
			
			if ( $child->_id == $old_child->_id )
			{
				$found = true;

				// get prev & next child
				$prev_child =& $child->previous_sibling;
				$next_child =& $child->next_sibling;

				// reset siblings
				if ( is_null($prev_child) && !is_null($next_child) )
				{
					// first child in list
					$this->first_child =& $next_child;
					$next_child->previous_sibling = null;

				}
				elseif ( !is_null($prev_child) && !is_null($next_child) )
				{
					// somewhere in middle of list
					$prev_child->next_sibling =& $next_child;
					$next_child->previous_sibling =& $prev_child;

				}
				elseif ( !is_null($prev_child) && is_null($next_child) )
				{
					// last child in list
					$this->last_child =& $prev_child;
					$prev_child->next_sibling = null;

				}

			}
			else
			{
				$new_list[] =& $child;
			}
		}

		if ( $found )
		{
			// replace old list with new one
			$this->child_nodes = $new_list;

			// return inserted child
			return $old_child;
		}

		XML_dom_exception::raise(XML_NOT_FOUND_ERR, 'Child could not be removed: child not found');
	}
	
	// dummies
	function replace_child($newChild, $oldChild) {}
	function get_elements_by_tag_name($tag_name) { }
	function get_element_by_id($id) { }
	function to_string($pretty = false, $tabs = '') { }
}



// -------------------------------------------------------------------------
/**
 * XML_Element intrface
 *
 * Element nodes are among the most common objects in the XML document tree.
 * Element nodes can have attributes associated with them.
 *
 * @package phpdomxml
 */
class XML_element extends XML_node {

	// Constructor
	function XML_element($tag_name)
	{
		$this->XML_node();
		$this->node_name = $tag_name;
		$this->node_type = XML_ELEMENT_NODE;
	}

	// Retrieves an attribute value by name
	function get_attribute($name)
	{
		return ( $this->has_attribute($name) ) ? $this->attributes[$name] : '';
	}

	// return elements with specified attribute 'id' set
	function get_element_by_id($id)
	{
		// is this one of the elements we're looking for?
		if ( $this->get_attribute('id') == $id )
		{
			return $this;
		}

		// browse children
		if ( $this->has_child_nodes() )
		{
			foreach ( $this->child_nodes as $child )
			{
				if ( $child->get_attribute('id') == $id )
				{
					return $child;
				}
			}
		}

		return null;
	}

	// Return elements with specified tag name
	function get_elements_by_tag_name($tag_name)
	{
		$elms = array();

		// is this one of the elements we're looking for?
		if ( $this->node_name == $tag_name || $tag_name == '*' )
		{
			$elms[] = $this;
		}

		// browse
		if ( $this->has_child_nodes() )
		{
			foreach ( $this->child_nodes as $child )
			{
				if ( is_array($child->get_elements_by_tag_name($tag_name)) )
				{
					$elms = array_merge($elms, $child->get_elements_by_tag_name($tag_name));
				}
			}
		}

		return $elms;
	}

	// Returns true when an attribute with given name exists
	function has_attribute($name)
	{
		return isset($this->attributes[$name]);
	}

	// Removes an attribute by name
	function remove_attribute($name)
	{
		unset($this->attributes[$name]);
	}

	// Adds a new attribute, or changes an existing one
	function set_attribute($name, $value)
	{
		$this->attributes[$name] = $value;
	}

	function to_string($pretty = false, $tabs = '')
	{
		$s = '';
		
		if ( $pretty )
		{
			$s .= $tabs;
		}
		
		$s .= '<' . $this->node_name;

		// collect attributes, if any
		if ( $this->has_attributes() )
		{
			foreach ( $this->attributes as $key => $val )
			{
				$s .= ' ' . $key . '="' . $val . '"';
			}
		}

		// collect children, if any
		if ( $this->has_child_nodes() )
		{
			$s .= '>';
			
			if ( $pretty )
			{
				$s .= "\n";
			}
			
			foreach ( $this->child_nodes as $child )
			{
				$s .= $child->to_string($pretty, $tabs . "\t");
			}
			
			if ( $pretty )
			{
				$s .= $tabs;
			}
			
			$s .= '</' . $this->node_name . '>';
			
			if ( $pretty )
			{
				$s .= "\n";
			}
		}
		else
		{
			$s .= '/>';
			if ( $pretty )
			{
				$s .= "\n";
			}
		}

		return $s;
	}
}



// -------------------------------------------------------------------------
/**
 * XML_character_data interface
 *
 * The XML_character_data interface extends XML_node with a set of attributes
 * and methods for accessing character data in the DOM.
 *
 * @package phpdomxml
 */
class XML_character_data extends XML_node
{
	var $data;
	var $length;

	// XML_character_data Constructor
	function XML_character_data($data)
	{
		$this->XML_node();
		$this->data = $data;
		$this->length = strlen($data);
	}

	// Appends the supplied string to the existing string data
	function append_data($data)
	{
		$this->data .= $data;
		$this->node_value = $this->data;
		$this->length = strlen($this->data);
	}

	// Deletes specified data.
	function delete_data($offset, $count)
	{
		if ( $offset < 0 || $offset > $this->length )
		{
			XML_dom_exception::raise(INDEX_SIZE_ERR, 'offset ' . $offset . ' is out of range');
		}
		
		if ( $count < 0 )
		{
			XML_dom_exception::raise(INDEX_SIZE_ERR, 'count ' . $count . ' is out of range');
		}
		
		$this->data = substr($this->data, 0, $offset) . substr($this->data, $offset + $count);
		$this->node_value = $this->data;
		$this->length = strlen($this->data);
	}

	// Inserts a string at the specified offset
	function insert_data($offset, $data)
	{
		if ( $offset < 0 || $offset > $this->length )
		{
			XML_dom_exception::raise(INDEX_SIZE_ERR, 'offset ' . $offset . ' is out of range');
		}
		
		$this->data = substr($this->data, 0, $offset) . $data . substr($this->data, $offset);
		$this->node_value = $this->data;
		$this->length = strlen($this->data);
	}

	// Replaces the specified number of characters with the supplied string
	function replace_data($offset, $count, $data)
	{
		$this->delete_data($offset, $count);
		$this->insert_data($offset, $data);
	}

	// Retrieves a substring of the full string from the specified range
	function substring_data($offset, $count)
	{
		if ( $offset < 0 || $offset > $this->length )
		{
			XML_dom_exception::raise(INDEX_SIZE_ERR, 'offset ' . $offset . ' is out of range');
		}
		
		if ( $count < 0 )
		{
			XML_dom_exception::raise(INDEX_SIZE_ERR, 'count ' . $count . ' is out of range');
		}
		
		return substr($this->data, $offset, $count);
	}
}



// -------------------------------------------------------------------------
/**
 * XML_comment interface
 *
 * The content refers to all characters between the start <!-- and end -->
 * tags.
 *
 * @package phpdomxml
 */
class XML_comment extends XML_character_data {

	// Constructor
	function XML_comment($comment)
	{
		// call parent's constructor
		parent::XML_character_data($comment);

		$this->node_name = '#comment';
		$this->node_value = $comment;
		$this->node_type = XML_COMMENT_NODE;
	}

	function to_string($pretty = false, $tabs = '')
	{
		$s = '';
		
		if ( $pretty )
		{
			$s .= $tabs;
		}
		
		$s .= '<!-- ' . $this->node_value . ' -->';
		
		if ( $pretty )
		{
			$s .= "\n";
		}
		
		return $s;
	}
}



// -------------------------------------------------------------------------
/**
 * XML_text interface
 *
 * XML refers to this text content as character data and distinguishes it
 * from markup, the tags that modify that character data. 
 *
 * @package phpdomxml
 */
class XML_text extends XML_character_data {

	// Constructor
	function XML_text($text)
	{
		// call parent's constructor
		parent::XML_character_data($text);
		
		$this->node_name = '#text';
		$this->node_value = $text;
		$this->node_type = XML_TEXT_NODE;
	}

	function to_string($pretty = false, $tabs = '')
	{
		$s = '';
		
		if ( $pretty )
		{
			$s .= $tabs;
		}
		
		$s .= $this->node_value;
		
		if ( $pretty )
		{
			$s .= "\n";
		}
		
		return $s;
	}
}



// -------------------------------------------------------------------------
/**
 * XML_cdata_section interface
 *
 * Every CDATA-section in an XML document transforms into the Node of the
 * type CDATASection in DOM. The XML_cdata_section interface inherits the
 * XML_character_data interface through the XML_text interface.
 *
 * @package phpdomxml
 */
class XML_cdata_section extends XML_text {

	// Constructor
	function XML_cdata_section($data)
	{
		$this->node_name = '#cdata-section';
		$this->node_value = $data;
		$this->node_type = XML_CDATA_SECTION_NODE;
	}

	function to_string($pretty = false, $tabs = '')
	{
		$s = '';
		
		if ( $pretty )
		{
			$s .= $tabs;
		}
		
		$s .= '<![CDATA[' . $this->node_value . ']]>';
		
		if ( $pretty )
		{
			$s .= "\n";
		}
		
		return $s;
	}
}



// -------------------------------------------------------------------------
/**
 * XML_document interface
 *
 * The XML_document interface represents the entire HTML or XML document.
 * Conceptually, it is the root of the document tree, and provides the
 * primary access to the document's data.
 *
 * @package phpdomxml
 */
class XML_document extends XML_node {

	function XML_document()
	{
		$this->XML_node();
		$this->node_name = '#document';
		$this->node_type = XML_DOCUMENT_NODE;
	}

	function &create_cdata_section($data)
	{
		$node =& new XML_cdata_section($data);
		$node->owner_document =& $this;
		
		return $node;
	}

	function &create_comment($comment)
	{
		$node =& new XML_comment($comment);
		$node->owner_document =& $this;
		
		return $node;
	}

	// Creates a new XML element with specified name
	function &create_element($tag_name)
	{
		$node =& new XML_Element($tag_name);
		$node->owner_document =& $this;
		
		return $node;
	}

	// Creates a new XML text node with specified text
	function &create_text_node($text)
	{
		$node =& new XML_text($text);
		$node->owner_document =& $this;
		
		return $node;
	}

	// Return elements with specified tag name
	function get_elements_by_tag_name($tag_name)
	{
		$elms = array();

		// browse
		foreach ( $this->child_nodes as $child )
		{
			if ( is_array($child->get_elements_by_tag_name($tag_name)) )
			{
				$elms = array_merge($elms, $child->get_elements_by_tag_name($tag_name));
			}
		}

		// return possible list of elements
		return $elms;
	}

	// Return element with specified id
	function get_element_by_id($id)
	{
		// browse children
		foreach ( $this->child_nodes as $child )
		{
			$new_child = $child->get_element_by_id($id);
			
			if ( $new_child->get_attribute('id') == $id )
			{
				return $new_child;
			}
		}

		return null;

	}

	// Evalutes the specified XML object, constructs a textual
	// representation of the XML structure including the node, children
	// and attributes, and returns the result as a string.
	function to_string($pretty = false, $tabs = '')
	{
		$s = '';
		
		foreach ( $this->child_nodes as $child )
		{
			$s .= $child->to_string($pretty, $tabs);
		}
		
		return $s;
	}
}



// -------------------------------------------------------------------------
/**
 * XML class
 *
 * The XML object inherits from XML_document and serves as access point for
 * your XML needs in projects.
 *
 * @package phpdomxml
 */
class XML extends XML_document {

	// Constructor
	function XML($url = '')
	{
		// call parent's constructor
		$this->XML_document();

		// Load the referenced XML document
		if ( !empty($url) )
		{
			$this->load($url);
		}
	}

	/**
	 * Load an XML document from the specified URL.
	 *
	 * @param string $url location where the XML document recides.
	 */
	function load($url = '')
	{
		if ( empty($url) )
		{
			XML_dom_exception::raise(XML_NO_FILE_ERR, 'No file or url specified');
		}
		
		if ( function_exists('file_get_contents') )
		{
			$doc = @file_get_contents($url);
			if ( !$doc || empty($doc) )
			{
				XML_dom_exception::raise(XML_FILE_NOT_FOUND_ERR, 'File not found or document is empty');
			}
		}
		else
		{
			$doc = @file($url);
			
			if ( !$doc || empty($doc) )
			{
				XML_dom_exception::raise(XML_NOT_FOUND_ERR, 'File not found or document is empty');
			}
			
			$doc = implode('', $doc);
		}
		
		$this->parse_xml($doc);
	}

	/**
	 * Save an XML document to the specified file or URL.
	 *
	 * @param string $file_name the file name for the file to create.
	 * @param boolean $pretty true for readable layout, false for no layout.
	 */
	function save($file_name, $pretty = false)
	{
		if ( !$fp = @fopen($file_name, 'w') )
		{
			XML_dom_exception::raise(XML_UNABLE_TO_OPEN, 'Unable to open file ' . $file_name . ' for writing');
		}
		
		if ( !@fwrite($fp, $this->to_string($pretty)) )
		{
			XML_dom_exception::raise(XML_UNABLE_TO_WRITE, 'Unable to open write to '.$file_name);
		}
		
		fclose($fp);
		
		return true;
	}

	/**
	 * Parses the XML text specified in the data argument.
	 *
	 * @param string $data the XML document to parse.
	 */
	function parse_xml($data)
	{
		// Strip white space
		$data = preg_replace("/>\s+</i", "><", $data);

		$parser = new XML_parser($this);
		$parser->parse($data);
	}

	/**
	 * Encodes the specified XML object into an XML document and sends
	 * it to the specified URL using the POST method.
	 *	$url is of the form: (http://)www.domain.com:port/path/to/file
	 *
	 * @param string $url destination where to send the XML document to.
	 */
	function send($url)
	{
		// Get xml document
		$str_xml = $this->to_string();

		// Get url parts
		if ( !preg_match("/http/", $url) )
		{
			$url = "http://" . $url;
		}
		
		$url_parts = parse_url($url);
		$host = isset($url_parts['host']) ? $url_parts['host'] : 'localhost';
		$port = isset($url_parts['port']) ? $url_parts['port'] : 80;
		$path = isset($url_parts['path']) ? $url_parts['path'] : "/";

		// Open a connection with the required host
		$fp = fsockopen($host, $port, $errno, $errstr);
		if ( !$fp )
		{
			XML_dom_exception::raise(XML_UNABLE_TO_CONNECT, 'Unable to connect to ' . $host . ' at port ' . $port . ': (' . $errno . ') ' . $errstr);
		}
		
		// Send the XML document
		$data .= "POST ".$path." HTTP/1.0\r\n";
		$data .= "Host: " . $host . "\r\n";
		$data .= "Content-length: " . strlen($str_xml) . "\r\n";
		$data .= "Content-type: " . $this->content_type . "\r\n";
		$data .= "Connection: close\r\n\r\n";
		$data .= $str_xml . "\r\n";
		
		fputs($fp, $data);

		return $fp;
	}

	/**
	 * Encodes the specified XML object into a XML document, sends
	 *	it to the specified URL using the POST method, downloads
	 * the server's response and then loads it into the target.
	 * $url is of the form: (http://)www.domain.com:port/path/to/file
	 *
	 * @param string $url destination where to send the XML document to.
	 * @param object $target DOM object where the response will be received.
	 */
	function send_and_load($url, &$target)
	{
		// Check target type, fail on wrong type
		if ( gettype($target) != 'object' )
		{
			XML_dom_exception::raise(XML_TYPE_MISMATCH, "Target is of type '" . gettype($target) . "', but should be 'object'");
		}
		
		// Send the xml document
		if ( !$fp = $this->send($url) )
		{
			return false;
		}

		// Recieve response
		$buf = '';
		
		while ( !feof($fp) )
		{
			$buf .= fread($fp, 128);
		}
		
		fclose($fp);

		// Filter xml out response (dump http headers)
		if ( !preg_match("/(<.*>)/msi", $buf, $matches) ) // Greedy match
		{
			XML_dom_exception::raise(XML_UNKNOWN_RESPONSE, 'Unidentified server response: no xml was sent');
		}
		
		$xml_response = $matches[1];
		$target->parse_xml($xml_response);

		return true;
	}
}



// -------------------------------------------------------------------------
/**
 * XML_parser class
 *
 * The XML_parser parses an XML document into a DOM object.
 *
 * @package phpdomxml
 */
class XML_parser
{

	var $dom			= null;
	var $last_child		= null;
	var $parser			= null;
	var $encoding		= 'ISO-8859-1';
	var $in_text		= false;
	var $in_cdata		= false;
	var $cdata			= '';
	var $xml_decl		= '';
	var $version		= null;
	var $doc_type_decl	= '';

	// Constructor
	function XML_parser(&$dom)
	{
		$this->dom =& $dom;
		$this->last_child =& $this->dom;
	}

	// parse raw xml document into 'this'
	function parse($data)
	{
		// Get xml declration from document and set in object
		if ( preg_match("/<?xml\ (.*?)\?>/i", $data, $matches) )
		{
			$this->xml_decl = "<?xml " . $matches[1] . "?>";

			// Get version
			if ( preg_match("/version=\"(.*?)\"/i", $matches[1], $ver) )
			{
				$this->version = $ver[1];
			}

			// Get encoding
			if ( preg_match("/encoding=\"(.*?)\"/i", $matches[1], $enc) )
			{
				$this->encoding = $enc[1];
			}

		}

		// Get document type decleration from document and set in object
		if ( preg_match("/<!doctype\ (.*?)>/i", $data, $matches) )
		{
			$this->doc_type_decl = "<!DOCTYPE " . $matches[1] . ">";
		}

		// try to create parser with found encoding
		$this->parser = @xml_parser_create($this->encoding);

		// if creation failed, use php's default encoding
		if ( !is_resource($this->parser) )
		{
			$this->parser = @xml_parser_create();
		}
		
		// set options
		xml_set_object($this->parser, &$this);
		xml_set_element_handler($this->parser, 'open_handler', 'close_handler');
		xml_set_character_data_handler($this->parser, 'cdata_handler');
		xml_set_default_handler($this->parser, 'data_handler');
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0); 	
		xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);

		// parse the raw data
		xml_parse($this->parser, $data);

		// free used memory
		xml_parser_free($this->parser);
	}

	// tag open handler
	function open_handler(&$parser, $tag, $attr)
	{
		// create the element			
		$node =& $this->dom->create_element($tag);

		// append node to dom structure
		$this->last_child->append_child($node);

		// attach attributes
		while ( list($name, $value) = each($attr) )
		{
			$node->set_attribute($name, $value);
		}

		// next child will be added to this node
		$this->last_child =& $node;
	}

	// tag close handler
	function close_handler(&$parser, $tag)
	{
		// end of multiline text node?
		if ( $this->in_text )
		{
			$this->in_text = false;
			$node =& $this->dom->create_text_node($this->cdata);
			$this->last_child->append_child($node);
			$this->cdata = '';
		}

		// next child will be added to this node's parent
		$this->last_child =& $this->last_child->parent_node;
	}

	// cdata handler
	function cdata_handler(&$parser, $data)
	{
		if ( !$this->in_cdata )
		{
			$this->in_text = true;
		}
		
		$this->cdata .= $data;
	}

	// misc data handler
	function data_handler(&$parser, $data)
	{
		// determine data type
		$prefix = strtolower(substr($data, 0, 3));
		
		switch ( $prefix )
		{
			// xml decleration
			case '<?x':
				break;

			// comment
			case '<!-':
				$node =& $this->dom->create_comment(substr($data, 4, -3));
				$this->last_child->append_child($node);
				
				break;

			// cdata section start
			case '<![':
				$this->in_cdata = true;
				
				break;

			// cdata section end
			case ']]>':
				$this->in_cdata = false;
				$node =& $this->dom->create_cdata_section($this->cdata);
				$this->last_child->append_child($node);
				$this->cdata = '';
				
				break;
		}
	}
}

?>
