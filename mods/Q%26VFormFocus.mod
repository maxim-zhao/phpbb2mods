############################################################## 
## MOD Title: Quick and Versatile Form AutoFocus MOD 
## MOD Author: galfreyday < jennifer@jennifermadden.com > (Jennifer Madden) http://JenniferMadden.com 
## MOD Description: By editing just 1 file, focus cursor on the first visible element of every form 
## (except admin area) in phpBB using JavaScript.  If you want to do this to forms in the admin area of your
## script, John Abela's Form SetFocus MOD script may work better for you. 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: 1 Minute 
## Files To Edit: templates/subSilver/overall_header.tpl 
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## Copyright © Jennifer Madden, < jennifer@jennifermadden.com >
##
##  By editing just 1 file, this MOD will focus the cursor in the first visible field in every non-admin form in phpBB.  
##  This script allows you to block certain fields from being focused in this way (for instance, when the login field  
##  is at the bottom of the page, a "jump" (scroll) to page bottom will occur due to the cursor focusing in that field,
##  potentially startling or confusing a user).
##  See "BLOCK FOCUS" note in script below for instructions on blocking certain pages to prevent this scenario.
############################################################## 
## MOD History: 
## 
##   2004-05-08 - Version 1.0.0 
##   First Release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------
#

</head>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<script language="javascript" type="text/javascript">

function checkFieldType(type){
	if(type == "submit" || type == "reset" || type == "hidden"){
	return false
	}
	else {
	return true
	}
}

function fIt(){

/* ******************************************************************************************
** BLOCK FOCUS INSTRUCTIONS
** The following array named "noFocusPages" was constructed to block the focus script on certain pages.
** The array contains a default list of blocked pages using subsilver template which do not play nice with this script.
** You may add to or from the default list, just be sure the element indexes (numbers between the "[]") 
** are in chronological order after making changes. If you don't want any pages blocked, just comment out 
** the elements (by placing 2 slashes "//" in front of each element statement).
****************************************************************************************** */
var noFocusPages = new Array()
noFocusPages[0] = "index.php"
noFocusPages[1] = "viewforum.php"
noFocusPages[2] = "viewtopic.php"
noFocusPages[3] = "profile.php?mode=viewprofile"
noFocusPages[4] = "search.php?search_author"
noFocusPages[5] = "faq.php"
//noFocusPages[6] = "SampleCommentedOutElement.php"  this is how to comment out an element

var locVar = location.href

	if(locVar.indexOf(".php") == -1){//check to see if url ends with dir+slash (no file name)
	locVar += "index.php"
	}

var formExists = (document.forms[0]) ? document.forms[0] : null

	if(formExists){ //first check to see if there is a form on this page		
		var x = 0
		for(var i=0; i<noFocusPages.length; i++){ // begin looping through noFocusPages array			
				if(locVar.indexOf(noFocusPages[i]) > -1){ // is this a 'no-focus' page?
				x+=1
				break
				}				
		}	//end noFocus for		
		if(x == 0){ //this page is NOT a no-focus page, so focus if there is appropriate field		
			for(var e=0; e<formExists.elements.length; e++){							
				if(checkFieldType(formExists.elements[e].type)){
				formExists.elements[e].focus()
				break
				}									
			}// end elements for											
		}//end if		
	}  //end formExists if
}
</script>

#
#-----[ FIND ]------------------------------------------
#

<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}" onload="fIt()">

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM