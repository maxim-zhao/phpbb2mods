
<h1>{L_SPECULATIVE}</h1>

<p>{L_EXCLUDE_DESC}</p>

<p>{L_RETURN}</p>

<br />

<form method="post" name="post" action="{S_EXCLUDE_ACTION}"><table width="80%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr> 
	  <th class="thHead" colspan="2">{L_ADD_IP}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_IP_OR_HOSTNAME}: <br /><span class="gensmall">{L_ADD_IP_EXPLAIN}</span></td>
	  <td class="row2"><input class="post" type="text" name="add_ip" size="35" /></td>
	</tr>
	<tr> 
	  <th class="thHead" colspan="2">{L_REMOVE_IP}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_IP_OR_HOSTNAME}: <br /><span class="gensmall">{L_REMOVE_IP_EXPLAIN}</span></td>
	  <td class="row2">{S_REMOVE_IPLIST_SELECT}</td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table></form>