############################################################## 
## MOD Title: disable-spambots
## MOD Author: magenta < magenta@trikuare.cx > (N/A) http://trikuare.cx/
## MOD Description: Prevent spambots from posting comments to phpBB
## MOD Version: 1.1.4
## 
## Installation Level: Intermediate 
## Installation Time: 3 Minutes 
## Files To Edit: 
##	posting.php 
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##    This mod uses cryptographic signing techniques to ensure
##    that any comment submissions have occurred from an appropriate
##    comment form (stopping simple random-submission bots), that
##    the form was actually generated for the user who is submitting
##    (stopping clusters of page-scraping spiders), and that at
##    least 5 seconds have passed between the form generation and
##    the submission (stopping bots which fully scrape the page
##    and then immediately submit).  If one of these conditions
##    is not met, the submit operation is turned into a preview,
##    giving human posters another chance to submit.
##
##    Since implementing this mod, my forum has only gotten two
##    spams posted to it, and both were manually posted by a
##    human.  Countless thousands of spams were blocked.
##
##    For added security, you should change the "nana" and "foofoo"
##    text inserted in the first "BEFORE, ADD" step so that
##    spambots can't simply spoof the form values as well.
## 
############################################################## 
## MOD History: 
## 
## 2005-03-28 - Version 1.1.4
##	- Another day, another bug fix.  (Removed some debug code which snuck into the released version which was breaking a lot of stuff.)
## 2005-03-20 - Version 1.1.3
##	- Resubmission for standards compliance (sorry, I didn't know what was meant by "extra spaces")
## 2005-03-18 - Version 1.1.2
##	- Resubmission for standards compliance
## 2005-03-12 - Version 1.1.1
##	- Fixed a slight problem with an error message
## 2005-03-12 - Version 1.1.0
##	- Fixed a really dumb bug which always generated a false-positive on a quoted reply
##	- Added a little more obfuscation to the posting time value
## 2004-07-13 - Version 1.0.1
##	- Resubmission to comply with phpBB coding standards
## 2004-07-02 - Version 1.0.0
##	- Initial release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$refresh = $preview || $poll_add || $poll_edit || $poll_delete;

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
switch ($mode) {
case 'newtopic':
	$secretkey = 'f' . $forum_id;
	break;

case 'quote':   // If we're quoting, we need to determine the topic ID
	$sql = 'SELECT topic_id FROM ' . POSTS_TABLE . ' WHERE post_id=' . $post_id;
        if (!($query = $db->sql_query($sql)))
	{
                message_die(GENERAL_MESSAGE, 'Could not obtain quoted topic information', '', __LINE__, __FILE__, $sql);
	}

        if (($row = $db->sql_fetchrow($query)))
	{
                $topic_id = $row['topic_id'];
	}
        else
	{
                message_die(GENERAL_MESSAGE, 'No_such_post');
	}
        // Fall through to 'reply' case

case 'reply':
case 'vote':
        $secretkey = 't' . $topic_id;
        break;
case 'editpost':
        $secretkey = 'p' . $post_id;    
        break;
}

// Generate a signature to validate this page
$authkey = md5("nana" . $secretkey . "foofoo");
$authval = md5($HTTP_SERVER_VARS['HTTP_USER_AGENT'] . $secretkey . $HTTP_SERVER_VARS['REMOTE_ADDR']);  
$timekey = md5("time" . $secretkey);
$timepad = preg_replace('/[^0-9]/', '', $HTTP_SERVER_VARS['REMOTE_ADDR']) + 0;
$timeval = time() ^ $timepad;

// Check the signature - if this is a submit which doesn't jive with the above, turn it into a preview
if ($submit && (!isset($HTTP_POST_VARS[$authkey])
                || $HTTP_POST_VARS[$authkey] != $authval
                || !isset($HTTP_POST_VARS[$timekey])
                || ($HTTP_POST_VARS[$timekey] ^ $timepad) > time() - 5))
{
	$submit = false;
	$preview = true;
}

# 
#-----[ FIND ]------------------------------------------ 
# 
// Generate smilies listing for page output
generate_smilies('inline', PAGE_POSTING);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// Insert our signature into the form
$hidden_form_fields .= '<input type="hidden" name="' . $authkey . '" value="' . $authval . '">';
$hidden_form_fields .= '<input type="hidden" name="' . $timekey . '" value="' . $timeval . '">';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
