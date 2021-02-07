<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center">
  <tr>
	<td valign="top" width="55%">
		<!-- BEGIN download_none -->
		<DIV alight="left" class="maintitle"><b>{download_none.NONE}</DIV><br />
		<!-- END download_none -->
		<!-- BEGIN download_cat -->
		<DIV alight="left" class="maintitle"><b>{download_cat.CATNAME}</DIV><br /><br />
		<!-- BEGIN sub -->
		<table width="100%" cellpadding="2" cellspacing="0" border="0" class="forumline">
		  <tr>
			<td class="catLeft" align="left" height="24"><span class="cattitle"><b>{download_cat.sub.TITLE}</b></span></td>
		  </tr>
		</table>			
		<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		  <tr>
			<th class="thTop" align="left" height="24" width="10%">{CAT_FLNAM}</th>
			<th class="thTop" align="left" height="24" width="70%">{CAT_FDESC}</th>
			<th class="thTop" align="center" height="24" width="10%">{CAT_FDATE}</th>
			<th class="thTop" align="center" height="24" width="5%">{CAT_DLCNT}</th>			
			<!-- BEGIN LOGGEDIN -->
			<th class="thTop" align="center" height="24" width="5%">{CAT_FCOMM}</th>
			<!-- END LOGGEDIN -->
		  </tr>
		  <!-- BEGIN DLs -->
		  <tr>
		    <td class="row1" align="left"><span class="gensmall"><a href="{download_cat.sub.DLs.LINK}" target=_blank class="gensmall" onclick="location.reload([true]);">{download_cat.sub.DLs.NAME}</a></span></td>
		    <td class="row1" align="left"><span class="gensmall">{download_cat.sub.DLs.DESC}</span></td>
		    <td class="row1" align="center"><span class="gensmall">{download_cat.sub.DLs.TIME}</span></td>
		    <td class="row1" align="center"><span class="gensmall">{download_cat.sub.DLs.DLCT}</span></td>
		    <!-- BEGIN LOGGEDIN -->
			<td class="row1" align="center"><span class="gensmall"><a href="{download_cat.sub.U_VIEW_COMMENTS}" target=_blank class="gensmall">{CAT_FCADD}</a></span></td>
			<!-- END LOGGEDIN -->
		  </tr>
		  <!-- END DLs -->
		</table>

		<br />
		<!-- END sub -->
		<br />
		<!-- END download_cat -->
	</td>
  </tr>
</table>

<br />