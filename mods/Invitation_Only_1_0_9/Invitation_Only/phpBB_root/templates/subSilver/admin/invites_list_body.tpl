<h1>{L_INVITES_TITLE}</h1>

<p>{L_INVITES_TEXT}</p>
 <form method="post" action="{S_FILTER_ACTION}">    
                     <p> {L_SHOW}:
                    <select name="filter">
                        <option value="all" class="genmed"  >{L_ALL}</option>
                        <option value="active" class="genmed" {ACTIVE_SELECTED} >{L_ACTIVE}</option>
                        <option value="inactive" class="genmed" {INACTIVE_SELECTED} >{L_INACTIVE}</option>
                    </select>
                    <input type="submit"  class="liteoption" name="" value="{L_FILTER}" /> 
                </span></form> 
<form method="post" action="{S_INVITE_ACTION}"><table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_INVITES_ID}</th>
                <th class="thTop">{L_INVITES_CODE}</th>
		<th class="thTop">{L_INVITES_DESCRIPTION}</th>	
                <th class="thTop">{L_USES_LEFT}</th>	 
                <th class="thTop">{L_USERS_USED}</th>
                <th class="thTop">{L_INVITE_GROUP}</th>
		<th class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN invites -->
	<tr>
		<td class="{invites.ROW_CLASS}" align="center">{invites.INVITE}</td>
                <td class="{invites.ROW_CLASS}" align="center">{invites.CODE}</td>
		<td class="{invites.ROW_CLASS}" align="center">{invites.DESCRIPTION}</td>	
                <td class="{invites.ROW_CLASS}" align="center">{invites.USES}</td>	
                <td class="{invites.ROW_CLASS}" align="center">{invites.USERS}</td>	
                <td class="{invites.ROW_CLASS}" align="center">{invites.GROUP}</td>	                
		<td class="{invites.ROW_CLASS}" align="center">
                    <a href="{invites.U_INVITE_DELETE}">{L_DELETE}</a> <br />
                    <a href="{invites.U_INVITE_EDIT}">{L_EDIT}</a> 
                </td>
	</tr>
	<!-- END invites -->			
	<tr>
		<td class="catBottom" align="center" colspan="7"><input type="submit" class="mainoption" name="add" value="{L_ADD_INVITTATION}" /></td>
	</tr>
</table></form>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE}</span></td>
               
		<td align="right" valign="middle"><span class="nav">{PAGES}</span></td>
	</tr>
</table>