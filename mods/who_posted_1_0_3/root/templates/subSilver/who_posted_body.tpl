
<table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td><table width="100%" class="forumline" cellpadding="4" cellspacing="1" border="0">
			<tr> 
				<th class="thHead" height="25">{L_WHO_POSTED_TITLE}</th>
			</tr>
			<tr>
				<td class="row3">
					<span class="gensmall">{L_WHO_POSTED_EXP}</span>
				</td>
			</tr>
			<tr>
				<td valign="top" class="row1">
					<table width="100%" class="forumline" cellpadding="4" cellspacing="1" border="0" style="margin: 5px;">
						<tr>
							<th class="tHleft" align="left">{L_USERNAME}</th>
							<th class="tHright" width="10">{L_POSTS}</th>
						</tr>
						<!-- BEGIN who_posted_row -->
						<tr>
							<td class="{who_posted_row.CLASS}"><span class="genmed">{who_posted_row.USERNAME}</span></td>
							<td class="{who_posted_row.CLASS}" align="left" valign="middle"><span class="genmed">{who_posted_row.POSTS}</span></td>
						</tr>
						<!-- END who_posted_row -->
					</table>
					<div style="text-align: center;">
						<span class="genmed"><a href="#" onclick="opener.location=('{U_CLOSE}'); self.close();"><b>{L_CLOSE}</b></a></span>
					</div>
				</td>
			</tr>
		</table></td>
	</tr>
</table>

<div style="text-align: center;">
	<span class="copyright"><a href="http://phpbbmodders.net/goto/who_posted" class="copyright">Who Posted?</a> &copy; 2006 eviL&lt;3</span>
</div>
