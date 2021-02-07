
<h1>{L_INVITE_CONFIG_TITLE}</h1>

<p>{L_INVITE_CONFIG_EXPLAIN}</p>
<form method="post" action="{S_CONFIG_ACTION}">
<table width="80%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	
	<tr>
		<th class="thHead" colspan="2">{L_INVITE_CONFIG}</th>
	</tr>
	
	<tr>
		 <td class="row1">{L_INVITATION_SETTING}<br /><span class="gensmall">{L_INVITATION_SETTING_EXPLAIN}</span></td>
		 <td class="row2"><input type="radio" name="set_mode" value="0" {INVITES_DISABLED} /> {L_DISABLED}&nbsp;&nbsp;<input type="radio" name="set_mode" value="1" {INVITES_OPTIONAL} /> {L_OPTIONAL}<input type="radio" name="set_mode" value="2" {INVITATION_ONLY} /> {L_INVITATION_ONLY}&nbsp;&nbsp;</td>
	</tr>
	<tr>
		 <td class="row1">{L_INVITATION_U2U_SETTING}<br /><span class="gensmall">{L_INVITATION_U2U_SETTING_EXPLAIN}</span></td>
		 <td class="row2"><input type="radio" name="set_u2u" value="0" {U2U_NO} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="set_u2u" value="1" {U2U_HIDE} /> {L_U2U_HIDE}&nbsp;&nbsp;<input type="radio" name="set_u2u" value="2" {U2U_YES} /> {L_YES}</td>
	</tr> 
	 <tr>
		<td class="row1">{L_INVITATION_ACCEPT_PM}<br /><span class="gensmall">{L_INVITATION_ACCEPT_PM_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="set_accept_pm" value="0" {REG_PM_DISABLED} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="set_accept_pm" value="1" {REG_PM_ENABLED} /> {L_YES}</td>
	</tr> 
	<tr>
		 <td class="row1">{L_INVITATION_CONFIRM_PM}<br /><span class="gensmall">{L_INVITATION_CONFIRM_PM_EXPLAIN}</span></td>
		 <td class="row2"><input type="radio" name="set_confirm_pm" value="0" {CONFIRM_PM_DISABLED} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="set_confirm_pm" value="1" {CONFIRM_PM_ENABLED} /> {L_YES}&nbsp;&nbsp;</td>
	</tr>
	<tr>
		 <td class="row1">{L_INVITATION_CONFIRM_MAIL}<br /><span class="gensmall">{L_INVITATION_CONFIRM_MAIL_EXPLAIN}</span></td>
		 <td class="row2"><input type="radio" name="set_confirm_mail" value="0" {CONFIRM_MAIL_DISABLED} /> {L_NO}&nbsp;&nbsp;<input type="radio" name="set_confirm_mail" value="1" {CONFIRM_MAIL_ENABLED} /> {L_YES}</td>
	</tr> 
	 <tr>
		 <td class="row1">{L_ADDITIONAL_RULES}<br /><span class="gensmall">{L_ADDITIONAL_RULES_EXPLAIN}</span></td>
		 <td class="row2"><textarea name="rules" rows="5" cols="35" maxlength="250" wrap="virtual" style="width:450px" tabindex="5" class="post" >{RULES}</textarea></td>
		</tr> 
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="hidden" name="mode" value="config"> <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		</td>
	</tr>	
</table>
</form>
<h1>{L_GIVE_INVITES_TITLE}</h1>

 

<p>{L_GIVE_INVITES_EXPLAIN}</p>
<form method="post" action="{S_GIVE_INVITES_ACTION}">
<table width="60%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr><th class="thHead" colspan="2">{L_GIVE_ALL}</th></tr>
	<tr><td class="row1" colspan="2">{L_GIVE_ALL_EXPLAIN}</td></tr> 
		   			 
	<tr>
	    <td class="row1" align="center">
		{L_MODE}:
	    </td> 
	    <td class="row2">
		<input type="radio" name="action" value="add" checked="checked" /> {L_ADD}&nbsp;&nbsp;<input type="radio" name="action" value="set"   /> {L_SET}
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="center">
		{L_AMOUNT}:
	    </td> 
	    <td class="row2">
		<input type="text" class="post" name="amount" size="4" />	     
		<input type="hidden" name="mode" value="all_users"/>
	    </td>
	</tr>
	<tr>
	    <td class="catBottom" colspan="2" align="center"> 
		 <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
	    </td>
	  
	</tr>
		    
		 
	 
</table>
</form>
<form method="post" action="{S_GIVE_INVITES_ACTION}">
<table width="60%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr><th class="thHead" colspan="2">{L_GIVE_ALL_GROUPS}</th></tr>
	<tr><td class="row1" colspan="2">{L_GIVE_ALL_GROUPS_EXPLAIN}</td></tr>  
		   			 
	<tr>
	    <td class="row1" align="center">
		{L_MODE}:
	    </td> 
	    <td class="row2">
		<input type="radio" name="action" value="add" checked="checked" /> {L_ADD}&nbsp;&nbsp;<input type="radio" name="action" value="set"   /> {L_SET}
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="center">
		{L_AMOUNT}:
	    </td> 
	    <td class="row2">
		<input type="text" class="post" name="amount" size="4" />	     
		<input type="hidden" name="mode" value="all_groups"/>
	    </td>
	</tr>
	<tr>
	    <td class="catBottom" colspan="2" align="center"> 
		 <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
	    </td>
	  
	</tr>
		    
		 
	 
</table>
</form>

 
<form method="post" action="{S_GIVE_INVITES_ACTION}">
<table width="60%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr><th class="thHead" colspan="2">{L_GIVE_GROUPMEMBERS}</th></tr>
	<tr><td class="row1" colspan="2">{L_GIVE_GROUPMEMBERS_EXPLAIN}</td></tr>   
		   			 
	<tr>
	    <td class="row1" align="center">
		{L_MODE}:
	    </td> 
	    <td class="row2">
		<input type="radio" name="action" value="add" checked="checked" /> {L_ADD}&nbsp;&nbsp;<input type="radio" name="action" value="set"   /> {L_SET}
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="center">
		{L_AMOUNT}:
	    </td> 
	    <td class="row2">
		<input type="text" class="post" name="amount" size="4" />		 
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="center">
		{L_SELECT_GROUP}:
	    </td> 
	    <td class="row2">
		{S_GROUP_BOX}	     
		<input type="hidden" name="mode" value="group_members"/>
	    </td>
	</tr>
	<tr>
	    <td class="catBottom" colspan="2" align="center"> 
		 <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
	    </td>
	  
	</tr>
		    
		 
	 
</table>
</form>

 
<form method="post" action="{S_GIVE_INVITES_ACTION}">
<table width="60%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr><th class="thHead" colspan="2">{L_GIVE_INVITES_RANK}</th></tr>
	<tr><td class="row1" colspan="2">{L_GIVE_RANK_EXPLAIN}</td></tr>  
		   			 
	<tr>
	    <td class="row1" align="center">
		{L_MODE}:
	    </td> 
	    <td class="row2">
		<input type="radio" name="action" value="add" checked="checked" /> {L_ADD}&nbsp;&nbsp;<input type="radio" name="action" value="set"   /> {L_SET}
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="center">
		{L_AMOUNT}:
	    </td> 
	    <td class="row2">
		<input type="text" class="post" name="amount" size="4" />	     
		<input type="hidden" name="mode" value="give_rank"/>
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="center">
		{L_RANK}:
	    </td> 
	    <td class="row2">
		{S_RANK_BOX}	     
		 
	    </td>
	</tr>
	<tr>
	    <td class="catBottom" colspan="2" align="center"> 
		 <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
	    </td>
	  
	</tr>
		    
		 
	 
</table>
</form>



<form method="post" action="{S_GIVE_INVITES_ACTION}">
<table width="60%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr><th class="thHead" colspan="2">{L_GIVE_TIME}</th></tr>
	<tr><td class="row1" colspan="2">{L_GIVE_TIME_EXPLAIN}</td></tr>  
		   			 
	<tr>
	    <td class="row1" align="left">
		{L_MODE}:
	    </td> 
	    <td class="row2">
		<input type="radio" name="action" value="add" checked="checked" /> {L_ADD}&nbsp;&nbsp;<input type="radio" name="action" value="set"   /> {L_SET}
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="left" >
		{L_AMOUNT}:
	    </td> 
	    <td class="row2">
		<input type="text" class="post" name="amount" size="4" />	     
		<input type="hidden" name="mode" value="joined_between"/>
	    </td>
	</tr>
	<tr>
	    <td class="row1" align="left" >
		{L_SHORTER_THAN_DAYS}:
	    </td> 
	    <td class="row2">
		<input type="text" class="post" name="who" size="4" />	     
		 
	    </td>
	</tr>
	<tr>
	    <td class="row1"   align="left">
		{L_LONGER_THAN_DAYS}:
	    </td> 
	    <td class="row2">
		<input type="text" class="post"  name="who1" size="4" />	     
		 
	    </td>
	</tr>
	<tr>
	    <td class="catBottom" colspan="2" align="center"> 
		 <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
	    </td>
	  
	</tr>
		    
		 
	 
</table>
</form>