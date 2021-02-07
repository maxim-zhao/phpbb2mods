
<h1>{L_FAQ_TITLE}</h1>

<p>{L_FAQ_EXPLAIN}</p>

<form action="{S_FAQ_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_FAQ_SETTINGS}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_FAQ_NAME}</td>
	  <td class="row2"><input type="text" size="25" name="faqname" value="{FAQ_NAME}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FAQ_DESCRIPTION}</td>
	  <td class="row2"><textarea rows="5" cols="45" wrap="virtual" name="faqdesc" class="post">{DESCRIPTION}</textarea></td>
	</tr>
	<tr> 
	  <td class="row1">{L_CATEGORY}</td>
	  <td class="row2"><select name="c">{S_CAT_LIST}</select></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>
		
<br clear="all" />
