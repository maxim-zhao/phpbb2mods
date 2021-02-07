<?php
#################################################################
##
## thread.php - phpBBToGo - display topic thread
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
// Fetches the thread of a given Post/Topic.
//

$topic = $HTTP_GET_VARS['topic_id'];
$start = $HTTP_GET_VARS['start'];

If ($start == '')
	 {
	 $start = 0;
	 }

$posts = phpbb_fetch_thread($topic);

//
// Span, if necessary.
//
IF ($CFG['span_pages_thread'] == 1)
	{
	$CFG['offset_thread'] = $CFG['number_of_posts_thread'] + $start - 1;
	}

?>

<html>
<head>
<meta name="Copyright" content="phpBB Group &copy; 2002">
<title><?php echo $posts[0]['topic_title']; ?></title>
</head>

<body bgcolor="#ffffff">

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
			echo "</a> | ";
		}
	 
	 IF ($CFG['topics_is_index'] == 0)
	 		{
			echo "<a href='./topics.php";
			}
	 ELSE
	 		{
			echo "<a href='.index.php'>";
			}
	 echo '?Id=' . $posts[0]['forum_id'] . "'>";
	 echo $posts[0]['forum_name'] . '</a>';
	 echo "<HR WIDTH='50%' ALIGN='" . $CFG['nav_bar_alignment'] . "' HEIGHT='1 PT' /><p>";
	 }

echo $CFG['next_page_header'];

echo '<center><strong>' . $posts[0]['topic_title'] . '</strong></center><p>';

$goto = count($posts);

//
// Span, if necessary.
//
$CFG['total_thread'] = $posts[0]['topic_replies'] + 1;

//
IF ($CFG['span_pages_thread'] == 1)
{
	 $nav = eregi_replace('&amp;start_thread', 'start_thread', generate_pagination($PHP_SELF . '?topic_id=' . $HTTP_GET_VARS['topic_id'] . '&', $CFG['total_thread'], $CFG['number_of_posts_thread'],  $CFG['offset_thread']));
	 IF ($nav != "" and $nav != "Goto page ")
	 {
		echo "<p>";
		echo $nav;
			
		echo "<p>";
		$goto = $CFG['number_of_posts_thread'] + $start;
		IF ($goto >= count($posts))
			{
			$goto = count($posts);
			}
	}
}

//
// Output all postings.
//
for ($i = $start; $i < $goto; $i++)
{
  
	IF ($i == 0)
	{
		$poll = phpbb_fetch_topic_poll($topic);
		IF ($poll[$i]['vote_text'] != "")
		{
			echo "<p><center><b>- ";
			echo $poll[$i]['vote_text'];
			echo " - &nbsp;<br />";
			echo $lang['Topic_Poll'] . "&nbsp;<br />";
			echo "</b></center>&nbsp;<br />";
        	for ($j = 0; $j < count($poll[$i]['options']); $j++)
			{
				echo "&nbsp;<br />";
				echo $poll[$i]['options'][$j]['vote_option_text'];
				echo " [";
				echo $poll[$i]['options'][$j]['vote_result'];
				echo "]";
			}
			echo $CFG['poll_footer'];
		echo "<p>";
		}
	}
		
	if ($CFG['show_author_on_thread'] == 1)
	{
		echo $posts[$i]['post_subject'];
		echo "&nbsp;<br />";
  	 	echo $lang['Author'] . ": ";
		echo $posts[$i]['username'];
		if ($CFG['show_ranks'] == 1)
		{
		echo " (" . $posts[$i]['rank_title'] . ")";
		}
		echo "&nbsp;<br />";
	}
	
	if ($CFG['show_date_on_thread'] == 1 OR $CFG['show_time_on_thread'] == 1)
	{
		echo $lang['Posted'] . ": ";
	}
		
	if ($CFG['show_date_on_thread'] == 1)
	{
		echo $posts[$i]['date'];
		echo " ";
	}
	if ($CFG['show_time_on_thread'] == 1)
	{
		echo $posts[$i]['time'];
	}
	if ($CFG['show_date_on_thread'] == 1 OR $CFG['show_time_on_thread'] == 1)
	{
		echo "&nbsp;<br />";
	}
	if ($CFG['show_author_on_thread'] == 1 OR $CFG['show_date_on_thread'] == 1 OR $CFG['show_time_on_thread'] == 1)
  	{
	echo "&nbsp;<br />";
	}
  	echo $posts[$i]['post_text'];
  
	IF ($i != ($goto - 1))
	{
	echo "<p><hr />";
	}
}

echo $CFG['next_page_footer'];

?>
</body>
</html>
