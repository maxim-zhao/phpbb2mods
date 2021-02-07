
<h1>{L_FAQ_TITLE}</h1>
<form method="post" action="{S_FAQ_ACTION}">
<p>{L_FAQ_EXPLAIN}</p>
<p>
{L_LANGUAGE}<select name="l">{S_LANG_LIST}</select>
{L_SORT}<select name="type">{S_TYPE_LIST}</select><input type="submit" name="lang" class="liteoption" value="Select" />
{S_HIDDEN_FIELDS}</p>
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="7">{L_FAQ_TITLE}</th>
	</tr>
	<!-- BEGIN catrow -->
	<tr>
		<td class="catLeft" colspan="3"><span class="cattitle"><b><a href="{catrow.U_VIEWCAT}">{catrow.CAT_DESC}</a></b></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen"><a href="{catrow.U_CAT_EDIT}">{L_EDIT}</a></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen"><a href="{catrow.U_CAT_DELETE}">{L_DELETE}</a></span></td>
	</tr>
	<!-- BEGIN faqrow -->
	<tr> 
		<td class="row2"><span class="gen"><a href="{catrow.faqrow.U_VIEWFAQ}">{catrow.faqrow.FAQ_NAME}</a></span><br /><span class="gensmall">{catrow.faqrow.FAQ_DESC}</span></td>
		<td class="row1" align="center" valign="middle"><span class="gen">{catrow.faqrow.NUM_TOPICS}</span></td>
		<td class="row2" align="center" valign="middle"><span class="gen">{catrow.faqrow.NUM_POSTS}</span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{catrow.faqrow.U_FAQ_EDIT}">{L_EDIT}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{catrow.faqrow.U_FAQ_DELETE}">{L_DELETE}</a></span></td>
	</tr>
	<!-- END faqrow -->
	<tr>
		<td colspan="7" class="row2"><input class="post" type="text" name="{catrow.S_ADD_FAQ_NAME}" /> <input type="submit" class="liteoption"  name="{catrow.S_ADD_FAQ_SUBMIT}" value="{L_CREATE_FAQ}" /></td>
	</tr>
	<tr>
		<td colspan="7" height="1" class="spaceRow"><img src="{SPACER}" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END catrow -->
	<tr>
		<td colspan="7" class="catBottom"><input class="post" type="text" name="categoryname" /> <input type="submit" class="liteoption"  name="addcategory" value="{L_CREATE_CATEGORY}" /></td>
	</tr>
</table>
</form>
