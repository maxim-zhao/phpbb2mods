
{NAVIGATION_BOX}

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr>
	<th class="thHead">{L_FAQ_TITLE}</th>
</tr>
<tr>
	<td class="row1"><span class="gen">
		<!-- BEGIN faq_block -->
		<a href="#{faq_block.U_FAQ_ID}" class="gen"><b>{faq_block.BLOCK_TITLE}</b></a><br />
		<!-- BEGIN faq_row -->
		<a href="#{faq_block.faq_row.U_FAQ_ID}" class="postlink">{faq_block.faq_row.FAQ_QUESTION}</a><br />
		<!-- END faq_row -->
		<br />
		<!-- END faq_block -->
	</span></td>
</tr>
<tr>
	<td class="catBottom" height="28">&nbsp;</td>
</tr>
</table>

<!-- BEGIN faq_block -->
<a name="{faq_block.U_FAQ_ID}"></a><br clear="all" />
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr>
	<td class="catHead" height="28" align="center"><span class="cattitle">{faq_block.BLOCK_TITLE}</span></td>
</tr>
<!-- BEGIN faq_row -->  
<tr> 
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="left" valign="top"><span class="postbody">
		<a name="{faq_block.faq_row.U_FAQ_ID}"></a><b>{faq_block.faq_row.FAQ_QUESTION}</b><br />
		{faq_block.faq_row.FAQ_ANSWER}<br />
		<a class="postlink" href="#top">{L_BACK_TO_TOP}</a>
	</span></td>
</tr>
<tr>
	<td class="spaceRow" height="1"><img src="{I_SPACER}" alt="" width="1" height="1" /></td>
</tr>
<!-- END faq_row -->
</table>
<!-- END faq_block -->

<br clear="all" />