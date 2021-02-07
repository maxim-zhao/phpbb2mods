<?php
//
//	file: includes/class_xml.php
//	author: ptirhiik
//	begin: 28/01/2007
//	version: 1.6.0 - 29/01/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class xml_parser
{
	var $errmsg;

	function xml_parser()
	{
		$this->errmsg = false;
	}

	function trigger_error($errmsg)
	{
		$this->errmsg = $errmsg;
		return false;
	}

	function parse($xml)
	{
		if ( empty($xml) )
		{
			return $this->trigger_error('Error in XML schema: empty file');
		}
		$tags_split = '#<([^\?!>]+)>#is';
		$tags_match = '#<([\/])?([^\n\r\s\t\?!>]+)[\n\r\s\t]*([^\?!>\/]*)([\/])?>#is';
		$attrs_match = '#([^=]+)=\"([^\"]*)\"[\n\r\s\t]*#is';

		$tags = array();
		if ( (preg_match_all($tags_match, $xml, $tags) === false) || !($cdata = preg_split($tags_split, $xml)) )
		{
			return $this->trigger_error('Error in XML schema: no tags to parse');
		}

		$res = array();
		$count_tags = count($tags[0]);
		$pointer_stack = array();
		$pointer = &$res;
		for ( $i = 0; $i < $count_tags; $i++ )
		{
			$tag_close = $tags[1][$i] == '/';
			$tag_name = strtolower(trim($tags[2][$i]));
			$tag_attrs = array();
			$match = array();
			if ( $tags[3][$i] && preg_match_all($attrs_match, $tags[3][$i], $match) && ($count_match = count($match[0])) )
			{
				for ( $j = 0; $j < $count_match; $j++ )
				{
					$tag_attrs[ $match[1][$j] ] = $match[2][$j];
				}
			}
			$tag_autoclose = $tags[4][$i] == '/';
			$tag_cdata = trim($cdata[ ($i + 1) ]);

			// store
			if ( $tag_close )
			{
				if ( empty($pointer_stack) || (($pop_name = array_pop($pointer_stack)) && ($pop_name != $tag_name)) )
				{
					return $this->trigger_error('Error in XML schema: un-matched tag');
				}
				$pointer = &$res;
				$count_pointer_stack = count($pointer_stack);
				for ( $j = 0; $j < $count_pointer_stack; $j++ )
				{
					$pointer = &$pointer['cdata'][ (count($pointer['cdata']) - 1) ][ $pointer_stack[$j] ];
				}
			}
			else
			{
				if ( !isset($pointer['cdata']) )
				{
					$pointer['cdata'] = array();
				}
				if ( !is_array($pointer['cdata']) )
				{
					return $this->trigger_error('Error in XML schema: cdata mixed with childs');
				}
				$addr = count($pointer['cdata']);
				$node = $tag_attrs ? $tag_attrs : array();
				if ( $tag_cdata !== '' )
				{
					$node['cdata'] = $tag_cdata;
				}
				$pointer['cdata'][$addr][$tag_name] = $node;
				if ( !$tag_autoclose )
				{
					$pointer = &$pointer['cdata'][$addr][$tag_name];
					array_push($pointer_stack, $tag_name);
				}
			}
		}
		if ( empty($res) )
		{
			return $this->trigger_error('Error in XML schema: no tags have been found');
		}
		return $res;
	}
}

?>