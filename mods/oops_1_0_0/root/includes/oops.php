<?php
/**
 * Oops - Database Down
 * includes/oops.php
 * 
 * This is the page that will be shown when your database is down. As soon as
 * the database responds, normal service will resume and all your phpBB pages
 * will be available again.
 * 
 * Change the config values below to suit your needs.
 * Remember to bakcslash escape quotes.
 * 
 * You can style the page to look anyway you want by changing the html
 * 
 * @package		oops
 * @version		1.0.0
 * @author		eviL3 <evil@phpbbmodders.net>
 * @author		Joe Belmaati <belmaati@gmail.com>
 * @copyright	(c) 2006 eviL3 & Joe Belmaati
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
 */

/**
 * Adverts are good for you!
 */ 
if( ! defined('IN_PHPBB') )
{
	die ('Oops MOD by eviL3 and Joe Belmaati.<br /><strong>MOD Title:</strong> <a href="http://phpbbmodders.net/goto.php?l=oops">Oops - Database Down</a>');
}

/**
 * Configuration options
 * 
 * Edit the options below for your site
 * Enter values in single quotes...
 */
// The name of your website
$site_name = 'phpBB';

// The page title found in the browser title bar and at the top of the page
$page_title = 'Database temporarily down';

// The error message itself
$error_msg = 'We apologize. Our database is currently experiencing a temporary problem. Please check back again soon.';

// Display this message if an email was sent (and emails are enabled)
$email_sent_msg = 'The Administrator has been notified.';

// Display this message if an email wasn't sent
$email_not_sent_msg = 'The Administrator couldn\'t be notified, please contact him at the email adress below.';

// The message in the email
$email_msg = "$site_name seems to be having database problems. This mail was sent automatically by your board.";

// Your signature
$signature = 'Thank you, the Management';

// Your email address
$admin_email = 'someone@somewhere.com';

// Text to let user send email to admin
$contact_info = 'If you need to get in touch with the Management, you can do so by clicking <a href="' . "mailto: $admin_email" . '"><b>here</b></a>.';

// Send an Email?
// If this option is enabled, an email will be sent to the $admin_email automatically
// Set to "true" or "false"
$send_email = true;

// Text file for saving the sentmail status,
// so you don't get millions of emails :P
// This file must be writable (CHMOD 777)
$text_file = 'oops_mail_sent.txt';

/**
 * End Configuration options
 * Begin Functions
 */

/**
 * Create a file (if it doesn't exist)
 *
 * @param	string $file
 * @return	void
 */
function create_file ($file)
{
    $handle = @fopen($file, 'wbx+');
    @fwrite($handle, '');
    @fclose($handle);
    return;
}

/**
 * Read a file and get the contents
 *
 * @param	string $file
 * @return	string contents
 */
function read_file($file)
{
	if ( ! file_exists($file) )
	{
		return false;
	}
	
	$handle		= @fopen($file, 'r');
	$contents	= @fread($handle, filesize($file));
	@fclose($handle);
	
    return $contents;
}

/**
 * Write to file
 *
 * @param	string $file
 * @param	string $message
 */
function write_file ($file, $message)
{
    // Check if files are writable
	if ( ! is_writable($file) )
	{
		return;
	}
	
    // Open, write and close files
	$handle = @fopen($file, 'wb');
	@fwrite($handle, $message);
	@fclose($handle);
    return;
}

/**
 * End functions
 * Begin actual code
 */

// Send an email
if ($send_email)
{
	// Create the text file
	if( ! file_exists($text_file) )
	{
		create_file ($text_file);
		write_file ($text_file, '0');
	}
	
	// Read the file
	$email_sent = read_file ($text_file);
	
	if (!$email_sent)
	{
		$email_headers = "From: $site_name <$admin_email>\r\n";  
		$email_headers .= "Reply-To: PhpBB-board <$admin_email>\r\n";  
		$email_headers .= "MIME-Version: 1.0\r\n";
		
		if ( @mail ($admin_email, "$site_name - $page_title", $email_msg, $email_headers) )
		{
			write_file ($text_file, '1');
			$email_sent_note = $email_sent_msg;
		}
		else
		{
			$email_sent_note = $email_not_sent_msg;
		}
	}
	else
	{
		$email_sent_note = $email_sent_msg;
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-language" content="en" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title><?php echo $site_name .' :: ' . $page_title ?></title>
<style type="text/css">
/*  phpBB 3.0 Admin Style Sheet
    ------------------------------------------------------------------------
	Original author:	subBlue ( http://www.subBlue.com/ )
	Copyright 2006 phpBB Group ( http://www.phpbb.com/ )
    ------------------------------------------------------------------------
*/


/* General markup styles
---------------------------------------- */
* {
	/* Reset browsers default margin, padding and font sizes */
	margin: 0;
	padding: 0;
}

html {
	font-size: 100%;
	height: 100%;
	margin-bottom: 1px;
	background-color: #E4EDF0;
}

body {
	/* Text-Sizing with ems: http://www.clagnut.com/blog/348/ */
	font-family: Verdana, Helvetica, Arial, sans-serif;
	color: #536482;
	background: #E4EDF0 url("../images/bg_header.gif") 0 0 repeat-x;
	font-size: 62.5%;			/* This sets the default font size to be equivalent to 10px */
	margin: 0;
}

img {
	border: 0;
}

h1 {
	font: bold 1.8em 'Trebuchet MS', Verdana, sans-serif;
	text-decoration: none; 
	color: #333333;
}

h2, caption {
	font: bold 1.2em Arial, Helvetica, sans-serif;
	text-decoration: none; 
	line-height: 120%; 
	text-align: left;
	margin-top: 25px;
}

p {
	margin-bottom: 0.7em;
	line-height: 1.4em;
	font-size: 1.1em;
}

hr {
	border: 0 none;
	border-top: 1px solid #999999;
	margin-bottom: 5px;
	padding-bottom: 5px;
	height: 1px;
}

.small { 
	font-size: 1em; 
}


/* General links  */
a:link, a:active, a:visited { 
	color: #006699; 
	text-decoration: none; 
}

a:hover { 
	color: #DD6900; 
	text-decoration: underline; 
}


/* Main blocks
---------------------------------------- */
#wrap {
	padding: 0 20px 15px 20px;
	min-width: 615px;
}

#page-header {
	text-align: right;
	background: none;
	height: 50px;
}

#page-header h1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 1.5em;
	font-weight: normal;
	padding-top: 15px;
}

#page-header p {
	font-size: 1.1em;
}

#page-body {
	clear: both;
}

#page-footer {
	clear: both;
	font-size: 1em;
	text-align: center;
}

#content {
	padding: 30px 10px 10px 10px;
}

#content h1 {
	line-height: 1.2em; 
	margin-bottom: 0px;
}

#main {
	float:left;
	width: 76%;
	margin-left: 3%;
	min-height: 350px;
}

* html #main { 
	height: 350px; 
}

/* Main Panel
---------------------------------------- */
.panel {
	margin: 4px 0;
	background-color: #FFFFFF;
	border: solid 1px  #A9B8C2;
}

span.corners-top, span.corners-bottom, 
span.corners-top span, span.corners-bottom span {
	display: none;
}

/* Special cases for the error page */
#errorpage #page-header a {
	font-weight: bold;
	line-height: 6em;
}

#errorpage #content {
	padding-top: 10px;
}

#errorpage #content h1 {
	color: #DF075C;
}

#errorpage #content h2 {
	margin-top: 20px;
	margin-bottom: 5px;
	border-bottom: 1px solid #CCCCCC;
	padding-bottom: 5px;
	color: #333333;
}
</style>
</head>

<body id="errorpage">

<div id="wrap">
	<div id="page-header">&nbsp;</div>
	<div id="page-body">
		<div class="panel">
			<span class="corners-top"><span></span></span>
			<div id="content">
				<h1><?php echo "{$site_name} - {$page_title}" ?></h1>

				<h2><?php echo $error_msg ?></h2>
				
				<br /><br />
				
				<?php
					if( isset($email_sent_note) )
					{
						echo "<p>$email_sent_note</p>";
					}
				?>
				
				<p><?php echo $contact_info ?></p>
				
				<br /><br />
				
				<p class="small"><?php echo $signature ?></p>
			
			</div>
			<span class="corners-bottom"><span></span></span>

		</div>
	</div>
	<div id="page-footer">
		Powered by phpBB &copy; 2006 <a href="http://www.phpbb.com/">phpBB Group</a>
	</div>
</div>
</body>
</html>
<?php

// Exit script
exit;

?>