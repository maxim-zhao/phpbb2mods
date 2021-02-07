
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr>
	<td><span class="maintitle">
		<a href="{U_MOD_CP}" class="maintitle">{L_MOD_CP}</a>
	</span><span class="gensmall"><br />
		<br />
	</span></td>
</tr>
</table>

{NAVIGATION_BOX}

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th height="25" class="thHead">{L_IP_INFO}</th>
  </tr>
  <tr> 
	<td class="catSides" height="28"><span class="cattitle"><b>{L_THIS_POST_IP}</b></span></td>
  </tr>
  <tr> 
	<td class="row1"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td>&nbsp;<span class="gen">{IP} [ {POSTS} ]</span></td>
		  <td align="right"><span class="gen">[ <a href="{U_LOOKUP_IP}">{L_LOOKUP_IP}</a> 
			]&nbsp;</span></td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr> 
	<td class="catSides" height="28"><span class="cattitle"><b>{L_OTHER_USERS}</b></span></td>
  </tr>
  <!-- BEGIN userrow -->
  <tr> 
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td>&nbsp;<span class="gen"><a href="{userrow.U_PROFILE}">{userrow.USERNAME}</a> [ {userrow.POSTS} ]</span></td>
		  <td align="right"><a href="{userrow.U_SEARCHPOSTS}" title="{userrow.L_SEARCH_POSTS}"><img src="{SEARCH_IMG}" border="0" alt="{L_SEARCH}" /></a> 
			&nbsp;</td>
		</tr>
	  </table>
	</td>
  </tr>
  <!-- BEGINELSE userrow -->
  <tr>
	<td class="row1"><span class="gen">{L_NONE}</span></td>
  </tr>
  <!-- END userrow -->
  <!-- BEGIN iprow_title -->
  <tr> 
	<td class="catSides" height="28"><span class="cattitle"><b>{L_OTHER_IPS}</b></span></td>
  </tr>
  <!-- END iprow_title -->
  <!-- BEGIN iprow -->
  <tr> 
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td>&nbsp;<span class="gen">{iprow.IP} [ {iprow.POSTS} ]</span></td>
		  <td align="right"><span class="gen">[ <a href="{iprow.U_LOOKUP_IP}">{L_LOOKUP_IP}</a> ]&nbsp;</span></td>
		</tr>
	  </table></td>
  </tr>
  <!-- END iprow -->
  <tr> 
	<td class="catBottom" height="28"><span class="genmed">&nbsp;</span></td>
  </tr>
</table>

<br clear="all" />