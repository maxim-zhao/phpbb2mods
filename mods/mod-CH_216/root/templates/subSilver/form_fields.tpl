<!-- BEGIN field -->

<!-- BEGIN row -->
<tr>
<!-- END row -->
<!-- BEGIN legend --><td class="row1"><span class="gen">
		<!-- BEGIN bold --><b><!-- END bold -->{field.legend.LEGEND}<!-- BEGIN bold --></b><!-- END bold -->
	</span><!-- BEGIN explain --><span class="gensmall"><br />{field.legend.EXPLAIN}<br />
	</span><!-- END explain -->
</td>
<td class="row2"><!-- END legend -->
<!-- BEGIN over --><td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"<!-- BEGIN center --> align="center"<!-- END center --><!-- BEGIN colspan --> colspan="2"<!-- END colspan -->><!-- END over -->

<!-- BEGIN title --><th class="thHead" align="center" colspan="2">{field.title.LEGEND}</th><!-- END title -->
<!-- BEGIN sub_title --><td class="catSides" align="center" colspan="2"><span class="cattitle">{field.sub_title.LEGEND}</span></td><!-- END sub_title -->
<!-- BEGIN comment --><td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"<!-- BEGIN center --> align="center"<!-- END center --> colspan="2"><span class="gensmall"{field.comment.SPAN_HTML}>{field.comment.LEGEND}</span></td><!-- END comment -->

<!-- BEGIN hidden --><input type="hidden" name="{field.hidden.NAME}" value="{field.hidden.VALUE}" /><!-- END hidden -->

<!-- BEGIN data -->

<!-- BEGIN linefeed --><br class="gen" /><!-- END linefeed -->
<!-- BEGIN include -->{field.data.include.TPL}<!-- END include -->

<!-- BEGIN varchar_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<!-- BEGIN link --><a href="{field.data.U_LINK}" class="gen" title="{field.data.TITLE}" {field.data.HTML}><!-- END link -->{field.data.VALUE}<!-- BEGIN link --></a><!-- END link -->&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END varchar_output -->
<!-- BEGIN varchar_input --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<input type="text" size="{field.data.LENGTH}" name="{field.data.NAME}" value="{field.data.VALUE}" class="post" {field.data.HTML} />&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END varchar_input -->

<!-- BEGIN password_input --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<input type="password" size="{field.data.LENGTH}" name="{field.data.NAME}" value="{field.data.VALUE}" class="post" {field.data.HTML} />&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END password_input -->
<!-- BEGIN password_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;***{field.data.POST_VALUE}
&nbsp;</span><!-- END password_output -->

<!-- BEGIN file_input --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="{field.data.MAX_FILE_SIZE}" /><input type="file" size="{field.data.LENGTH}" name="{field.data.NAME}" value="{field.data.VALUE}" class="post" {field.data.HTML} />&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END file_input -->

<!-- BEGIN varchar_comment_output --><span class="gensmall"{field.data.SPAN_HTML}>&nbsp;<b>{field.data.LEGEND}:</b>&nbsp;{field.data.VALUE}&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END varchar_comment_output -->

<!-- BEGIN mini_comment_output --><span class="gensmall"{field.data.SPAN_HTML}>&nbsp;{field.data.VALUE}
&nbsp;</span><!-- END mini_comment_output -->

<!-- BEGIN mini_link_output --><span class="gensmall"{field.data.SPAN_HTML}>&nbsp;<a href="{field.data.VALUE}" class="gensmall" {field.data.HTML}>{field.data.LEGEND}</a>{field.data.POST_VALUE}
&nbsp;</span><!-- END mini_link_output -->

<!-- BEGIN int_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;{field.data.VALUE}&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END int_output -->
<!-- BEGIN int_input --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<input type="text" size="5" name="{field.data.NAME}" value="{field.data.VALUE}" class="post" />&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END int_input -->

<!-- BEGIN text_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;{field.data.VALUE}
&nbsp;</span><!-- END text_output -->
<!-- BEGIN text_input --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<textarea rows="5" cols="60" name="{field.data.NAME}" class="post">{field.data.VALUE}</textarea>
&nbsp;</span><!-- END text_input -->

<!-- BEGIN image_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<!-- BEGIN link --><a href="{field.data.U_LINK}" class="gen" {field.data.HTML}><!-- END link --><!-- BEGIN image --><img name="{field.data.NAME}" src="{field.data.IMAGE}" align="top" border="0" alt="{field.data.LEGEND}" title="{field.data.TITLE}" /><!-- END image --><!-- BEGIN link --></a><!-- END link -->{field.data.POST_VALUE}
&nbsp;</span><!-- END image_output -->

<!-- BEGIN button_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<img src="{field.data.IMAGE}" name="{field.data.NAME}" align="top" border="0" alt="{field.data.LEGEND}" title="{field.data.TITLE}" {field.data.HTML} />{field.data.POST_VALUE}
&nbsp;</span><!-- END button_output -->
<!-- BEGIN button_input --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<input type="image" src="{field.data.IMAGE}" align="top" alt="{field.data.LEGEND}" title="{field.data.TITLE}" name="{field.data.NAME}" {field.data.HTML} />&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END button_input -->

<!-- BEGIN list_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;{field.data.VALUE}&nbsp;{field.data.POST_VALUE}
&nbsp;</span><!-- END list_output -->
<!-- BEGIN list_input --><span class="gen"{field.data.SPAN_HTML}>&nbsp;<select name="{field.data.NAME}" {field.data.HTML}>{field.data.VALUE}</select>{field.data.POST_VALUE}
&nbsp;</span><!-- END list_input -->

<!-- BEGIN radio_list_output --><span class="gen"{field.data.SPAN_HTML}>&nbsp;{field.data.VALUE}
&nbsp;</span><!-- END radio_list_output -->
<!-- BEGIN radio_list_input --><span class="gen"{field.data.SPAN_HTML}><!-- BEGIN option -->&nbsp;<input type="radio" name="{field.data.NAME}" value="{field.data.radio_list_input.option.VALUE}"{field.data.radio_list_input.option.SELECTED} />{field.data.radio_list_input.option.DESC}&nbsp;<!-- BEGIN linefeed --><br /><!-- END linefeed --><!-- END option -->
</span><!-- END radio_list_input -->

<!-- BEGIN checkbox_list_output --><span class="gen"{field.data.SPAN_HTML}><!-- BEGIN option -->&nbsp;{field.data.checkbox_list_input.option.DESC}&nbsp;<!-- BEGIN linefeed --><br /><!-- END linefeed --><!-- END option -->
</span><!-- END checkbox_list_output -->
<!-- BEGIN checkbox_list_input --><span class="gen"{field.data.SPAN_HTML}><input type="hidden" name="{field.data.NAME}_dsp" value="1" /><!-- BEGIN option -->&nbsp;<input type="checkbox" name="{field.data.NAME}[]" value="{field.data.checkbox_list_input.option.VALUE}"{field.data.checkbox_list_input.option.SELECTED} />{field.data.checkbox_list_input.option.DESC}&nbsp;<!-- BEGIN linefeed --><br /><!-- END linefeed --><!-- END option -->
</span><!-- END checkbox_list_input -->

<!-- BEGIN radio_list_comment_output --><span class="gensmall"{field.data.SPAN_HTML}>&nbsp;<b>{field.data.LEGEND}:</b>&nbsp;{field.data.VALUE}
&nbsp;</span><!-- END radio_list_comment_output -->
<!-- BEGIN radio_list_comment_input --><span class="gensmall"{field.data.SPAN_HTML}>&nbsp;<b>{field.data.LEGEND}:</b><!-- BEGIN option -->&nbsp;<input type="radio" name="{field.data.NAME}" value="{field.data.radio_list_comment_input.option.VALUE}"{field.data.radio_list_comment_input.option.SELECTED} />{field.data.radio_list_comment_input.option.DESC}&nbsp;<!-- BEGIN linefeed --><br /><!-- END linefeed --><!-- END option -->
</span><!-- END radio_list_comment_input -->

<!-- BEGIN messenger_status_output --><table cellpadding="0" cellspacing="0" border="0" width="64"><tr><td height="18" valign="top" nowrap="nowrap"><div style="position: relative"><div style="position:absolute"><a href="{field.data.U_LINK}" {field.data.HTML}><img src="{field.data.IMAGE}" border="0" alt="{field.data.LEGEND}" title="{field.data.TITLE}" /></a></div><div style="position: absolute; left: 3px; top: -1px;"><a href="{field.data.U_IMAGE_LINK}" {field.data.HTML}><img src="{field.data.IMAGE_STATUS}" border="0" width="18" height="18" alt="" title="{field.data.TITLE}" /></a></div></div></td></tr>
</table><!-- END messenger_status_output -->

<!-- END data -->

<!-- BEGIN legend --></td><!-- END legend -->
<!-- BEGIN over --></td><!-- END over -->
<!-- BEGIN row -->
</tr>
<!-- END row -->

<!-- END field -->