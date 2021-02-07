<?php
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
   $filename = basename(__FILE__);
   $module['General']['index_agreement'] = $filename;

   return;
}
//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path .'language/lang_'. $userdata['user_lang'] .'/lang_admin.'. $phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else 
{
	$mode = "";
}

switch( $mode )
	{
		//
		// Function to save agreement to the database
		//
		case "save":
		
			$agreement = str_replace("\'", "''", $HTTP_POST_VARS['agreement']);
			
				if ($agreement == '')
					{
						message_die(GENERAL_MESSAGE, $lang['no_agreement']);
					}
				else
					{				
						// Update the agreement
						$sql = "UPDATE " . AGREEMENT_TABLE . " SET config_value = '$agreement' WHERE config_name = 'agreement_body'";
							if ( !($db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Error in updating the agreement', '', __LINE__, __FILE__, $sql);
								}
					}
					
				// If all goes as planned let them know
				$message = $lang['agreement_edit_success'] . '<br /><br />' . sprintf($lang['click_return_agreement'], '<a href="' . append_sid('admin_agreement.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
			break;
		default:
		
			$sql = "SELECT * FROM " . AGREEMENT_TABLE . " WHERE config_name = 'agreement_body'"; 
				if ( !($result = $db->sql_query($sql)) ) 
					{ 
						message_die(GENERAL_ERROR, 'Error in retrieving current agreement', '', __LINE__, __FILE__, $sql); 
					}

			$row = $db->sql_fetchrow($result);
			$current_agreement = $row['config_value'];
			
			$template->set_filenames(array(
						"body" => "admin/agreement_edit.tpl")
					);

					$template->assign_vars(array(
						'L_AGREEMENT' => $lang['index_agreement'],
						'L_SAVE' => $lang['save_agreement'],
						'L_AGREEMENT_HEADER' => $lang['agreement_edit_header'],
						'L_AGREEMENT_EXPLAIN' => $lang['agreement_edit_explain'],
						'CURRENT_AGREEMENT' => $current_agreement,

						"S_SAVE_ACTION" => append_sid("admin_agreement.$phpEx?mode=save"),)
					);
					$template->pparse('body');
			break;
	}	
include('./page_footer_admin.'.$phpEx);	
?>