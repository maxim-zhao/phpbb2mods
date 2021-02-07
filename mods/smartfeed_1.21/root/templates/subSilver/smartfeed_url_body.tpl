    <script type="text/javascript">
	
    <!-- Hide from older browsers
	function unCheckAllForums () {
	
		// Unchecks or checks the all forums checkbox
		any_unchecked = false;
		
		// Assume a HTML 4.0 compatible browser
		var x = document.getElementById('dynamicforums');
		for(i=0;((i<x.childNodes.length) && (any_unchecked == false));i++) {
			thisobject = x.childNodes[i];
			element_name = thisobject.name;
			if(element_name != null) {
				if(element_name.substr(0,5) == "forum")
				{
					if (thisobject.checked == false)
					{
						document.news.all_forums.checked = false;
						any_unchecked = true;
					}
				}
			}
		}
		if (any_unchecked == false)
		{
			document.news.all_forums.checked = true;
		}

		return;
	}
		
	function unCheckSubscribedForums (checkbox) {
		is_checked = checkbox.checked;
	 
		var element_name = new String();
		
		// Assume a HTML 4.0 compatible browser
		var x = document.getElementById('dynamicforums');
		for(i=0;i<x.childNodes.length;i++) {
			thisobject = x.childNodes[i];
			element_name = thisobject.name;
			if(element_name != null) 
			{
				if(element_name.substr(0,5) == "forum")
					thisobject.checked = is_checked;
			}
		}
		
		return true;
	}
	
	function check_word_size (field) {
		size = field.value;
		if (isNaN(size))
		{
			if (size != '{MAX_SIZE}')
			{
				alert("{SIZE_ERROR}");
				field.focus();
			}
		}
		else
		{
			if (size < 1) {
				alert("{SIZE_ERROR}");
				field.focus();
			}
		}
	}
	
	function switch_visible (field) {
		var x=document.getElementById("count_limit_box");
		if (field.selectedIndex == 3)
		{
			x.style.visibility = 'visible';
			x.style.display = 'inline';
		}
		else
		{
			x.style.visibility = 'hidden';
			x.style.display = 'none';
		}
	}
	
	function switch_visible_new_topics (field) {
		var x=document.getElementById("firstpostonly_box");
		if (field.checked)
		{
			if (field.id=="topicsonly1")
			{
				x.style.visibility = 'visible';
				x.style.display = 'inline';
			}
			else
			{
				x.style.visibility = 'hidden';
				x.style.display = 'none';
			}
		}
		else
		{
			if (field.id=="topicsonly1")
			{
				x.style.visibility = 'hidden';
				x.style.display = 'none';
			}
			else
			{
				x.style.visibility = 'visible';
				x.style.display = 'inline';
			}
		}
	}
	
	function createURL() {
	
		// Creates a URL for display to be used by the newsreader to actually retrieve the newsfeed.
		var num_checked;
		var process_form;
		var forum_string = "";
		var logged_in = {LOGGED_IN};
         
		num_checked = 0;
		process_form = true;

		var x = document.getElementById('dynamicforums');
		for(i=0;i<x.childNodes.length;i++) {
			thisobject = x.childNodes[i];
			element_name = thisobject.name;
			if(element_name != null) {
				if(element_name.substr(0,5) == "forum") 
				{
					if (thisobject.checked == true) 
					{
						num_checked++;
						forum_string = forum_string + "&forum=" + element_name.substr(6);
					}
				}
			}
		}
		
		// If no forums were checked there is no point in generating a URL. Instead, give a Javascript warning
		// and generate nothing.
		if ((num_checked==0) && (document.news.all_forums.checked==false)) 
		{
			alert("{NO_FORUMS_SELECTED}");
			return false;
		}
		else 
		{
			// create the URL
			url = "{SITE_URL}smartfeed.{PHPEXT}?";
			if (logged_in)
			{
				url = url + "{U_LITERAL}={USER_ID}";
				<!-- BEGIN switch_required_ip_authentication -->
				url = url + "&e={PWD_WITH_IP}";
				<!-- END switch_required_ip_authentication -->
				<!-- BEGIN switch_no_required_ip_authentication -->
				if (document.news.ip_auth[0].checked == true)
				{
					url = url + "&e={PWD_WITH_IP}";
				}
				else
				{
					url = url + "&e={PWD}";
				}
				<!-- END switch_no_required_ip_authentication -->
				if (document.news.remove_yours1.checked == true)
				{
					url = url + "&removemine=1";
				}
			}
			if (logged_in)
			{
				url = url + "&feed_type=" + document.news.feed_type.options[document.news.feed_type.selectedIndex].value;
			}
			else
			{
				url = url + "feed_type=" + document.news.feed_type.options[document.news.feed_type.selectedIndex].value;
			}
			limit = document.news.post_limit.value;
			url = url + "&limit=" + limit;
			if (document.news.sort_by.options[0].selected == true)
			{
				url = url + "&sort_by=standard";
			}
			else 
			{
				if (document.news.sort_by.options[1].selected == true)
				{
					url = url + "&sort_by=standard_desc";
				}
				else 
				{
					if (document.news.sort_by.options[2].selected == true)
					{
						url = url + "&sort_by=postdate";
					}
					else
					{
						if (document.news.sort_by.options[3].selected == true)
						{
							url = url + "&sort_by=postdate_desc";
							if (document.getElementById("count_limit_box").style.visibility == 'visible')
							{
								if (document.getElementById("count_limit").value != 'All')
								{
									url = url +"&count_limit=" + document.getElementById("count_limit").value;
								}
							}
						}
					}
				}
			}
			if (document.news.topicsonly1.checked == true)
			{
				url = url + "&topicsonly=1";
				if (document.news.firstpostonly.checked == true)
				{
					url = url + "&firstpostonly=1";
				}
			}
			if (logged_in)
			{
				if (document.news.lastvisit1.checked == true)
				{
					url = url + "&lastvisit=1";
				}
				if (document.news.pms1.checked == true)
				{
					url = url + "&pms=1";
				}
			}
			if ((document.news.all_forums.checked==false) && (num_checked > 0))
			{
				url = url + forum_string;
			}
			url = url + "&max_word_size=" + document.news.max_word_size.value;
			document.news.url.value = encodeURI(url);
			return true;
		}
		
	}	
	
	function clear_ads ()
	{
		// Clear the section checkboxes
		var z = document.getElementById("enable_top_ad");
		z.checked = false;
		var z = document.getElementById("enable_middle_ads");
		z.checked = false;
		var z = document.getElementById("enable_bottom_ad");
		z.checked = false;
		
		// Clear the section fields
		var z = document.getElementById('title_1');
		z.value = '';
		var z = document.getElementById('title_2');
		z.value = '';
		var z = document.getElementById('title_3');
		z.value = '';
		var z = document.getElementById('link_1');
		z.value = '';
		var z = document.getElementById('link_2');
		z.value = '';
		var z = document.getElementById('link_3');
		z.value = '';
		var z = document.getElementById('desc_1');
		z.value = '';
		var z = document.getElementById('desc_2');
		z.value = '';
		var z = document.getElementById('desc_3');
		z.value = '';
		var z = document.getElementById('repeat');
		z.value = z.defaultValue;
		
	}
	
	function validate_ads ()
	{
		var x = document.getElementById('enable_top_ad');
		var y = document.getElementById('title_1');
		if ((x.checked) && (y.value.length) == 0)
		{
			alert('{L_TITLE_REQUIRED}');
			return false;
		}
	
		var x = document.getElementById('enable_middle_ads');
		var y = document.getElementById('title_2');
		if ((x.checked) && (y.value.length) == 0)
		{
			alert('{L_TITLE_REQUIRED}');
			return false;
		}
	
		var x = document.getElementById('enable_bottom_ad');
		var y = document.getElementById('title_3');
		if ((x.checked) && (y.value.length) == 0)
		{
			alert('{L_TITLE_REQUIRED}');
			return false;
		}
	
		// Validate repeat field
		var x = document.getElementById('repeat');
		if (isNaN(x.value))
		{
			alert('{L_MUST_BE_NUMERIC}');
			return false;
		}
		else if (x.value < 1)
		{
			alert('{L_MUST_BE_GREATER_THAN_0}');
			return false;
		}
		else
		{
			return true;
		}
	}
	
    // End hiding -->  
    </script>
	<h1 style="text-align:center"><span class="gen">{PAGE_TITLE}</span></h1>

	<!-- BEGIN switch_administrator -->
	<h2 style="text-align:center"><span class="gen">{ADVERTISING_TITLE}</span></h2>
	<form name="ads" id="ad" action="smartfeed_url.php" method="post" onsubmit="return validate_ads();">
	<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
		<tr>
			<td colspan="2" class="row2" style="padding: 5px;"><span class="gen">{ADS_INTRO}</span></td>
		</tr>
		<tr>
			<td colspan="2" class="row1" style="padding: 5px;">
				<input type="checkbox" name="enable_ads" id="enable_ads" {CHECKED_ADS}/><span class="gen"><label for="enable_ads">{L_ENABLE_ADS}</label></span><br />
				&nbsp;&nbsp;&nbsp;<input type="checkbox" name="public_only" id="public_only" {PUBLIC_ONLY}/><span class="gen"><label for="public_only">{L_PUBLIC_ONLY}</label></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="row1" style="padding: 5px; text-align:center">
				<span class="gen"><b>{L_HEADER_1}</b></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="row1" style="padding: 5px">
				<input type="checkbox" name="enable_top_ad" id="enable_top_ad" {CHECKED_TOP_AD}/><span class="gen"><label for="enable_top_ad">{L_ENABLE_TOP_AD}</label></span>
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="title_1">{L_TITLE_1}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<input type="text" name="title_1" id="title_1" size="70" maxlength="256" value="{TITLE_1}" class="post" />
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="link_1">{L_LINK_1}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<input type="text" name="link_1" id="link_1" size="70" maxlength="256" value="{LINK_1}" class="post" />
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="desc_1">{L_DESC_1}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<textarea name="desc_1" id="desc_1" cols="70" rows="5" >{DESC_1}</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="row1" style="padding: 5px; text-align:center">
				<span class="gen"><b>{L_HEADER_2}</b></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="row1" style="padding: 5px;"><input type="checkbox" name="enable_middle_ads" id="enable_middle_ads" {CHECKED_MIDDLE_ADS}/><span class="gen"><label for="enable_middle_ads">{L_ENABLE_MIDDLE_ADS}</label></span>
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="repeat">{L_REPEAT}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<input type="text" name="repeat" id="repeat" size="3" maxlength="3" value="{REPEAT}" class="post" />
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="title_2">{L_TITLE_2}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<input type="text" name="title_2" id="title_2" size="70" maxlength="256"  value="{TITLE_2}" class="post" />
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="link_2">{L_LINK_2}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<input type="text" name="link_2" id="link_2" size="70" maxlength="256" value="{LINK_2}" class="post" />
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="desc_2">{L_DESC_2}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<textarea name="desc_2" id="desc_2" cols="70" rows="5" >{DESC_2}</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="row1" style="padding: 5px; text-align:center">
				<span class="gen"><b>{L_HEADER_3}</b></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="row1" style="padding: 5px;"><input type="checkbox" name="enable_bottom_ad" id="enable_bottom_ad" {CHECKED_BOTTOM_AD}/><span class="gen"><label for="enable_middle_ads">{L_ENABLE_BOTTOM_AD}</label></span>
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="title_3">{L_TITLE_3}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<input type="text" name="title_3" id="title_3" size="70" maxlength="256"  value="{TITLE_3}" class="post" />
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="link_3">{L_LINK_3}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<input type="text" name="link_3" id="link_3" size="70" maxlength="256" value="{LINK_3}" class="post" />
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding: 5px;">
				<span class="gen"><label for="desc_3">{L_DESC_3}</label></span>
			</td>
			<td class="row2" style="padding: 5px;">
				<textarea name="desc_3" id="desc_3" cols="70" rows="5" >{DESC_3}</textarea>
			</td>
		</tr>
		<tr id="controls">
			<td colspan="2" align="center" class="catBottom" height="28"><span class="gen"><button type="submit" class="mainoption">{L_ADS_SUBMIT}</button>&nbsp;<button type="button" class="mainoption" onclick="clear_ads();">{L_ADS_CLEAR}</button>&nbsp;<button type="reset" class="liteoption">{L_RESET}</button></span></td>
		</tr>
	</table>
	</form>
	
	<hr />
	
	<!-- END switch_administrator -->
	
	<form name="news" id="news" action="#" method="post">
	<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	  <tr>
		<td class="row2" colspan="2" style="padding: 5px;"><span class="gen">
			<!-- BEGIN switch_no_mcrypt -->
			{MCRYPT_NOT_INSTALLED_MSG}<br /><br />
			<!-- END switch_no_mcrypt -->
			<!-- BEGIN switch_not_logged_in -->
			{NOT_LOGGED_IN_MSG}<br /><br />
			<!-- END switch_not_logged_in -->
			{SMARTFEED_EXPLANATION}
		</span></td>
	  </tr>
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen"><label for="feed_type">{L_FEED_TYPE}</label></span></td>
		<td class="row2" style="padding: 5px;" width="550px"><span class="gen">
		  <select name="feed_type" id="feed_type">
			<option value="{L_ATOM_10_VALUE}">{L_ATOM_10}</option>
			<option value="{L_RSS_20_VALUE}" selected="selected">{L_RSS_20}</option>
			<option value="{L_RSS_10_VALUE}">{L_RSS_10}</option>
			<option value="{L_RSS_091_VALUE}">{L_RSS_091}</option>
		  </select></span>
		</td>
	  </tr>
	  <!-- BEGIN switch_logged_in -->
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen">{L_LASTVISIT}</span></td>
		<td class="row2" style="padding: 5px;" width="550px"><span class="gen">
		  <input type="radio" name="lastvisit" id="lastvisit1" checked="checked" value="YES" /> <label for="lastvisit1">{L_YES}</label>
		  <input type="radio" name="lastvisit" id="lastvisit2" value="NO" /> <label for="lastvisit2">{L_NO}</label></span>
		</td>
	  </tr>
	  <!-- END switch_logged_in -->
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen"><label for="post_limit">{L_LIMIT}</label></span></td>
		<td class="row2" style="padding: 5px;" width="550px"><span class="gen">
		  <select name="post_limit" id="post_limit">
			<option value="{L_LAST_FETCH_VALUE}" selected="selected">{L_LAST_FETCH}</option>
			<option value="{L_WEEK_VALUE}">{L_WEEK}</option>
			<option value="{L_DAY_VALUE}">{L_DAY}</option>
			<option value="{L_12_HRS_VALUE}">{L_12_HRS}</option>
			<option value="{L_6_HRS_VALUE}">{L_6_HRS}</option>
			<option value="{L_3_HRS_VALUE}">{L_3_HRS}</option>
			<option value="{L_1_HRS_VALUE}">{L_1_HRS}</option>
			<option value="{L_30_MIN_VALUE}">{L_30_MIN}</option>
			<option value="{L_15_MIN_VALUE}">{L_15_MIN}</option>
		  </select></span>
		</td>
	  </tr>
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen"><label for="sort_by">{L_SORTBY}</label></span></td>
		<td class="row2" style="padding: 5px;" width="550px">
		  <span class="gen"><select name="sort_by" id="sort_by" onclick="switch_visible(this);">
			<option value="standard" selected="selected">{L_FORUMTOPIC}</option>
			<option value="standard_desc">{L_FORUMTOPIC_DESC}</option>
			<option value="postdate">{L_POSTDATE}</option>
			<option value="postdate_desc">{L_POSTDATE_DESC}</option>
		  </select></span>
		  <div id="count_limit_box" style="visibility:hidden; display:none">
		  	<p><span class="gen">{L_COUNT_LIMIT}</span></p>
			<input type="text" name="count_limit" id="count_limit" value="{MAX_SIZE}" class="post" onblur="check_word_size(this);" />
		  </div>
		</td>
	  </tr>
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen">{L_TOPICSONLY}</span></td>
		<td class="row2" style="padding: 5px;" width="550px">
		  <span class="gen"><input type="radio" name="topicsonly" id="topicsonly1" value="YES" onclick="switch_visible_new_topics(this);" /> <label for="topicsonly1">{L_YES}</label>
		  <input type="radio" name="topicsonly" id="topicsonly2" checked="checked" value="NO" onclick="switch_visible_new_topics(this);" /> <label for="topicsonly2">{L_NO}</label></span><br />
		  <div id="firstpostonly_box" style="visibility:hidden;display:none">
		  	<input type="checkbox" name="firstpostonly" id="firstpostonly" /> <label for="firstpostonly"><span class="gen">{L_FIRST_POST_ONLY}</span></label>
		  </div>
		</td>
	  </tr>
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen"><label for="max_word_size">{L_MAX_WORD_SIZE}</label></span></td>
		<td class="row2" style="padding: 5px;" width="550px">
			<input type="text" name="max_word_size" id="max_word_size" value="{MAX_SIZE}" class="post" onblur="check_word_size(this);" />
		</td>
	  </tr>
	  <!-- BEGIN switch_logged_in -->
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen">{L_REMOVE_YOUR_POSTS}</span></td>
		<td class="row2" style="padding: 5px;" width="550px">
		  <span class="gen"><input type="radio" name="remove_yours" id="remove_yours1" value="YES" /> <label for="remove_yours1">{L_YES}</label>
		  <input type="radio" name="remove_yours" id="remove_yours2" checked="checked" value="NO" /> <label for="remove_yours2">{L_NO}</label></span>
		</td>
	  </tr>
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen">{L_PRIVATE_MGS_IN_FEED}</span></td>
		<td class="row2" style="padding: 5px;" width="550px">
		  <span class="gen"><input type="radio" name="pms" id="pms1" value="YES" /> <label for="pms1">{L_YES}</label>
		  <input type="radio" name="pms" id="pms2" checked="checked" value="NO" /> <label for="pms2">{L_NO}</label></span>
		</td>
	  </tr>
	  <!-- END switch_logged_in -->
	  <!-- BEGIN switch_no_required_ip_authentication -->
	  <tr>
		<td class="row1" style="padding: 5px;"><span class="gen">{L_IP_AUTHENTICATION}</span></td>
		<td class="row2" style="padding: 5px;" width="550px">
		  <span class="gen"><input type="radio" name="ip_auth" id="ip_auth1" value="YES" /> <label for="ip_auth1">{L_YES}</label>
		  <input type="radio" name="ip_auth" id="ip_auth2" checked="checked" value="NO" /> <label for="ip_auth2">{L_NO}</label></span>
		</td>
	  </tr>
	  <!-- END switch_no_required_ip_authentication -->
	  <tr>
		<td valign="top" class="row1" style="padding: 5px;"><span class="gen">{L_FORUM_SELECTION}</span></td>
		<td class="row2" style="padding: 5px;" width="550px">
		  <input type="checkbox" name="all_forums" id="all_forums" checked="checked" onclick="unCheckSubscribedForums(this);" /> <label for="all_forums"><span class="gen">{L_ALL_SUBSCRIBED_FORUMS}</span></label><br />
		  <div id="dynamicforums">
			<!-- BEGIN forums -->
			<input type="checkbox" checked="checked" name="{forums.FORUM_NAME}" id="{forums.FORUM_NAME}" onclick="unCheckAllForums();" /> <label for="{forums.FORUM_NAME}"><span class="gen">{forums.FORUM_LABEL} {forums.FORUM_AUTH}</span></label><br />
			<!-- END forums -->
		  </div>
		</td>
	  </tr>
	  <tr>
		<td colspan="2" align="center" class="catBottom" height="28"><span class="gen"><button type="button" class="mainoption" onclick="createURL();">{L_SUBMIT}</button>&nbsp;<button type="reset" class="liteoption">{L_RESET}</button></span></td>
	  </tr>
	  <tr>
		<td colspan="2" class="row2" style="padding: 5px;"><span class="gen"><label for="url">{L_URL}</label></span></td>
	  </tr>
	  <tr>
		<td colspan="2" align="center" class="row1" style="padding: 5px;"><span class="gen"><input type="text" name="url" id="url" size="120" maxlength="3000" class="post" onfocus="this.select();" /></span></td>
	  </tr>
	</table>
	</form>
	<br /> 
    <div style="text-align:center" class="copyright">Powered by <a href="{SMARTFEED_PAGE_URL}" class="copyright">phpBB Smartfeed</a></div>	  