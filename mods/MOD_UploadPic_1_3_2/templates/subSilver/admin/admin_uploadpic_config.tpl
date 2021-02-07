<h1>{L_TITLE}</h1>
<hr />
<br />
<form action="{URL_SELF}" method="post" name="form_uploadpicusers">
  <table cellpadding="0" cellspacing="0" border="1" align="center" class="bodyline">
    <tr>
      <td><table border="0" cellspacing="1" cellpadding="4" class="genmed">
          <tr height="30">
            <th colspan="2" class="thHead">{L_TITLE}</th>
          </tr>
          <tr>
            <td class="row1">{L_UP_PICDIR}</td>
            <td class="row2">{V_UP_PICDIR}</td>
          </tr>
          <tr>
            <td class="row1">{L_UP_UNIQFN}</td>
            <td class="row2"><input name="uploadpic_uniqfn" type="checkbox" id="uploadpic_uniqfn" value="1" {V_UP_UNIQFN_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_DELETE}</td>
            <td class="row2"><input name="uploadpic_delete" type="checkbox" id="uploadpic_delete" value="1" {V_UP_DELETE_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_LRMOD}</td>
            <td class="row2"><input name="uploadpic_lrmod" type="checkbox" id="uploadpic_lrmod" value="1" {V_UP_LRMOD_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_SHOWLINK}</td>
            <td class="row2"><input name="uploadpic_showlink" type="radio" value="0" {V_UP_SHOWLINK0_CHECKED} />[IMG] |
              <input name="uploadpic_showlink" type="radio" value="1" {V_UP_SHOWLINK1_CHECKED} />[URL] |
              <input name="uploadpic_showlink" type="radio" value="2" {V_UP_SHOWLINK2_CHECKED} />{L_BOTH} </td>
          </tr>
          <tr>
            <td class="row1">{L_UP_VBBCODE}</td>
            <td class="row2"><input name="uploadpic_vbbcode" type="checkbox" id="uploadpic_vbbcode" value="1" {V_UP_VBBCODE_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_MULTIPLE}</td>
            <td class="row2"><input name="uploadpic_multiple" type="checkbox" id="uploadpic_multiple" value="1" {V_UP_MULTIPLE_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_MAXSIZE}</td>
            <td class="row2"><input name="uploadpic_maxsize" type="text" id="uploadpic_maxsize" value="{V_UP_MAXSIZE}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_MAXPICX}</td>
            <td class="row2"><input name="uploadpic_maxpicx" type="text" id="uploadpic_maxpicx" value="{V_UP_MAXPICX}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_MAXPICY}</td>
            <td class="row2"><input name="uploadpic_maxpicy" type="text" id="uploadpic_maxpicy" value="{V_UP_MAXPICY}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_MINIMUM}</td>
            <td class="row2"><input name="uploadpic_minimum" type="text" id="uploadpic_minimum" value="{V_UP_MINIMUM}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_ALLOWED}</td>
            <td class="row2"><input name="uploadpic_allowed" type="text" id="uploadpic_allowed" value="{V_UP_ALLOWED}" size="40" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_JPGQUAL}</td>
            <td class="row2"><input name="uploadpic_jpgqual" type="text" id="uploadpic_jpgqual" value="{V_UP_JPGQUAL}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_ALLOWPM}</td>
            <td class="row2"><input name="uploadpic_allowpm" type="checkbox" id="uploadpic_allowpm" value="1" {V_UP_ALLOWPM_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_MAXPMDAYS}</td>
            <td class="row2"><input name="uploadpic_maxpmdays" type="text" id="uploadpic_maxpmdays" value="{V_UP_MAXPMDAYS}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_MINPOSTS}</td>
            <td class="row2"><input name="uploadpic_minposts" type="text" id="uploadpic_minposts" value="{V_UP_MINPOSTS}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_GALLERY}</td>
            <td class="row2"><input name="uploadpic_gallery" type="checkbox" id="uploadpic_gallery" value="1" {V_UP_GALLERY_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_GALLERYSIZE}</td>
            <td class="row2"><input name="uploadpic_gallerysize" type="text" id="uploadpic_gallerysize" value="{V_UP_GALLERYSIZE}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_WATERMARK}</td>
            <td class="row2"><input name="uploadpic_watermark" type="checkbox" id="uploadpic_watermark" value="1" {V_UP_WATERMARK_CHECKED} /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_WMPICTURE}</td>
            <td class="row2"><input name="uploadpic_wmpicture" type="text" id="uploadpic_wmpicture" value="{V_UP_WMPICTURE}" size="40" />
              <br /><strong>{V_UP_WMPICEXISTS}</strong></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_WMMINSIZE}</td>
            <td class="row2"><input name="uploadpic_wmpicx" type="text" id="uploadpic_wmpicx" value="{V_UP_WMPICX}" size="10" />
              x
              <input name="uploadpic_wmpicy" type="text" id="uploadpic_wmpicy" value="{V_UP_WMPICY}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_WMPOSITION}</td>
            <td class="row2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="uploadpic_wmposition" type="radio" value="1" {V_UP_WMPOSTL_CHECKED} />{L_UP_POSTL}</td>
                <td><input name="uploadpic_wmposition" type="radio" value="2" {V_UP_WMPOSTC_CHECKED} />{L_UP_POSTC}</td>
                <td><input name="uploadpic_wmposition" type="radio" value="3" {V_UP_WMPOSTR_CHECKED} />{L_UP_POSTR}</td>
              </tr>
              <tr>
                <td><input name="uploadpic_wmposition" type="radio" value="4" {V_UP_WMPOSBL_CHECKED} />{L_UP_POSBL}</td>
                <td><input name="uploadpic_wmposition" type="radio" value="5" {V_UP_WMPOSBC_CHECKED} />{L_UP_POSBC}</td>
                <td><input name="uploadpic_wmposition" type="radio" value="6" {V_UP_WMPOSBR_CHECKED} />{L_UP_POSBR}</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_NUMLATEST}</td>
            <td class="row2"><input name="uploadpic_numlatest" type="text" id="uploadpic_numlatest" value="{V_UP_NUMLATEST}" size="10" /></td>
          </tr>
          <tr>
            <td class="row1">{L_UP_FORCEPATH}</td>
            <td class="row2"><input name="uploadpic_forcepath" type="text" id="uploadpic_forcepath" value="{V_UP_FORCEPATH}" size="40" /></td>
          </tr>
          <tr align="center" height="30">
            <td colspan="2" class="row1"><input name="GO" type="submit" id="GO" value="{L_SAVE}"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<br />
<table align="center">
  <tr>
    <td><span class="copyright">B.Funke | <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></td>
  </tr>
</table>
