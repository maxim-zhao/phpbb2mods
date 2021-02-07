<h1>{L_INVITED_TITLE}</h1>

<p>{L_INVITED_TEXT}</p>                     
         
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_USERNAME}</th>
                <th class="thTop">{L_REGDATE}</th>
		<th class="thTop">{L_INVITER}</th>	
                <th class="thTop">{L_INVITE}</th>                 	
		<th class="thCornerR">{L_GROUP}</th>
	</tr>
	<!-- BEGIN invited -->
	<tr>
		<td class="{invited.ROW_CLASS}" align="center">
		    <a href="{invited.USERLINK}">{invited.INVITED_NAME}</a>
		</td>
                <td class="{invited.ROW_CLASS}" align="center">{invited.INVITED_REGDATE}</td>
		<td class="{invited.ROW_CLASS}" align="center">
		     {invited.INVITER_LINK} 
		</td>
		<td class="{invited.ROW_CLASS}" align="center">
		    {invited.USED_INVITE_LINK} 
		</td>
		<td class="{invited.ROW_CLASS}" align="center">
		    {invited.JOINED_GROUP_LINK} 
		</td>	
		 
	</tr>
	<!-- END invited -->			
	 
</table> 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE}</span></td>
               
		<td align="right" valign="middle"><span class="nav">{PAGES}</span></td>
	</tr>
</table>