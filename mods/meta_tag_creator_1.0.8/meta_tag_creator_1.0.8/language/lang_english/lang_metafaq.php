<?php

// 

// To add an entry to your Blank FAQ Like Page simply add a line to this file in this format:

// $faq[] = array("question", "answer");

// If you want to separate a section enter $faq[] = array("--","Block heading goes here if wanted");

// Links will be created automatically

//

// DO NOT forget the ; at the end of the line.

// Do NOT put double quotes (") in your FAQ entries, if you absolutely must then escape them ie. \"something\"

//

   
$faq[] = array("--","Meta Tag Creator");


$faq[] = array("What is a Site Title?", "A site title is a brief explaination of what your web page is about.  
If your web page happens to be about your favorite movies of 2005, your site title can be &quot;Favorite Movies of 2005&quot;.  Make sure
that your title doesn't contain too many words, doing so will low your SEO.  An optimal Site Title is between 6 - 12 words.");

$faq[] = array("What would be a good Description?", "Make sure that your description doesnt contain too many overally used words.  You want
to describe your site as best as you can with as little text as possible.  An optimal Description is between 12 - 24 words. ");

$faq[] = array("What are some necessary Keywords?", "It is important that your keywords are very specific to what your site is about.  
If your web page is about your favorite movies, you wouldnt want to have keywords such as &quot;movies, my movies, favorite, cool movies&quot;
You will want to use keywords that are not found on 8 billion other sites to better improve your SEO.  If your web page contains 
the movie &quot;The Core&quot; you could use keywords such as &quot;The Core Movie, The Core Actors, etc.&quot;  Make sure that all of 
your keywords are separated with a comma.  An optimal Keywords length is between 0 - 46 words");

$faq[] = array("Do I use my real name for Site Author?", "No you may use whichever name you wish for the other field.  You really cannot
be penalized for this field since it only serves to provide additional information about a web page");

$faq[] = array("Are Robots really on the internet?", "Yes, and the main one that we all know is &quot;Google&quot;  The internet has robots
spidering our pages to collect key words to index so that when someone is searching for a particular subject it will pull up the web pages
that matches the search parameters the most.  Using this Meta Tag Creator improves your odds of getting a better SEO.
<br>
<br>
The following options are available for you to choose from the Robots Drop Down Menu:
<br>
<br>
<i><u>ALL</u></i> - This gives robots permission to spider every directory and page on your site. 
<br>
<br>
<i><u>NONE</u></i> - Of course this means just the opposite, and will deny almost all bots from spidering your site.  I say &quot;almost all&quot;
since there are a few &quot;Bad Bots&quot; out there that tend to ignore our wishes.  For more information on how to block bad bots
<a href=http://www.funender.com/phpBB2/viewtopic.php?t=18577 target=_blank>click here</a>.
<br>
<br>
<i><u>INDEX</u></i> - This command will tell the robot to index your webpage, which is recommended.
<br>
<br>
<i><u>NO INDEX</u></i> - Just the opposite of index...
<br>
<br>
<i><u>FOLLOW</u></i> - This will instruct the robot to follow the links located on your web page. This is your decision, but if you have a forum
where people link to sites with low PR (Page Rank Rating by Google) then it will also decrease your SEO.  I will explain more about this later.
<br>
<br>
<i><u>NO FOLLOW</u></i> - You've guessed it, the opposite of follow.");


$faq[] = array("--","Meta Tag Placement");


$faq[] = array("Where do I place my meta tags?", "Be sure to place your generated Meta Tags in-between your web page's &lt;head&gt; and &lt;/head&gt; tags.
If you are completely new to working with HTML this tutorial <a href=http://www.hotscripts.com/jump.php?listing_id=36583&jump_type=0 target=_blank>located here</a> will help you.");

$faq[] = array("How long does it take for my site to get spidered?", "Well it all depends, usually it could be within an hour, or perhaps even a month.  There are a lot of factors involved, but having
unique content on your site, and visitor activity may speed up this process.  However I do know that it usually takes a month for search engines to update
the content stored in their databases. (Which should only concern you if you had made recent changes to your web pages or deleted some pages
that are still being spidered and show up as 404 errors in your log, which is always annoying) Using a robots.txt file can help this problem, but not by a lot.");


$faq[] = array("--","Miscellaneous");

$faq[] = array("What does Page Rank mean?", "Here is Google's Definition of the PR (PAGE RANK) rating system:
<br>
<br>
&quot;PageRank relies on the uniquely democratic nature of the web by using its vast link structure as an indicator of an individual page's value. In essence, Google interprets a link from page A to page B as a vote, by page A, for page B. 
But, Google looks at more than the sheer volume of votes, or links a page receives; it also analyzes the page that casts the vote. Votes cast by pages that are themselves &quot;important&quot; weigh more heavily and help to make other pages &quot;important.&quot;&quot;
<br>
<br>
Which basically means that if your site provides unique and important content that has a lot of vistiors coming to your site, you will acheive a higher ranking system which
is Google's way of voting for your site.  The Google Toolbar has a built in PR ranking that displays the Page Rank of each page that you visit, unless
it is a secure or a page that requires you to login to view, which of course doesnt show up on Google's Page Rank.  You can learn more info at Google <a href=http://www.google.com/technology/ target=_blank>located here</a>.");

$faq[] = array("How can I prevent a low PR?", "One of the best ways to maintain a high PR rating is to make sure that the content on your site
is unique and interesting to people searching the internet. Having the proper meta tags is a good start, and get other sites to link to you.
Try to avoid linking to sites that have a low PR value, since they may decrease the importance of your page.  Sites with a PR value of 4 or more is considered good, 
since you have to be a very, very large site to have a very high PR rating, so dont get discouraged if your PR rating is low.  It takes a long time for your Page Rank to
increase, as you are reading this FAQ I am sure the PR rating is probably 0 or 1 since this page is fairly new.  Linking to sites such as funender.com
can increase your PR rating :) 
<br>
<br>
The problem with phpBB forums and other scripts out there that use sessions to store user information on those who visit web pages, robots dont like
to spider these pages.  There are scripts out there that rewrite your phpBB forum pages into non-session html pages, however there are some people
that claim to have problems reading unread topics.  I would recommend using the <a href=http://www.funender.com/support/scriptwiz-funender-phpbb-html-archiver.zip>phpBB Archiver</a> that pulls the data from your forums and displays
them for robots to easily spider.");

$faq[] = array("Who wrote the Meta Tag Generator?", "The Meta Tag Generator and FAQ was written by myself who is known by the name of FuNEnD3R to better help you learn more about getting better SEO.  There
are a lot of great sites out there that are unheard of and I wanted to share some things that I have learned to better help your site grow.");

$faq[] = array("Where can I go to learn more?", "To get updated on tips on how to improve your site, you can visit the forums of <a href=http://www.funender.com/phpBB2/index.php target=_blank>www.funender.com</a>.");
//

// End

//



?>
