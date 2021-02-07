<?php
#################################################################
##
## forums.php - phpBBToGo - display list of forums
##
#################################################################

//
// Prevent hacking attempt.
//

if (!defined('IN_PHPBB')) {
    define('IN_PHPBB', true);
}

//
// Include the phpBBToGo file.
//

include ('./phpbbtogo.php');

//
// Fetches a list of forums.
// Note: Be SURE that THE FORUMS EXISTS.
//

$forums = phpbb_fetch_forums($CFG['mobile_forums']);

?>

<html>
<head>
<meta name="Copyright" content="phpBB Group &copy; 2002">
<title><?php echo $CFG['mobile_title']; ?></title>
</head>

<?php 
IF ($CFG['mobile_home_page_path'] != '') 
{
   echo "<p ALIGN='" . $CFG['nav_bar_alignment'] . "'>";
?>
   <a href="<?php echo $CFG['mobile_home_page_path'] ?>"><?php echo $CFG['mobile_home_page_title'] ?></a>
   <HR WIDTH="50%"
<?php echo " ALIGN='" . $CFG['nav_bar_alignment'] . "' "; ?>
HEIGHT="1 PT" /><p>
<?php
   }

echo $CFG['first_page_header'];

//
// Output all forums.
//

// count($forums[0][0])

$category = "";

for($i=0;$i<=(count($forums[0])-1);$i++) 
{
    IF ($CFG['category_names'] == 1)
       {
       IF ($category != $forums[2][$i])
          {
          IF ($CFG['bullet_forums_list'] == 1 and $category != "")
             {
			 echo "</ul>";
			 }
          $category = $forums[2][$i];
          echo "<strong>";
          echo $forums[2][$i];
          echo "</strong>&nbsp;<br />";
          IF ($CFG['bullet_forums_list'] == 1)
             {
			 echo "<ul>";
			 }
          }
       }
    IF ($CFG['bullet_forums_list'] == 1)
       {
	   echo "<li>";
	   }
    echo "<a href='./topics.php?Id=" . $forums[0][$i] . "'>";
    echo $forums[1][$i] . "</a>";
    IF ($CFG['bullet_forums_list'] == 1)
       {
	   echo "</li>";
	   }
	ELSE
		{
		echo "<p>";
		}
    }
    
IF ($CFG['bullet_forums_list'] == 1)
       {
	   echo "</ul>";
	   }
		
echo $CFG['first_page_footer'];

IF ($CFG['date_time_on_forum'] == 1)
	 {
	 echo "<hr />";
	 echo $lang['Last_updated'];
	 echo ":&nbsp;<br />";
	 echo date($CFG['date_format']);
	 echo "  ";
	 echo date($CFG['time_format']);
	 }
    
?>

</body>
</html>
