{UPLOAD_VIA} <a href="http://www.imageshock.eu/" target="_blank" style="font-weight:bold">{SITE_IN_TEXT}</a>
<form onSubmit="disableme('send');" name="myform" id="myform" action="http://www.imageshock.eu/zpracovani.php" enctype="multipart/form-data" method="post">
<input id="number1" type="hidden" name="number1" value="ano" />
<input type="file" id="uploadsoubor1" name="uploadsoubor1" class="upload" size="50" /><br />
<input name="how1" id="howzesouboru1" value="zesouboru" type="hidden" />
<input type="hidden" id="theselect1" name="theselect1" value="o" />
<input type="hidden" name="verejny1" id="verejny1" value="1" />
<input type="hidden" name="radek1" id="radek1" value="1" />
<input type="hidden" name="pocitadlo1" id="pocitadlo1" value="1" />
<input type="hidden" name="tiny" value="1" />
<input type="hidden" value="#000000" name="barvapozadi1" />
<input type="hidden" value="#FFFF00" name="barvatextu1" />
<input type="hidden" value="trebuchetms" name="typpisma1" />
<input type="hidden" value="9" name="velikostpisma1" />
<input type="hidden" value="{OWN_URL}" name="urx" />
<input type="submit" class="liteoption" value="{UPLOAD}" id="send" />
<div style="font-size:11px;padding-top:6px">
{JPG_2MB}
</div>
</form>
<script type="text/javascript">
{PROBLEM_APPEARS}
function disableme (what) {
    what = document.getElementById(what);
    what.disabled = true;
    what.value="{UPLOADING}";
}
</script>
</body>
</html>