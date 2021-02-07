<?php
//
//	file: includes/acp/acp_fields.php
//	author: ptirhiik
//	begin: 18/12/2005
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

class field_fulltext_index extends field_radio_list
{
	function init()
	{
		parent::init();
		if ( !in_array(SQL_LAYER, array('mysql', 'mysql4')) )
		{
			$this->type = '';
		}
		else
		{
			$this->type = 'radio_list';
		}
	}

	function display()
	{
		if ( $this->type == 'radio_list' )
		{
			parent::display();
		}
	}

	function validate()
	{
		global $db, $config;

		if ( in_array(SQL_LAYER, array('mysql', 'mysql4')) )
		{
			if ( intval($this->value) )
			{
				// check if the index already exists
				$sql = 'SHOW INDEX FROM ' . POSTS_TEXT_TABLE;
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$found = false;
				while ( ($row = $db->sql_fetchrow($result)) && !$found )
				{
					foreach ( $row as $key => $val )
					{
						if ( $found = strtoupper($val) == 'FULLTEXT' )
						{
							break;
						}
					}
				}
				$db->sql_freeresult($result);
				if ( !$found )
				{
					// create the index
					$sql = 'ALTER TABLE ' . POSTS_TEXT_TABLE . '
								ADD FULLTEXT fulltext_search (post_subject, post_sub_title, post_text)';
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}

				// clear other tables
				if ( !$config->data['fulltext_search'] )
				{
					$sql = 'TRUNCATE TABLE ' . SEARCH_WORD_TABLE;
					$db->sql_query($sql, false, __LINE__, __FILE__);

					$sql = 'TRUNCATE TABLE ' . SEARCH_MATCH_TABLE;
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
			}
			else
			{
				$sql = 'ALTER TABLE ' . POSTS_TEXT_TABLE . '
							DROP INDEX fulltext_search';
				$db->sql_query($sql, false, __LINE__, __FILE__, false);
			}
		}
	}
}

?>