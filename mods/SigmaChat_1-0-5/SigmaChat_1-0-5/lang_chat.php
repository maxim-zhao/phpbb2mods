<?php
/***************************************************************************
 *                          lang_chat.php [english]
 *                            -------------------
 *   begin                : Saturday, March 26, 2005
 *   copyright            : (C) 2005 Jason Sanborn
 *   email                : jsanborn@digitalstylus.com
 *   version              : 1.0.5 - 2005/07/02
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

// 
// To add an entry to your chat FAQ simply add a line to this file in this format:
// $faq[] = array("question", "answer");
// If you want to separate a section enter $faq[] = array("--","Block heading goes here if wanted");
// Links will be created automatically
//
// DO NOT forget the ; at the end of the line.
// Do NOT put double quotes (") in your chat FAQ entries, if you absolutely must then escape them ie. \"something\"
//
// The chat FAQ items will appear on the chat FAQ page in the same order they are listed in this file
//
// If just translating this file please do not alter the actual HTML unless absolutely necessary, thanks :)
//
  
$faq[] = array("--","Resolving Common Problems");
$faq[] = array('My web browser reports "load: class Client not found" error when loading Chat.', "The <i>Load class Client not found</i> error is among the most notorious of Java applet error messages, and can be caused by a number of different problems. Usually, this problem indicates that your web browser has downloaded/cached an invalid copy of our chat software (cache instability or an error in download). Minor network glitches between your computer and RaiderSoft's servers can also cause the problem. Ninety-nine percent of the time, the problem can be resolved by emptying your browsers cache (or Temporary Internet Files), then shutting down all instances of your web browser, and trying again. In rare circumstances, a reboot may be required.");
$faq[] = array("When I attempt to open the Java&#153 applet, I see a blank gray box only.", 'Try emptying your browser\'s cache first. Remember to shut down all instances of your web browser after emptying the cache (temporary internet files). If this does not work, it is possible that you do not have Java&#153; installed. Please visit <a href="http://www.java.com/" target="getjava">Sun\'s Free Java&#153; Download Site</a> to download and install Java. Java is the most powerful extension to web technology today, and no web browser is complete without it!');
$faq[] = array('My web browser reports a "bad magic number" error when loading Chat.', 'Try emptying your browser\'s cache first. Remember to shut down all instances of your web browser after emptying the cache (temporary internet files). If this does not work, it is possible that you do not have Java&#153; installed. Please visit <a href="http://www.java.com/" target="getjava">Sun\'s Free Java&#153; Download Site</a> to download and install Java. Java is the most powerful extension to web technology today, and no web browser is complete without it!');
$faq[] = array("When I attempt to open the Java&#153; applet, I see a red checkbox only.", 'Try emptying your browser\'s cache first. Remember to shut down all instances of your web browser after emptying the cache (temporary internet files). If this does not work, it is possible that you do not have Java&#153; installed. Please visit <a href="http://www.java.com/" target="getjava">Sun\'s Free Java&#153; Download Site</a> to download and install Java. Java is the most powerful extension to web technology today, and no web browser is complete without it!');
$faq[] = array("When I attempt to open the chat room, a message appears telling me to install software. What is wrong?",'You need to install Java&#153; support. On most computers, you can simply follow the on-screen directions to have Java&#153; installed for you automatically by your web browser. If this fails, we strongly encourage you to visit <a href="http://www.java.com/" target="getjava">Sun\'s Free Java&#153; Download Site</a> to download and install Java. Java is the most powerful extension to web technology today, and no web browser is complete without it!');
$faq[] = array("My Macintosh computer is having various problems with Chat.","Chat is not supported on Macintosh OS 8.x and below systems. SigmaChat runs best on OS X when using MSIE, Netscape or Mozilla. When using OS 9 we recommend using MSIE only. Problems have been reported when using the Safari browser.");
$faq[] = array("I connect to to the Internet with AOL, but am unable to login to the Java&#153; applet.","Do not use the built-in AOL web browser. Instead, use the web browser (usually Microsoft Internet Explorer) that was included with your computer/operating system.");
$faq[] = array('When I click "Login" nothing happens, or a message appears telling me that it cannot connect, or that I have been disconnected. What is wrong?','First, check to make sure that all of our chat servers are online. Check <a href="http://client.sigmachat.com">here</a>. If a server is offline, simply wait a few minutes. It is extremely rare that our chat servers go down, and we have automated systems in place to ensure they are back up and running within 10 minutes of going down. Secondly, and the most likely scenario, is that you are using a computer restricted by a firewall; see below:');
$faq[] = array("I am using a computer behind a firewall, or in a work/education environment. How can I connect?",'For Chat, you, or your network administrator, will need to allow TCP access on ports 8000 through 8009 at client.sigmachat.com. On some LAN firewalls, you may simply set the security setting to "Low" while you wish to use our chat software.');

$faq[] = array("--","Clearing cache in various browsers");
$faq[] = array("Clearing Temporary Internet Files (Cache) in Microsoft Internet Explorer", "<ol><li>Click on <b>Tools</b> from your browser's main menu.</li><li>Select <b>Internet Options</b></li><li>Under the <b>General</b> tab, click <b>Delete Files...</b> in the <b>Temporary Internet files</b> section.<li><b>Important:</b> Shutdown <i>all</i> open instances of your web browser.</li></ol>");
$faq[] = array("Clearing Cache in Netscape Navigator", "<ol><li>Click on <b>Edit</b> from your browser's main menu.</li><li>Select <b>Preferences</b></li><li>Select and expand the <b>Advanced</b> category.</li><li>Click on <b>Cache</b><li>Under <b>Set Cache Options</b>:<ol><li>Click <b>Clear Memory Cache</b></li><li>Click <b>Clear Disk Cache</b></li></ol></li><li>Click <b>OK</b></li><li><b>Important:</b> Shutdown <i>all</i> open instances of your web browser.</li></ol>");
$faq[] = array("Clearing Cache in Mozilla Firefox", "<ol><li>Click on <b>Tools</b> from your browser's main menu.</li><li>Select <b>Options</b></li><li>Click on <b>Privacy</b> image</li><li>Find <b>Cache</b> towards bottom of window</li><li>Click <b>Clear</b> button to right of <b>Cache</b></li><li><b>Important:</b> Shutdown <i>all</i> open instances of your web browser.</li></ol>");

$faq[] = array("--","Other Issues");
$faq[] = array("I am still having problems. Who should I contact?",'If your question wasn\'t answered here, please post your question in <a href="viewforum.php?f=4">Forum Issues and Support</a> in the Forums. We will try to answer your question as quickly as possible.');

//
// This ends the chat FAQ entries
//

?>