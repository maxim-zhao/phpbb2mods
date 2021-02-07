<?
/***************************************************************************
 *                            miserable_user.php
 *                            -------------------
 * Copyright: brauchen ma keins, wenn Ihr Verbesserungen habt, postet die auf phpbb2.de
 *
 * Adjusted for addition to the Troll mod by Merlin Sythove <Merlin@silvercircle.org>
 *
 ***************************************************************************/

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

sleep(rand(5,30)); //In all cases, wait!
 
// Odd seconds: problems!! (50% of the time)
if( time() % 2 )
{ 
   $percent = rand(1,100); //percentages

   if( $percent <= '5' )
   {
    // First of all the evilest variant - browser fail ;-)...removed in ver 1.0.2.  Now a blank screen.
	// This option was left seperate instead of consolidation with extra waiting in case we add
	// another option later on
      exit;
   }
   else if ( $percent > '5' && $percent <= '20' )
   {
      //Extra waiting
    sleep(rand(1,60));
   }
   else if ( $percent > '20' && $percent <= '35' )
   {
    //Some error
    $template->pparse('overall_header');
      //message_die(GENERAL_ERROR, "The database is overloaded. Please try again later.", "", __LINE__, __FILE__, $sql);
      message_die(GENERAL_ERROR, "Too many connections. Please try again later.");
   }
   else if ( $percent > '35' && $percent <= '55' )
   {
    //Site not found
      header("Location: mode");
      exit;
   }
   else if ( $percent > '55' && $percent <= '60' )
   {
    //You have a new message
    $template->assign_vars(array(
         'PRIVATE_MESSAGE_NEW_FLAG' => '1')
      );
   }
   else if ( $percent > '60' && $percent <= '80' )
   {
    //Blank screen
      exit;
   }
   else if ( $percent > '80' && $percent <= '85' )
   {
    //Automatically log out
    session_end($userdata['session_id'], $userdata['user_id']);
   }
   else if ( $percent > '85' )
   {
     //Mysteriously send them to the main index.php
     header("Location: 'index.'.$phpEx");
   }
}
//The other 50% of the time they can do what they came for (after an initial wait)
//The rest of the MOD Troll will make sure that the cannot
//post, PM or email or log in, half the time with an error message, half the time
//with apparent success (but nothing happens).

?>