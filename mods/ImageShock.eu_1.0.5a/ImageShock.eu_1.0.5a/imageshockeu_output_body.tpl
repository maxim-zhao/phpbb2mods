<table cellpadding="0" cellspacing="0">
<tr>
<td style="font-size:11px" valign="top">
{UPLOADED}
<div style="padding-top:8px;font-size:11px">
<table cellspacing="0" cellpadding="0"><tr><td>
<input title="{THUMBNAIL_LINK}" onClick="highlight(this);" value="[url=http://www.imageshock.eu/?img={FILE}.{EXT}][img]http://www.imageshock.eu/img_small/{FILE}.{EXT}[/img][/url]" id="thumb" style="width:245px;" />
</td></tr>
<tr><td>
<input title="{HOTLINK}" onClick="highlight(this);" value="[url=http://www.imageshock.eu/?img={FILE}.{EXT}][img]http://www.imageshock.eu/img/{FILE}.{EXT}[/img][/url]" id="hotlink" style="width:245px;" />
</td></tr></table>
</div>

<div style="padding-top:3px;font-size:10px">
{AUTO}
</div>
<br />
{YOU_CAN}<a href="?">{ANOTHER}</a>
</td>
<td style="font-size:11px;padding-left:5px" valign="top">
<a target="_blank" href="http://www.imageshock.eu/?img={FILE}.{EXT}" />
<img style="border:none" src="http://www.imageshock.eu/img_small/{FILE}.jpg" />
</a>
</td>
</tr>
</table>
<script type="text/javascript">
function highlight(field) {
        field.focus();
        field.select();
}
parent.document.post.message.value += ' '+document.getElementById('thumb').value;
</script>
</body>
</html>