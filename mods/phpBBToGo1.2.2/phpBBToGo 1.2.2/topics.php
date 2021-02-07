<?php
#################################################################
##
## topics.php - phpBBToGo - display list of topics
##
#################################################################

//
// Prevent hacking attempt.
//

if (!defined('IN_PHPBB')) 
{
    define('IN_PHPBB', true);
}

//
// Include the phpBBToGo file.
//

include ('./phpbbtogo.php');

//
// Fetch a list of posts out of the forum with the passed Forum_Id
// Note: Be SURE that THIS FORUM EXISTS.
//
// 
// Span, if necessary.
// 
IF ($CFG['span_pages'] = 1)
	{
		if (isset($HTTP_GET_VARS['start']) or isset($HTTP_POST_VARS['start'])) 
		{
			$CFG['offset'] = isset($HTTP_GET_VARS['start']) ? $HTTP_GET_VARS['start'] : $HTTP_POST_VARS['start'];
		}
	}

IF ($HTTP_GET_VARS['Id'] != "") 
   { 
   $posts = phpbb_fetch_posts($HTTP_GET_VARS['Id']); 
   } 
ELSE 
   { 
   $posts = phpbb_fetch_posts($CFG['mobile_forums']); 
   }

?>

<html>
<head>
<meta name="Copyright" content="phpBB Group &copy; 2002">
<title><?php echo $posts[0]['forum_name'] ?></title>
</head>

<?php
IF ($CFG['show_nav_bar'] == 1)
{
	echo "<p ALIGN='" . $CFG['nav_bar_alignment'] . "'>";
	IF ($CFG['mobile_home_page_path'] != '') 
	{
		echo "<a href='";
		echo $CFG['mobile_home_page_path'];
		echo "'>";
		echo $CFG['mobile_home_page_title'];
		echo "</a>";
	}	 
	IF ($CFG['topics_is_index'] == 0)
	{
		IF ($CFG['mobile_home_page_path'] != '') 
	 	{
			echo " | ";
		}
		IF ($CFG['forums_is_index'] == 0)
		{
			echo "<a href='./forums.php'>";
		}
		ELSE
		{
			echo "<a href='./index.php'>";
		}
		echo $CFG['mobile_title']; 
		echo "</a>";
	}
	
	echo "<HR WIDTH='50%' ALIGN='" . $CFG['nav_bar_alignment'] . "' HEIGHT='1 PT' /><p>";

}

IF ($CFG['topics_is_index'] == 1)
{
	echo $CFG['first_page_header'];
}
ELSE
{
	echo $CFG['next_page_header'];
}
		
echo "<center><strong>" . $posts[0]['forum_name'] . "</strong></center><p>";

// 
// Span, if necessary.
// 
IF ($CFG['span_pages'] = 1)
{
	 $nav = eregi_replace('&amp;start', 'start', generate_pagination($PHP_SELF . '?Id=' . $HTTP_GET_VARS['Id'] . '&', $CFG['total'], $CFG['number_of_posts'], $CFG['offset']));
	 IF ($nav != "" and $nav != "Goto page ")
	{
		echo "<p>";
		echo eregi_replace('&amp;start', 'start', generate_pagination($PHP_SELF . '?Id=' . $HTTP_GET_VARS['Id'] . '&', $CFG['total'], $CFG['number_of_posts'], $CFG['offset']));
		echo "<p>";
	}
}

//
// Output all postings.
//

IF ($CFG['bullet_topics'] == 1)
{
echo "<ul>";
}

FOR ($i = 0; $i < count($posts); $i++) 
{
	IF ($CFG['bullet_topics'] == 1)
    {
		echo "<li>";
	}
	
  	IF ($posts[$i]['topic_moved_id'] != 0)
	{
		echo $lang['Topic_Moved'];
	}
	
	IF ($CFG['no_thread'] != 1)
	{
    	echo "<a href='./thread.php?topic_id=";
	   	IF ($posts[$i]['topic_moved_id'] != 0)
		{
			echo $posts[$i]['topic_moved_id'];
		}
     	ELSE
  	 	{
	 		echo $posts[$i]['topic_id'];
	 	}
     	echo "'>";
	}
	
	IF ($CFG['no_thread'] == 1)
	{
		echo "<strong>";
	}
	
	echo $posts[$i]['topic_title'];
	
	IF ($CFG['no_thread'] == 1)
	{
		echo "</strong>";
	}
  	ELSE
    {
		echo "</a>";
	}
	
	IF ($CFG['bullet_topics'] == 1)
	{
		echo '</li>';
	}
	ELSE
	{
		echo '<br />';
	}
	
	IF ($CFG['show_author_on_topics'] == 1)
	{
		echo '<br />';
		echo $lang['Author'] . ': ';
		echo $posts[$i]['username'];
		IF ($CFG['show_ranks'] == 1)
		{
			echo ' (' . $posts[$i]['rank_title'] . ')';
		}
		
	}
	
	IF ($CFG['show_date_on_topics'] == 1 OR $CFG['show_time_on_topics'] == 1)
	{
		echo '<br />';
		echo $lang['Posted'] . ': ';
	}
	
	IF ($CFG['show_date_on_topics'] == 1)
	{
		echo $posts[$i]['date'];
		echo ' ';
	}
	
	IF ($CFG['show_time_on_topics'] == 1)
	{
		echo $posts[$i]['time'];
		echo ' ';
	}
	
	IF ($CFG['show_comments'] == 1)
	{
		echo ' (';
		echo $posts[$i]['topic_replies'] . " " . $lang['Replies'];
  	 	echo ")";
	}
		 
  // Show any of the post text
	IF ($CFG['show_text_on_topics'] == 1)
	{
		echo '<p>';
		IF ($posts[$i]['post_text_for_topics_trimmed'] == 1)
		{
			echo $posts[$i]['post_text_for_topics'];
			IF ($CFG['no_thread'] != 1)
			{
				echo "[<a href='./thread.php?topic_id=";
				IF ($posts[$i]['topic_moved_id'] != 0)
		        {
					echo $posts[$i]['topic_moved_id'];
				}
				ELSE
  	          	{
					echo $posts[$i]['topic_id'];
				}
				echo "'>";
				echo '...';
				echo '</a>]';
			}
		}
     	ELSE
        {
        	echo $posts[$i]['post_text'];
        }
	}
	echo '<p>';
}

IF ($CFG['bullet_topics'] == 1)
{
	echo "</ul>";
}
    
IF ($CFG['topics_is_index'] == 1)
{
	echo $CFG['first_page_footer'];
	IF ($CFG['date_time_on_forum'] == 1)
	{
		echo '<hr />';
		echo $lang['Last_updated'] . ':<br />';
		echo date($CFG['date_format']);
		echo ' ';
		echo date($CFG['time_format']);
	}
}
ELSE
{
	echo $CFG['next_page_footer'];
}

?>

</body>
</html>
