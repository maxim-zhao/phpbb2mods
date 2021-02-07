<!-- pop-up javascript taken from 
http://forums.htmlcenter.com/showthread.php?s=&threadid=1307
-->
<script type="text/javascript"> 
var newWindow = null; 

function closeWin()
{ 
	if (newWindow != null)
	{ 
		if(!newWindow.closed) newWindow.close(); 
	} 
} 

function popUpWin(url, type)
{ 
	closeWin(); 
	
	strWidth = screen.availWidth; 
	strHeight = screen.availHeight; 

	var tools=""; 
	tools = "resizable,toolbar=yes,location=yes,scrollbars=yes, menubar=yes,width="+strWidth+",height="+strHeight+",top=0,left=0"; 
	newWindow = window.open(url, 'newWin', tools); 
	newWindow.focus(); 
} 
</script> 

<table class="forumline" width="100%" cellspacing="3" cellpadding="1" border="0" align="center">
  <tr> 
	<th class="thHead" colspan="3" height="20">{L_VIEWING_BC}</th>
  </tr>
  <tr> 
	<td valign="middle" align="center">{AVATAR_IMG}</td>
	<td valign="middle" align="center" colspan="2"><span class="maintitle">{REAL_NAME}</span><br /><span class="gen"><b>{DESIGNATION}</b></span><br /><span class="gen">{COMPANY}</span></td>
  </tr>
  <tr> 
	<td valign="middle" height="20" align="center" width="150">&nbsp;</td>
	<td valign="middle" height="20"><span class="genmed"><b>{L_PROFILE}:</b></span></td>
	<td valign="middle" height="20" width="250"><span class="genmed">{PROFILE_IMG}</span></td>
  </tr>
   <tr> 
	<td valign="middle" height="20" align="center">&nbsp;</td>
	<td valign="middle" height="20"><span class="genmed"><b>{L_LOCATION}:</b></span></td>
	<td valign="middle" height="20" class="bc_dashed"><span class="genmed">{LOCATION}</span></td>
  </tr>
    <tr> 
	<td valign="middle" height="20" align="center">&nbsp;</td>
	<td valign="middle" height="20"><span class="genmed"><b>{L_BC_COUNTRY}:</b></span></td>
	<td valign="middle" height="20" class="bc_dashed"><span class="genmed">{COUNTRY}</span></td>
  </tr>
   <tr> 
	<td valign="middle" height="20" align="center">&nbsp;</td>
	<td valign="middle" height="20"><span class="genmed"><b>{L_OCCUPATION}:</b></span></td>
	<td valign="middle" height="20" class="bc_dashed"><span class="genmed">{OCCUPATION}</span></td>
  </tr>
   <tr> 
	<td valign="middle" height="20" align="center">&nbsp;</td>
	<td valign="middle" height="20"><span class="genmed"><b>{L_BC_COMPANY_ADDRESS}:</b></span></td>
	<td valign="middle" height="20" class="bc_dashed"><span class="genmed">{COMPANY_ADDRESS}</span></td>
  </tr>
    <tr> 
	<td valign="middle" align="center">&nbsp;</td>
	<td valign="middle">&nbsp;</td>
	<td valign="middle">&nbsp;</td>
  </tr>
    <tr> 
	<td valign="middle" align="center" colspan="3">{COMPANY_LOGO}</td>
  </tr>
    <tr> 
	<td valign="middle" align="center">&nbsp;</td>
	<td valign="middle">&nbsp;</td>
	<td valign="middle">&nbsp;</td>
  </tr>
  <tr> 
	<td valign="middle" height="20" align="center">&nbsp;</td>
	<td valign="middle" height="20"><span class="genmed"><b>{L_CONTACT}:</b></span></td>
	<td valign="middle" height="20"><span class="genmed">{EMAIL_IMG} {PM_IMG} {WWW_IMG} {MSN_IMG} {YIM_IMG} {AIM_IMG} {ICQ_IMG}</span></td>
  </tr>
  <tr>
	<td align="center" colspan="3"><br /><span class="genmed"><a href="javascript:window.close();" class="genmed">{L_CLOSE_WINDOW}</a></span></td>
  </tr>
</table>
