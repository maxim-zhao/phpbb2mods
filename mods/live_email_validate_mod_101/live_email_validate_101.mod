##############################################################
## MOD Title: Live Email Validate (LEV)
## MOD Author: Wulf_9 < webmaster@zodiac-infosystems.co.uk > (Wulf) http://www.zodiac-infosystems.co.uk
## MOD Description: When a user signs up or edits their email address, this MOD will
##                  attempt to verify it via the DNS MX records and a test SMTP session,
##                  returning true or false as appropriate. In the event of failure, some
##                  server responses are displayed if DEBUG is set to true in constants.php
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 10 Minutes
##
## Files To Edit: 6
##
##        admin/admin_board.php
##        includes/functions_validate.php,
##        language/lang_english/lang_admin.php
##        language/lang_english/lang_faq.php
##        language/lang_english/lang_main.php
##        templates/subSilver/admin/board_config_body.tpl
##
## Included Files: 1
##
##        lev_mod_db_setup.php
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## This does a live test of a user's mailbox, using the MX
## record for the supplied domain (the part after the @).
## If there is a network issue or all the hosts are down or
## don't respond, it will return 'false', meaning that
## the supplied email address won't be able to be checked
## until the connection works. If this will be a problem,
## this MOD can be enabled/disabled via the ACP. The default
## setting is 'off' after installation. As usual, you are
## advised to check your board config after installing any
## MODs which alter your settings or database.
##
## If not installing via EasyMOD or you won't/can't do the SQL,
## you MUST run the setup script from your forum root before
## attempting to enable the LEV feature via the ACP.
##
## If you use EM to do the install, it will run the SQL for you so
## delete the update script from your forum root without running it.
##
## The Q/A entries in the FAQ page will only be displayed
## if LEV is enabled, allowing for contextual feedback.
##
## Works on unix and windows boxes, since it will auto-detect
## the OS platform and call the relevant function.
##
## Thanks to Alejandro Gervasio at devshed.com for some handy php tips.
##
## ACP option coded by The Defpom http://www.radiomods.co.nz/forum/ have a look for my other forum MODS.
##
## Update for non-RFC-compliant mailservers with thanks to Markus Petrux ( http://www.phpmix.com )
##############################################################
## MOD History:
##
## 2005-08-26 - Version 1.0.1
##   - Modified sender name in HELO message for 'awkward' mailhosts
##   - MOD now enabled by default after installation
##
## 2005-04-11 - Version 1.0.0
##   - Added SQL query for manual/EasyMOD use
##
## 2005-04-04 - Version 0.8.5 beta
##   - Changed some regex functions for PCRE ones to speed up
##     execution time
##   - Code tidying for phpBB standards compliance
##
## 2005-04-02 - Version 0.8.1 beta
##   - Faster loop checks (minimises number of SMTP transactions)
##   - Improved error reporting (SMTP replies) for failed connections
##   - Settings-dependant FAQ section, only shows entries if enabled
##   - Corrected grammatical errors in files and database entries
##
## 2005-04-01 - Version 0.7.5 beta
##   - Improved loop checking
##   - Added SQL setup script for easier install
##
## 2005-03-31 - Version 0.6.5 beta
##   - Added ACP enable/disable switch (thanks to The Defpom, see notes above)
##   - Loop-checks all returned mailhosts to increase chances of success
##   - Error message linked to FAQ page
##
## 2005-03-29 - Version 0.5.0 beta
##   - 'Rough and ready' test version, only checks the first server it finds
##   - No ACP option setting
##   - Simple one-line error message
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]------------------------------------------
#
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('live_email_validation', '1');

#
#-----[ COPY ]------------------------------------------
#
copy lev_mod_db_setup.php   to   lev_mod_db_setup.php

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
$cookie_secure_yes = ( $new['cookie_secure'] ) ? "checked=\"checked\"" : "";

#
#-----[ BEFORE, ADD ]-----------------------------------
#
// +MOD: Live Email Validate (LEV)
$live_email_validation_yes = ( $new['live_email_validation'] ) ? "checked=\"checked\"" : "";
$live_email_validation_no = ( !$new['live_email_validation'] ) ? "checked=\"checked\"" : "";
// -MOD: Live Email Validate (LEV)

#
#-----[ FIND ]------------------------------------------
#
  "L_COOKIE_SETTINGS" => $lang['Cookie_settings'],

#
#-----[ BEFORE, ADD ]-----------------------------------
#
	"L_LIVE_EMAIL_VALIDATION_TITLE" => $lang['Live_email_validation_title'],

#
#-----[ FIND ]------------------------------------------
#
  "S_COOKIE_SECURE_ENABLED" => $cookie_secure_yes,

#
#-----[ BEFORE, ADD ]-----------------------------------
#
	"LIVE_EMAIL_VALIDATION_YES" => $live_email_validation_yes,
	"LIVE_EMAIL_VALIDATION_NO" => $live_email_validation_no,

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_validate.php

#
#-----[ FIND ]------------------------------------------
#
//
// Check to see if email address is banned
// or already present in the DB
//

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// +MOD: Live Email Validate (LEV)
//
// test SMTP mail delivery
function probe_smtp_mailbox($email, $hostname)
{
	global $board_config, $lang, $phpEx;
  @set_time_limit(30);

  if ($connect = @fsockopen($hostname, 25, $errno, $errstr, 15))
  {
    usleep(888);
    $out = fgetss($connect, 1024);

    if (ereg('^220', $out))
    {
      fputs($connect, "HELO " . $board_config['server_name'] . "\r\n");

      while (ereg('^220', $out))
      {
        $out = fgetss($connect, 1024);
      }

      fputs($connect, "VRFY <" . $email . ">\r\n");
      $verify = fgetss($connect, 1024);

      fputs($connect, "MAIL FROM: <" . $board_config['board_email'] . ">\r\n");
      $From = fgetss($connect, 1024);

      fputs($connect, "RCPT TO: <" . $email . ">\r\n");
      $To = fgetss($connect, 1024);

      fputs($connect, "QUIT\r\n");
      fclose($connect);

      if (ereg('^250', $From) && ereg('^250', $To) && !ereg('^550', $verify))
      {
        $result = array('error' => false, 'error_msg' => '');
      }
      else
      {
      	$result = array('error' => true, 'error_msg' => sprintf($lang['Email_unverified'], '<a href="' . append_sid('faq.' . $phpEx) . '">' . $lang['FAQ'] . '</a>') . ((DEBUG == TRUE) ? "<br />Server: $hostname | From: $From| To: " . str_replace('-"', ' ', $To) : ' '));
      }
    }
    @fclose($connect);
  }
  else
  {
  	$result = array('error' => true, 'error_msg' => sprintf($lang['No_connection'], '<a href="' . append_sid('faq.' . $phpEx) . '">' . $lang['FAQ'] . '</a>') . ((DEBUG == TRUE) ? "<br />$hostname : no route to this domain, host unavailable" : ' '));
  }
  return $result;
}

// Try to find an MX record that matches the hostname - Unix
function check_smtp_addr_unix($email)
{
  list($username, $domain) = explode('@', $email);

  if (checkdnsrr($domain, 'MX'))
  {
    getmxrr($domain, $mxhosts);
    $result = probe_smtp_mailbox($email, $mxhosts[0]);

    if ($result['error'] == false)
    {
    	return $result;
    }

    for ($i = 1; $i < count($mxhosts); $i++)
    {
      $result = probe_smtp_mailbox($email, $mxhosts[$i]);
      if ($result['error'] == false)
      {
      	return $result;
      }
    }
    return $result;
  }
  else
  {
  	return (probe_smtp_mailbox($email, $domain));
  }
}

// Try to find an MX record that matches the hostname - Win32
function check_smtp_addr_win($email)
{
  list($username, $domain) = explode('@', $email);
  exec("nslookup -type=MX $domain", $outputs);

  foreach ($outputs as $hostname)
  {
    if (@strpos($domain, $hostname))
    {
      $result =  probe_smtp_mailbox($email, $domain);

      if ($result['error'] == false)
      {
      	return $result;
      }
    }
  }

  if (isset($result))
  {
  	return $result;
  }
  else
  {
  	return (probe_smtp_mailbox($email, $domain));
  }
}
//
// -MOD: Live Email Validate (LEV)

#
#-----[ FIND ]------------------------------------------
#
  global $db, $lang;

#
#-----[ REPLACE WITH ]------------------------------------------
#
  global $db, $lang, $board_config, $phpEx;

#
#-----[ FIND ]------------------------------------------
#
    if (preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $email))
    {

#
#-----[ AFTER, ADD ]------------------------------------
#
      // +MOD: Live Email Validate (LEV)
      if ($board_config['live_email_validation'])
      {
        $system = @preg_match("/Microsoft|Win32|IIS|WebSTAR|Xitami/", $_SERVER['SERVER_SOFTWARE']) ?
        $result = check_smtp_addr_win($email) : $result = check_smtp_addr_unix($email);

        if ($result['error'] == true)
        {
          return array('error' => true, 'error_msg' => $result['error_msg']);
        }
      }
      // -MOD: Live Email Validate (LEV)

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]---------------------------------------------------
#
//
// That's all Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]----------------------------------------------
#
// +MOD: Live Email Validate (LEV)
$lang['Live_email_validation_title'] = 'Use Live Email Validation';
// -MOD: Live Email Validate (LEV)

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_faq.php

#
#-----[ FIND ]------------------------------------------
#
$faq[] = array("--","Login and Registration Issues");

#
#-----[ BEFORE, ADD ]----------------------------------------------
#
global $board_config;

#
#-----[ FIND ]------------------------------------------
#
$faq[] = array("--","User Preferences and settings");

#
#-----[ BEFORE, ADD ]----------------------------------------------
#
// +MOD: Live Email Validate (LEV)
if ($board_config['live_email_validation'])
{
  $faq[] = array("I get <b><i>'Sorry, but this e-mail address cannot be verified'</i></b> when I try to register or change my email address", "The email address you enter is validated live over the internet, if this does not succeed you get this message. Usual reasons : you have mis-spelled the address, the user account does not exist, the mail server is over quota (mailbox full) or otherwise not responding properly.");
  $faq[] = array("I get <b><i>'Could not connect to the mail server'</i></b> when I try to register/change my email address", "There could be several reasons why you get this message, possibly there is a DNS failure (cannot get the IP address of the mail server from the hostname), or the host doesn't exist, or is offline.");
}
// -MOD: Live Email Validate (LEV)

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Email_invalid'] = 'Sorry, but this e-mail address is invalid.';

#
#-----[ AFTER, ADD ]----------------------------------------------
#
// +MOD: Live Email Validate (LEV)
$lang['Email_unverified'] = 'Sorry, but this e-mail address cannot be verified, see the %s page for further info '; // %s is replaced with a link to the FAQ page
$lang['No_connection'] = "Could not connect to the mail server, see the %s page for further info ";
// -MOD: Live Email Validate (LEV)

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
  <tr>
    <td class="row1">{L_ACCT_ACTIVATION}</td>
    <td class="row2"><input type="radio" name="require_activation" value="{ACTIVATION_NONE}" {ACTIVATION_NONE_CHECKED} />{L_NONE}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_USER}" {ACTIVATION_USER_CHECKED} />{L_USER}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_ADMIN}" {ACTIVATION_ADMIN_CHECKED} />{L_ADMIN}</td>
  </tr>

#
#-----[ AFTER, ADD ]----------------------------------------------
#
	<tr>
		<td class="row1">{L_LIVE_EMAIL_VALIDATION_TITLE}</td>
		<td class="row2"><input type="radio" name="live_email_validation" value="1" {LIVE_EMAIL_VALIDATION_YES} /> {L_YES}&nbsp; &nbsp;<input type="radio" name="live_email_validation" value="0" {LIVE_EMAIL_VALIDATION_NO} />{L_NO}</td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
