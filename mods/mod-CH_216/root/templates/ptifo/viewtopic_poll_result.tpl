<br class="nav" /><table cellpadding="3" cellspacing="1" border="0" width="100%" class="forumline">
<tr>
	<th class="thHead">{POLL}</th>
</tr>
<tr>
	<td class="row1" align="center"><br /><span class="gen"><b>{POLL_QUESTION}</b></span><br /><br />
		<table cellspacing="0" cellpadding="2" border="0">
		<!-- BEGIN poll_option -->
		<tr>
			<td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
			<td><table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td><img src="{poll_option.POLL_OPTION_IMG_LEFT}" width="4" alt="" height="12" /></td>
					<td><img src="{poll_option.POLL_OPTION_IMG}" width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="12" alt="{poll_option.POLL_OPTION_PERCENT}" /></td>
					<td><img src="{poll_option.POLL_OPTION_IMG_RIGHT}" width="4" alt="" height="12" /></td>
				</tr>
			</table></td>
			<td align="center"><b><span class="gen">&nbsp;{poll_option.POLL_OPTION_PERCENT}&nbsp;</span></b></td>
			<td align="center"><span class="gen">[ {poll_option.POLL_OPTION_RESULT} ]</span></td>
		</tr>
		<!-- END poll_option -->
		</table><br /><span class="gen"><b>{L_TOTAL_VOTES} : {TOTAL_VOTES}</b></span><br /><br />
	</td>
</tr>
<tr>
	<td class="catBottom">&nbsp;</td>
</tr>
</table><br class="nav" />