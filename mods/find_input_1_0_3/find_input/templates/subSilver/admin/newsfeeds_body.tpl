<!-- FIND - Forum Inserted News Delivery - Input - Version 1.0.0 -->
<script language="Javascript" type="text/javascript"> 
<!-- 
function setCheckboxes(theForm, elementName, isChecked)
{
    var chkboxes = document.forms[theForm].elements[elementName];
    var count = chkboxes.length;

    if (count) 
	{
        for (var i = 0; i < count; i++) 
		{
            chkboxes[i].checked = isChecked;
    	}
    } 
	else 
	{
    	chkboxes.checked = isChecked;
    } 

    return true;
} 
//--> 
</script> 

<h1>{L_FIND_EXPLAIN} - {L_NEWSFEEDS_TITLE}</h1>

<p>{L_NEWSFEEDS_EXPLAIN}</p>

<form name="newsfeeds_form" id="newsfeeds_form" method="post" action="{S_FORM_ACTION}">
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_ADD_EDIT_NEWSFEED}</th>
	</tr>
	<tr>
        <td class="row1"><span class="gen">{L_FORUM_NAME}: </span><br/><span class="gensmall">{L_NEWS_FORUMS_EXPLAIN}</span></td>
        <td class="row1" nowrap>{S_FORUM_SELECT}</td>
    </tr>
    <tr>
		<td class="row1"><span class="gen">{L_NEWSFEED_NAME}: </span><br/><span class="gensmall">{L_NEWSFEED_NAME_EXPLAIN}</span></td>
        <td class="row1" nowrap><input type="Text" name="NEWSFEED_NAME" value="{EDIT_NEWSFEED_NAME}" size="60" /></td>
    </tr>
    <tr>
		<td class="row1"><span class="gen">{L_NEWSFEED_URL}: </span><br/><span class="gensmall">{L_NEWSFEED_URL_EXPLAIN}</span></td>
        <td class="row1" nowrap><input type="Text" name="NEWSFEED_URL" value="{EDIT_NEWSFEED_URL}" size="60" /></td>
	</tr>
    <tr>
		<td class="row1"><span class="gen">{L_NEWS_LIMIT}: </span><br/><span class="gensmall">{L_NEWS_LIMIT_EXPLAIN}</span></td>
		<td class="row1" nowrap><input type="Text" name="NEWSFEED_LIMIT" value="{EDIT_NEWS_LIMIT}" size="10" /></td>
    </tr>
    <tr>
		<td class="row1"><span class="gen">{L_NEWS_USER}: </span><br/><span class="gensmall">{L_NEWS_USERNAME_EXPLAIN}</span></td>
		<td class="row1" nowrap><input type="Text" name="NEWSFEED_USERNAME" value="{EDIT_NEWS_USER}" size="30" /></td>
    </tr>
    <tr>
		<td class="row1"><span class="gen">{L_NEWS_INC_CHANNEL}: </span><br/><span class="gensmall">{L_NEWS_INC_CHANNEL_EXPLAIN}</span></td>
		<td class="row1" nowrap><input type="checkbox" name="NEWSFEED_INC_CHANNEL" value="1" {EDIT_NEWS_INCLUDE_CHANNEL} /></td>
    </tr>
    <tr>
		<td class="row1"><span class="gen">{L_NEWS_INC_IMAGE}: </span><br/><span class="gensmall">{L_NEWS_INC_IMAGE_EXPLAIN}</span></td>
		<td class="row1" nowrap><input type="checkbox" name="NEWSFEED_INC_IMAGE" value="1" {EDIT_NEWS_INCLUDE_IMAGE} /></td>
    </tr>
	<tr>
		<td class="row2" align="center" colspan="2">
            <input type="hidden" name="save_feed_id" value="{EDIT_NEWSFEED_ID}" />
            <input type="submit" name="{S_ADD_EDIT_NEWSFEED}" value="{L_ADD_EDIT_NEWSFEED}" class="mainoption" />&nbsp;
        </td>
	</tr>
</table>
<br/>
<br/>
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr><th class="thHead" align="center" colspan="8">{L_NEWSFEEDS_TITLE}</th></tr>
	<tr>
		<td class="cat" align="center">{L_FORUM_NAME}</td>
		<td class="cat" align="center">{L_NEWSFEED_NAME}</td>
		<td class="cat" align="center">{L_NEWS_LIMIT}</td>
		<td class="cat" align="center">{L_NEWS_USER}</td>
		<td class="cat" align="center">{L_NEWS_INC_CHANNEL}</td>
		<td class="cat" align="center">{L_NEWS_INC_IMAGE}</td>
		<td class="cat" align="center" colspan="2"></td>
	</tr>
    <!-- BEGIN cat_row -->
	<tr><td class="cat" colspan="8"><span class="cattitle">{cat_row.CAT_TITLE}</span></td></tr>
    	<!-- BEGIN newsfeed_row -->
    	<tr>
    		<td class="row1" align="left"><span class="genmed">{cat_row.newsfeed_row.S_FORUM_NAME}</span></td>
    		<td class="row2" align="left"><span class="genmed">{cat_row.newsfeed_row.S_NEWSFEED_URL}</span></td>
    		<td class="row2" align="center"><span class="genmed">{cat_row.newsfeed_row.S_NEWSFEED_LIMIT}</span></td>
    		<td class="row2" align="center"><span class="genmed"><a href="{cat_row.newsfeed_row.U_NEWS_USER}" class="genmed">{cat_row.newsfeed_row.S_NEWSFEED_USERNAME}</a></span></td>
    		<td class="row1" align="center" nowrap><span class="genmed">{cat_row.newsfeed_row.S_NEWSFEED_INC_CHANNEL}</span></td>
    		<td class="row1" align="center" nowrap><span class="genmed">{cat_row.newsfeed_row.S_NEWSFEED_INC_IMAGE}</span></td>
    		<td class="row1" align="center" nowrap>
                <input type="checkbox" name="feed_id_list[]" value="{cat_row.newsfeed_row.NEWSFEED_ID}" />
            </td>
    		<td class="row1" align="center" nowrap>
                <a href="{cat_row.newsfeed_row.U_EDITFEED}" class="gensmall">{L_EDIT_NEWSFEED}</a>
            </td>
    	</tr>
    	<!-- END newsfeed_row -->
	<tr>
		<td colspan="8" height="1" class="spaceRow"><img src="../templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
    <!-- END cat_row -->
    <tr><td class="row2" align="right" colspan="8" width="100%">
            <input type="submit" name="delete_newsfeed" class="liteoption" value="{L_DELETE}" />&nbsp;&nbsp;
            <input type="submit" name="execute_newsfeed" class="liteoption" value="{L_GET_NEWS_NOW}" />&nbsp;&nbsp;
        </td>
    </tr>
</table>
<div align="right">
    <a href="#" onclick="setCheckboxes('newsfeeds_form', 'feed_id_list[]', true); return false;" class="gensmall">{L_CHECK_ALL}</a>&nbsp;/&nbsp;
	<a href="#" onclick="setCheckboxes('newsfeeds_form', 'feed_id_list[]', false); return false;" class="gensmall">{L_UNCHECK_ALL}</a>
</div>
</form>
<br/>
<br/>
