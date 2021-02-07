
<h1>{L_CSPAM_TITLE}</h1>

<p>{L_CSPAM_DESC}</p>

<form method="post" name="post" action="{S_CSPAM_ACTION}"><table width="80%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr> 
	  <th class="thHead" colspan="2">{L_CSPAM_MANAGE}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_CSPAM_GENERAL}: <br /><span class="gensmall">{L_CSPAM_GENERAL_DESC}</span></td>
	  <td class="row2"><input type="radio" name="cspam_general" value="0" {CSPAM_ALL} />{L_CSPAM_ALL}&nbsp; &nbsp;<input type="radio" name="cspam_general" value="1" {CSPAM_NONE} />{L_CSPAM_NONE}</td>
	</tr>
	<tr> 
	  <td class="row1">{L_CSPAM_EXCEPT}: <br /><span class="gensmall">{L_CSPAM_EXCEPT_DESC}</span></td>
	  <td class="row2">{S_CSPAM_EXPECT_SELECT}</td>
	</tr>
	<tr> 
	  <td class="row1">{L_CSPAM_ADD}: <br /><span class="gensmall">{L_CSPAM_ADD_DESC}</span></td>
	  <td class="row2"><input class="post" type="text" name="cspam_except" size="35" /></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table></form>
