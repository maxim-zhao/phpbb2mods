
<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post">

{ERROR_BOX}
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="crumbs">
	<tr>
		<td align="left">
			<span class="gensmall"><a href="{U_INDEX}" class="nav">{L_INDEX}</a>{PLOCATION}</span>
		</td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="800px" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25" valign="middle" align="left"><b>{L_PROFILE}</b></th>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="thHead"><small class="nav"><a href="{S_PROFILE_LINK1}">{L_USER}</a>&nbsp;|&nbsp;{L_PROFILE}&nbsp;|&nbsp;<a href="{S_PROFILE_LINK3}">{L_FORUM}</a>&nbsp;|&nbsp;<a href="{S_PROFILE_LINK4}">{L_AVATAR}</a></small></span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ICQ_NUMBER}:</span></td>
	  <td class="row2"> 
		<input type="text" name="icq" class="post"style="width: 100px"  size="10" maxlength="15" value="{ICQ}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_AIM}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 150px"  name="aim" size="20" maxlength="255" value="{AIM}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 150px"  name="msn" size="20" maxlength="255" value="{MSN}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="website" size="25" maxlength="255" value="{WEBSITE}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_LOCATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="location" size="25" maxlength="100" value="{LOCATION}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="occupation" size="25" maxlength="100" value="{OCCUPATION}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="interests" size="35" maxlength="150" value="{INTERESTS}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2"> 
		<textarea name="signature"style="width: 300px"  rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_PROFILE_INFO_NOTICE}</span></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
	</tr>
</table>

</form>
