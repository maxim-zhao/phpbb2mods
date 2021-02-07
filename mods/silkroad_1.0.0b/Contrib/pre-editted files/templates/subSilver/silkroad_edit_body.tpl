<form action="{S_SILKROAD_ACTION}" {S_FORM_ENCTYPE} method="post">

	{ERROR_BOX}

	<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
		<tr> 
			<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
		</tr>
	</table>

	<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
		<tr>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
				<tr> 
					<td class="row1" nowrap><span class="gen">{L_SILK_SN}:&nbsp;</span></td>
					<td class="row2" width="100%"><input type="hidden" name="username" value="{SILKROAD_USERNAME}" /><span class="gen"><b>{SILKROAD_USERNAME}</b></span></td>
				</tr>
			</table>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <th class="thTop" width="33%" align="center" onclick="switchMenu('quests'), collapse('skills'), collapse('forces')">{L_QUEST}s</th>
			    <th class="thTop" width="33%" align="center" onclick="switchMenu('skills'), collapse('quests'), collapse('forces')">{L_SKILL}s</th>
			    <th class="thTop" width="33%" align="center" onclick="switchMenu('forces'), collapse('quests'), collapse('skills')">{L_FORCE}s</th>
			  </tr>
			</table>

			<div id="quests">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <th class="thTop" width="4%" align="center">{L_SILK_DONE}</th>
				    <th class="thTop" width="5%" align="center">{L_SILK_TODO}</th>
				    <th class="thTop" align="center">{L_QUEST}</th>
				  </tr>
				</table>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest1" value="1" {QUEST1_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest1" value="0" {QUEST1_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest1_desc')"><span class="gen">{L_QUEST1}</span></td>
				  </tr>
				</table>
				<div id="quest1_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST1_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest2" value="1" {QUEST2_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest2" value="0" {QUEST2_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest2_desc')"><span class="gen">{L_QUEST2}</span></td>
				  </tr>
				</table>
				<div id="quest2_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST2_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest3" value="1" {QUEST3_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest3" value="0" {QUEST3_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest3_desc')"><span class="gen">{L_QUEST3}</span></td>
				  </tr>
				</table>
				<div id="quest3_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST3_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest4" value="1" {QUEST4_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest4" value="0" {QUEST4_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest4_desc')"><span class="gen">{L_QUEST4}</span></td>
				  </tr>
				</table>
				<div id="quest4_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST4_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest5" value="1" {QUEST5_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest5" value="0" {QUEST5_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest5_desc')"><span class="gen">{L_QUEST5}</span></td>
				  </tr>
				</table>
				<div id="quest5_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST5_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest6" value="1" {QUEST6_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest6" value="0" {QUEST6_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest6_desc')"><span class="gen">{L_QUEST6}</span></td>
				  </tr>
				</table>
				<div id="quest6_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST6_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest7" value="1" {QUEST7_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest7" value="0" {QUEST7_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest7_desc')"><span class="gen">{L_QUEST7}</span></td>
				  </tr>
				</table>
				<div id="quest7_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST7_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest8" value="1" {QUEST8_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest8" value="0" {QUEST8_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest8_desc')"><span class="gen">{L_QUEST8}</span></td>
				  </tr>
				</table>
				<div id="quest8_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST8_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest9" value="1" {QUEST9_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest9" value="0" {QUEST9_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest9_desc')"><span class="gen">{L_QUEST9}</span></td>
				  </tr>
				</table>
				<div id="quest9_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST9_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest10" value="1" {QUEST10_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest10" value="0" {QUEST10_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest10_desc')"><span class="gen">{L_QUEST10}</span></td>
				  </tr>
				</table>
				<div id="quest10_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST10_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest11" value="1" {QUEST11_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest11" value="0" {QUEST11_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest11_desc')"><span class="gen">{L_QUEST11}</span></td>
				  </tr>
				</table>
				<div id="quest11_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST11_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest12" value="1" {QUEST12_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest12" value="0" {QUEST12_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest12_desc')"><span class="gen">{L_QUEST12}</span></td>
				  </tr>
				</table>
				<div id="quest12_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST12_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest13" value="1" {QUEST13_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest13" value="0" {QUEST13_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest13_desc')"><span class="gen">{L_QUEST13}</span></td>
				  </tr>
				</table>
				<div id="quest13_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST13_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest14" value="1" {QUEST14_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest14" value="0" {QUEST14_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest14_desc')"><span class="gen">{L_QUEST14}</span></td>
				  </tr>
				</table>
				<div id="quest14_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST14_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest15" value="1" {QUEST15_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest15" value="0" {QUEST15_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest15_desc')"><span class="gen">{L_QUEST15}</span></td>
				  </tr>
				</table>
				<div id="quest15_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST15_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest16" value="1" {QUEST16_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest16" value="0" {QUEST16_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest16_desc')"><span class="gen">{L_QUEST16}</span></td>
				  </tr>
				</table>
				<div id="quest16_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST16_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest17" value="1" {QUEST17_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest17" value="0" {QUEST17_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest17_desc')"><span class="gen">{L_QUEST17}</span></td>
				  </tr>
				</table>
				<div id="quest17_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST17_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest18" value="1" {QUEST18_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest18" value="0" {QUEST18_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest18_desc')"><span class="gen">{L_QUEST18}</span></td>
				  </tr>
				</table>
				<div id="quest18_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST18_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest19" value="1" {QUEST19_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest19" value="0" {QUEST19_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest19_desc')"><span class="gen">{L_QUEST19}</span></td>
				  </tr>
				</table>
				<div id="quest19_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST19_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest20" value="1" {QUEST20_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest20" value="0" {QUEST20_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest20_desc')"><span class="gen">{L_QUEST20}</span></td>
				  </tr>
				</table>
				<div id="quest20_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST20_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest21" value="1" {QUEST21_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest21" value="0" {QUEST21_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest21_desc')"><span class="gen">{L_QUEST21}</span></td>
				  </tr>
				</table>
				<div id="quest21_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST21_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest22" value="1" {QUEST22_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest22" value="0" {QUEST22_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest22_desc')"><span class="gen">{L_QUEST22}</span></td>
				  </tr>
				</table>
				<div id="quest22_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST22_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest23" value="1" {QUEST23_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest23" value="0" {QUEST23_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest23_desc')"><span class="gen">{L_QUEST23}</span></td>
				  </tr>
				</table>
				<div id="quest23_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST23_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest24" value="1" {QUEST24_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest24" value="0" {QUEST24_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest24_desc')"><span class="gen">{L_QUEST24}</span></td>
				  </tr>
				</table>
				<div id="quest24_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST24_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest25" value="1" {QUEST25_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest25" value="0" {QUEST25_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest25_desc')"><span class="gen">{L_QUEST25}</span></td>
				  </tr>
				</table>
				<div id="quest25_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST25_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest26" value="1" {QUEST26_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest26" value="0" {QUEST26_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest26_desc')"><span class="gen">{L_QUEST26}</span></td>
				  </tr>
				</table>
				<div id="quest26_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST26_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest27" value="1" {QUEST27_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest27" value="0" {QUEST27_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest27_desc')"><span class="gen">{L_QUEST27}</span></td>
				  </tr>
				</table>
				<div id="quest27_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST27_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest28" value="1" {QUEST28_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest28" value="0" {QUEST28_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest28_desc')"><span class="gen">{L_QUEST28}</span></td>
				  </tr>
				</table>
				<div id="quest28_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST28_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest29" value="1" {QUEST29_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest29" value="0" {QUEST29_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest29_desc')"><span class="gen">{L_QUEST29}</span></td>
				  </tr>
				</table>
				<div id="quest29_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST29_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest30" value="1" {QUEST30_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest30" value="0" {QUEST30_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest30_desc')"><span class="gen">{L_QUEST30}</span></td>
				  </tr>
				</table>
				<div id="quest30_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST30_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest31" value="1" {QUEST31_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest31" value="0" {QUEST31_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest31_desc')"><span class="gen">{L_QUEST31}</span></td>
				  </tr>
				</table>
				<div id="quest31_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST31_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest32" value="1" {QUEST32_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest32" value="0" {QUEST32_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest32_desc')"><span class="gen">{L_QUEST32}</span></td>
				  </tr>
				</table>
				<div id="quest32_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST32_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest33" value="1" {QUEST33_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest33" value="0" {QUEST33_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest33_desc')"><span class="gen">{L_QUEST33}</span></td>
				  </tr>
				</table>
				<div id="quest33_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST33_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest34" value="1" {QUEST34_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest34" value="0" {QUEST34_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest34_desc')"><span class="gen">{L_QUEST34}</span></td>
				  </tr>
				</table>
				<div id="quest34_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST34_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest35" value="1" {QUEST35_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest35" value="0" {QUEST35_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest35_desc')"><span class="gen">{L_QUEST35}</span></td>
				  </tr>
				</table>
				<div id="quest35_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST35_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest36" value="1" {QUEST36_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest36" value="0" {QUEST36_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest36_desc')"><span class="gen">{L_QUEST36}</span></td>
				  </tr>
				</table>
				<div id="quest36_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST36_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest37" value="1" {QUEST37_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest37" value="0" {QUEST37_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest37_desc')"><span class="gen">{L_QUEST37}</span></td>
				  </tr>
				</table>
				<div id="quest37_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST37_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest38" value="1" {QUEST38_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest38" value="0" {QUEST38_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest38_desc')"><span class="gen">{L_QUEST38}</span></td>
				  </tr>
				</table>
				<div id="quest38_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST38_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest39" value="1" {QUEST39_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest39" value="0" {QUEST39_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest39_desc')"><span class="gen">{L_QUEST39}</span></td>
				  </tr>
				</table>
				<div id="quest39_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST39_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest40" value="1" {QUEST40_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest40" value="0" {QUEST40_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest40_desc')"><span class="gen">{L_QUEST40}</span></td>
				  </tr>
				</table>
				<div id="quest40_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST40_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest41" value="1" {QUEST41_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest41" value="0" {QUEST41_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest41_desc')"><span class="gen">{L_QUEST41}</span></td>
				  </tr>
				</table>
				<div id="quest41_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST41_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest42" value="1" {QUEST42_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest42" value="0" {QUEST42_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest42_desc')"><span class="gen">{L_QUEST42}</span></td>
				  </tr>
				</table>
				<div id="quest42_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST42_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest43" value="1" {QUEST43_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest43" value="0" {QUEST43_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest43_desc')"><span class="gen">{L_QUEST43}</span></td>
				  </tr>
				</table>
				<div id="quest43_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST43_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest44" value="1" {QUEST44_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest44" value="0" {QUEST44_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest44_desc')"><span class="gen">{L_QUEST44}</span></td>
				  </tr>
				</table>
				<div id="quest44_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST44_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest45" value="1" {QUEST45_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest45" value="0" {QUEST45_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest45_desc')"><span class="gen">{L_QUEST45}</span></td>
				  </tr>
				</table>
				<div id="quest45_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST45_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest46" value="1" {QUEST46_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest46" value="0" {QUEST46_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest46_desc')"><span class="gen">{L_QUEST46}</span></td>
				  </tr>
				</table>
				<div id="quest46_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST46_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest47" value="1" {QUEST47_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest47" value="0" {QUEST47_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest47_desc')"><span class="gen">{L_QUEST47}</span></td>
				  </tr>
				</table>
				<div id="quest47_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST47_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest48" value="1" {QUEST48_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest48" value="0" {QUEST48_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest48_desc')"><span class="gen">{L_QUEST48}</span></td>
				  </tr>
				</table>
				<div id="quest48_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST48_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest49" value="1" {QUEST49_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest49" value="0" {QUEST49_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest49_desc')"><span class="gen">{L_QUEST49}</span></td>
				  </tr>
				</table>
				<div id="quest49_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST49_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest50" value="1" {QUEST50_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest50" value="0" {QUEST50_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest50_desc')"><span class="gen">{L_QUEST50}</span></td>
				  </tr>
				</table>
				<div id="quest50_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST50_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest51" value="1" {QUEST51_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest51" value="0" {QUEST51_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest51_desc')"><span class="gen">{L_QUEST51}</span></td>
				  </tr>
				</table>
				<div id="quest51_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST51_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest52" value="1" {QUEST52_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest52" value="0" {QUEST52_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest52_desc')"><span class="gen">{L_QUEST52}</span></td>
				  </tr>
				</table>
				<div id="quest52_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST52_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest53" value="1" {QUEST53_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest53" value="0" {QUEST53_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest53_desc')"><span class="gen">{L_QUEST53}</span></td>
				  </tr>
				</table>
				<div id="quest53_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST53_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest54" value="1" {QUEST54_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest54" value="0" {QUEST54_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest54_desc')"><span class="gen">{L_QUEST54}</span></td>
				  </tr>
				</table>
				<div id="quest54_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST54_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest55" value="1" {QUEST55_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest55" value="0" {QUEST55_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest55_desc')"><span class="gen">{L_QUEST55}</span></td>
				  </tr>
				</table>
				<div id="quest55_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST55_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest56" value="1" {QUEST56_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest56" value="0" {QUEST56_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest56_desc')"><span class="gen">{L_QUEST56}</span></td>
				  </tr>
				</table>
				<div id="quest56_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST56_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest57" value="1" {QUEST57_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest57" value="0" {QUEST57_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest57_desc')"><span class="gen">{L_QUEST57}</span></td>
				  </tr>
				</table>
				<div id="quest57_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST57_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest58" value="1" {QUEST58_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest58" value="0" {QUEST58_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest58_desc')"><span class="gen">{L_QUEST58}</span></td>
				  </tr>
				</table>
				<div id="quest58_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST58_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest59" value="1" {QUEST59_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest59" value="0" {QUEST59_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest59_desc')"><span class="gen">{L_QUEST59}</span></td>
				  </tr>
				</table>
				<div id="quest59_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST59_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest60" value="1" {QUEST60_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest60" value="0" {QUEST60_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest60_desc')"><span class="gen">{L_QUEST60}</span></td>
				  </tr>
				</table>
				<div id="quest60_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST60_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest61" value="1" {QUEST61_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest61" value="0" {QUEST61_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest61_desc')"><span class="gen">{L_QUEST61}</span></td>
				  </tr>
				</table>
				<div id="quest61_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST61_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest62" value="1" {QUEST62_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest62" value="0" {QUEST62_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest62_desc')"><span class="gen">{L_QUEST62}</span></td>
				  </tr>
				</table>
				<div id="quest62_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST62_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest63" value="1" {QUEST63_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest63" value="0" {QUEST63_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest63_desc')"><span class="gen">{L_QUEST63}</span></td>
				  </tr>
				</table>
				<div id="quest63_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST63_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest64" value="1" {QUEST64_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest64" value="0" {QUEST64_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest64_desc')"><span class="gen">{L_QUEST64}</span></td>
				  </tr>
				</table>
				<div id="quest64_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST64_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest65" value="1" {QUEST65_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest65" value="0" {QUEST65_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest65_desc')"><span class="gen">{L_QUEST65}</span></td>
				  </tr>
				</table>
				<div id="quest65_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST65_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest66" value="1" {QUEST66_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest66" value="0" {QUEST66_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest66_desc')"><span class="gen">{L_QUEST66}</span></td>
				  </tr>
				</table>
				<div id="quest66_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST66_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest67" value="1" {QUEST67_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest67" value="0" {QUEST67_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest67_desc')"><span class="gen">{L_QUEST67}</span></td>
				  </tr>
				</table>
				<div id="quest67_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST67_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest68" value="1" {QUEST68_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest68" value="0" {QUEST68_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest68_desc')"><span class="gen">{L_QUEST68}</span></td>
				  </tr>
				</table>
				<div id="quest68_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST68_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest69" value="1" {QUEST69_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest69" value="0" {QUEST69_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest69_desc')"><span class="gen">{L_QUEST69}</span></td>
				  </tr>
				</table>
				<div id="quest69_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST69_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest70" value="1" {QUEST70_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest70" value="0" {QUEST70_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest70_desc')"><span class="gen">{L_QUEST70}</span></td>
				  </tr>
				</table>
				<div id="quest70_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST70_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest71" value="1" {QUEST71_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest71" value="0" {QUEST71_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest71_desc')"><span class="gen">{L_QUEST71}</span></td>
				  </tr>
				</table>
				<div id="quest71_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST71_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest72" value="1" {QUEST72_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest72" value="0" {QUEST72_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest72_desc')"><span class="gen">{L_QUEST72}</span></td>
				  </tr>
				</table>
				<div id="quest72_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST72_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest73" value="1" {QUEST73_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest73" value="0" {QUEST73_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest73_desc')"><span class="gen">{L_QUEST73}</span></td>
				  </tr>
				</table>
				<div id="quest73_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST73_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest74" value="1" {QUEST74_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest74" value="0" {QUEST74_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest74_desc')"><span class="gen">{L_QUEST74}</span></td>
				  </tr>
				</table>
				<div id="quest74_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST74_DESC}</span></td>
						</tr>
					</table>
				</div>

				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="4%" align="center"><input type="radio" name="quest75" value="1" {QUEST75_YES} /></td>
				    <td class="row1" width="5%" align="center"><input type="radio" name="quest75" value="0" {QUEST75_NO} /></td>
				    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest75_desc')"><span class="gen">{L_QUEST75}</span></td>
				  </tr>
				</table>
				<div id="quest75_desc" style="display: none">
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
						<tr>
							<td class="row1" width="4%"></td>
							<td class="row1" width="5%"></td>
							<td class="row2"><span class="gen">{L_QUEST75_DESC}</span></td>
						</tr>
					</table>
				</div>
			</div>

			<div id="skills" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <th class="thTop" width="8%" align="center">{L_SILK_MASTERY}</th>
				    <th class="thTop" align="center" onclick="switchMenu('bicheon')">{L_BICHEON}</th>
				  </tr>
				</table>
			
				<div id="bicheon">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SMASHING}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill1" value="1" {SKILL1_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill1" value="0" {SKILL1_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL1_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL1}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill2" value="1" {SKILL2_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill2" value="0" {SKILL2_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL2_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL2}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill3" value="1" {SKILL3_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill3" value="0" {SKILL3_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL3_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL3}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_CHAIN}</b></span></td>
					  </tr>
					</table>					
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill4" value="1" {SKILL4_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill4" value="0" {SKILL4_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL4_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL4}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill5" value="1" {SKILL5_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill5" value="0" {SKILL5_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL5_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL5}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill6" value="1" {SKILL6_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill6" value="0" {SKILL6_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL6_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL6}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill7" value="1" {SKILL7_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill7" value="0" {SKILL7_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL7_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL7}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill8" value="1" {SKILL8_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill8" value="0" {SKILL8_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL8_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL8}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SHIELD}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill9" value="1" {SKILL9_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill9" value="0" {SKILL9_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL9_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL9}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill10" value="1" {SKILL10_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill10" value="0" {SKILL10_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL10_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL10}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill11" value="1" {SKILL11_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill11" value="0" {SKILL11_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL11_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL11}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_BLADE_FORCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill12" value="1" {SKILL12_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill12" value="0" {SKILL12_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL12_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL12}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill13" value="1" {SKILL13_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill13" value="0" {SKILL13_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL13_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL13}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill14" value="1" {SKILL14_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill14" value="0" {SKILL14_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL14_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL14}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_HIDDEN_BLADE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill15" value="1" {SKILL15_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill15" value="0" {SKILL15_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL15_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL15}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill16" value="1" {SKILL16_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill16" value="0" {SKILL16_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL16_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL16}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill17" value="1" {SKILL17_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill17" value="0" {SKILL17_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL17_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL17}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_KILLING_BLADE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill18" value="1" {SKILL18_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill18" value="0" {SKILL18_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL18_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL18}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill19" value="1" {SKILL19_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill19" value="0" {SKILL19_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL19_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL19}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill20" value="1" {SKILL20_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill20" value="0" {SKILL20_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL20_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL20}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SWORD_DANCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill21" value="1" {SKILL21_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill21" value="0" {SKILL21_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL21_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL21}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill22" value="1" {SKILL22_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill22" value="0" {SKILL22_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL22_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL22}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SHIELD_PROTECTION}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill23" value="1" {SKILL23_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill23" value="0" {SKILL23_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL23_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL23}</span></td>
					  </tr>
					</table>
				</div>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <th class="thTop" width="8%" align="center">{L_SILK_MASTERY}</th>
				    <th class="thTop" align="center" onclick="switchMenu('heuksal')">{L_HEUKSAL}</th>
				  </tr>
				</table>
				<div id="heuksal" style="display: none">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_ANNIHILATING}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill24" value="1" {SKILL24_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill24" value="0" {SKILL24_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL24_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL24}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill25" value="1" {SKILL25_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill25" value="0" {SKILL25_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL25_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL25}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill26" value="1" {SKILL26_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill26" value="0" {SKILL26_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL26_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL26}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FANNING_SPEAR}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill27" value="1" {SKILL27_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill27" value="0" {SKILL27_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL27_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL27}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill28" value="1" {SKILL28_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill28" value="0" {SKILL28_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL28_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL28}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill29" value="1" {SKILL29_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill29" value="0" {SKILL29_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL29_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL29}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SPEAR_SERIES}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill30" value="1" {SKILL30_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill30" value="0" {SKILL30_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL30_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL30}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill31" value="1" {SKILL31_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill31" value="0" {SKILL31_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL31_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL31}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill32" value="1" {SKILL32_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill32" value="0" {SKILL32_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL32_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL32}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SOUL_SPEAR}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill33" value="1" {SKILL33_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill33" value="0" {SKILL33_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL33_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL33}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill34" value="1" {SKILL34_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill34" value="0" {SKILL34_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL34_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL34}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill35" value="1" {SKILL35_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill35" value="0" {SKILL35_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL35_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL35}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_GHOST_SPEAR}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill36" value="1" {SKILL36_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill36" value="0" {SKILL36_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL36_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL36}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill37" value="1" {SKILL37_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill37" value="0" {SKILL37_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL37_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL37}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill38" value="1" {SKILL38_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill38" value="0" {SKILL38_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL38_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL38}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_CHAIN_SPEAR}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill39" value="1" {SKILL39_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill39" value="0" {SKILL39_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL39_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL39}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill40" value="1" {SKILL40_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill40" value="0" {SKILL40_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL40_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL40}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill41" value="1" {SKILL41_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill41" value="0" {SKILL41_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL41_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL41}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill42" value="1" {SKILL42_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill42" value="0" {SKILL42_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL42_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL42}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill43" value="1" {SKILL43_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill43" value="0" {SKILL43_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL43_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL43}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FLYING_DRAGON}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill44" value="1" {SKILL44_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill44" value="0" {SKILL44_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL44_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL44}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill45" value="1" {SKILL45_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill45" value="0" {SKILL45_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL45_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL45}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_CHEOLSAN_FORCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill46" value="1" {SKILL46_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill46" value="0" {SKILL46_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL46_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL46}</span></td>
					  </tr>
					</table>
				</div>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <th class="thTop" width="8%" align="center">{L_SILK_MASTERY}</th>
				    <th class="thTop" align="center" onclick="switchMenu('pacheon')">{L_PACHEON}</th>
				  </tr>
				</table>
				<div id="pacheon" style="display: none">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_ANTI_DEVIL}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill47" value="1" {SKILL47_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill47" value="0" {SKILL47_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL47_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL47}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill48" value="1" {SKILL48_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill48" value="0" {SKILL48_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL48_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL48}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill49" value="1" {SKILL49_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill49" value="0" {SKILL49_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL49_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL49}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_ARROW_COMBO}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill50" value="1" {SKILL50_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill50" value="0" {SKILL50_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL50_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL50}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill51" value="1" {SKILL51_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill51" value="0" {SKILL51_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL51_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL51}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill52" value="1" {SKILL52_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill52" value="0" {SKILL52_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL52_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL52}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_HAWK}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill53" value="1" {SKILL53_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill53" value="0" {SKILL53_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL53_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL53}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill54" value="1" {SKILL54_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill54" value="0" {SKILL54_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL54_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL54}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill55" value="1" {SKILL55_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill55" value="0" {SKILL55_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL55_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL55}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_AUTUMN}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill56" value="1" {SKILL56_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill56" value="0" {SKILL56_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL56_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL56}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill57" value="1" {SKILL57_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill57" value="0" {SKILL57_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL57_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL57}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill58" value="1" {SKILL58_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill58" value="0" {SKILL58_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL58_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL58}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_BREAK_HEAVEN}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill59" value="1" {SKILL59_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill59" value="0" {SKILL59_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL59_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL59}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill60" value="1" {SKILL60_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill60" value="0" {SKILL60_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL60_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL60}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill61" value="1" {SKILL61_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill61" value="0" {SKILL61_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL61_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL61}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_EXPLOSION_ARROW}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill62" value="1" {SKILL62_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill62" value="0" {SKILL62_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL62_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL62}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill63" value="1" {SKILL63_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill63" value="0" {SKILL63_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL63_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL63}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill64" value="1" {SKILL64_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill64" value="0" {SKILL64_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL64_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL64}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_STRONG_BOW}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill65" value="1" {SKILL65_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill65" value="0" {SKILL65_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL65_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL65}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill66" value="1" {SKILL66_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill66" value="0" {SKILL66_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL66_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL66}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_MIND_CONCENTRATION}</b></span></td>
					  </tr>
					</table>					
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill67" value="1" {SKILL67_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="skill67" value="0" {SKILL67_NO} /></td>
						<td class="row1" align="right" width="46%">{SKILL67_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL67}</span></td>
					  </tr>
					</table>
				</div>
			</div>
			
			<div id="forces" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <th class="thTop" width="8%" align="center">{L_SILK_MASTERY}</th>
				    <th class="thTop" align="center" onclick="switchMenu('cold')">{L_COLD}</th>
				  </tr>
				</table>
				<div id="cold">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_COLD_FORCE}</b></span></td>
					  </tr>
					</table>

					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force1" value="1" {FORCE1_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force1" value="0" {FORCE1_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE1_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE1}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force2" value="1" {FORCE2_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force2" value="0" {FORCE2_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE2_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE2}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force3" value="1" {FORCE3_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force3" value="0" {FORCE3_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE3_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE3}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force4" value="1" {FORCE4_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force4" value="0" {FORCE4_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE4_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE4}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FROST_GUARD}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force5" value="1" {FORCE5_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force5" value="0" {FORCE5_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE5_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE5}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force6" value="1" {FORCE6_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force6" value="0" {FORCE6_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE6_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE6}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force7" value="1" {FORCE7_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force7" value="0" {FORCE7_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE7_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE7}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force8" value="1" {FORCE8_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force8" value="0" {FORCE8_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE8_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE8}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_COLD_WAVE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force9" value="1" {FORCE9_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force9" value="0" {FORCE9_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE9_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE9}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force10" value="1" {FORCE10_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force10" value="0" {FORCE10_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE10_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE10}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force11" value="1" {FORCE11_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force11" value="0" {FORCE11_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE11_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE11}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FROST_WALL}</b></span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force12" value="1" {FORCE12_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force12" value="0" {FORCE12_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE12_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE12}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force13" value="1" {FORCE13_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force13" value="0" {FORCE13_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE13_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE13}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force14" value="1" {FORCE14_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force14" value="0" {FORCE14_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE14_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE14}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FROST_NOVA}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force15" value="1" {FORCE15_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force15" value="0" {FORCE15_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE15_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE15}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force16" value="1" {FORCE16_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force16" value="0" {FORCE16_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE16_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE16}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force17" value="1" {FORCE17_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force17" value="0" {FORCE17_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE17_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE17}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SNOW_STORM}</b></span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force18" value="1" {FORCE18_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force18" value="0" {FORCE18_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE18_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE18}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force19" value="1" {FORCE19_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force19" value="0" {FORCE19_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE19_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE19}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_COLD_ARMOR}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force20" value="1" {FORCE20_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force20" value="0" {FORCE20_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE20_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE20}</span></td>
					  </tr>
					</table>
				</div>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
					<th class="thTop" width="8%" align="center">{L_SILK_MASTERY}</th>
					<th class="thTop" align="center" onclick="switchMenu('fire')">{L_FIRE}</th>
				  </tr>
				</table>
				<div id="fire" style="display: none">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FIRE_FORCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force21" value="1" {FORCE21_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force21" value="0" {FORCE21_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE21_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE21}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force22" value="1" {FORCE22_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force22" value="0" {FORCE22_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE22_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE22}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force23" value="1" {FORCE23_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force23" value="0" {FORCE23_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE23_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE23}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force24" value="1" {FORCE24_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force24" value="0" {FORCE24_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE24_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE24}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FIRE_SHIELD}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force25" value="1" {FORCE25_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force25" value="0" {FORCE25_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE25_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE25}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force26" value="1" {FORCE26_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force26" value="0" {FORCE26_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE26_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE26}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force27" value="1" {FORCE27_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force27" value="0" {FORCE27_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE27_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE27}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force28" value="1" {FORCE28_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force28" value="0" {FORCE28_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE28_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE28}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FLAME_BODY}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force29" value="1" {FORCE29_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force29" value="0" {FORCE29_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE29_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE29}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force30" value="1" {FORCE30_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force30" value="0" {FORCE30_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE30_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE30}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force31" value="1" {FORCE31_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force31" value="0" {FORCE31_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE31_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE31}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FIRE_PROTECTION}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force32" value="1" {FORCE32_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force32" value="0" {FORCE32_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE32_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE32}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force33" value="1" {FORCE33_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force33" value="0" {FORCE33_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE33_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE33}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force34" value="1" {FORCE34_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force34" value="0" {FORCE34_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE34_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE34}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FIRE_WALL}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force35" value="1" {FORCE35_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force35" value="0" {FORCE35_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE35_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE35}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force36" value="1" {FORCE36_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force36" value="0" {FORCE36_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE36_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE36}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force37" value="1" {FORCE37_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force37" value="0" {FORCE37_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE37_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE37}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FLAME_WAVE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force38" value="1" {FORCE38_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force38" value="0" {FORCE38_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE38_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE38}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force39" value="1" {FORCE39_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force39" value="0" {FORCE39_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE39_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE39}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force40" value="1" {FORCE40_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force40" value="0" {FORCE40_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE40_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE40}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FLAME_DEVIL}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force41" value="1" {FORCE41_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force41" value="0" {FORCE41_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE41_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE41}</span></td>
					  </tr>
					</table>
			</div>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
					<th class="thTop" width="8%" align="center">{L_SILK_MASTERY}</th>
					<th class="thTop" align="center" onclick="switchMenu('thunder')">{L_THUNDER}</th>
				  </tr>
				</table>
				<div id="thunder" style="display: none">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_THUNDER_FORCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force42" value="1" {FORCE42_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force42" value="0" {FORCE42_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE42_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE42}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force43" value="1" {FORCE43_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force43" value="0" {FORCE43_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE43_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE43}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force44" value="1" {FORCE44_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force44" value="0" {FORCE44_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE44_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE44}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force45" value="1" {FORCE45_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force45" value="0" {FORCE45_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE45_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE45}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_PIERCING_FORCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force46" value="1" {FORCE46_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force46" value="0" {FORCE46_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE46_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE46}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force47" value="1" {FORCE47_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force47" value="0" {FORCE47_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE47_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE47}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force48" value="1" {FORCE48_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force48" value="0" {FORCE48_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE48_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE48}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force49" value="1" {FORCE49_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force49" value="0" {FORCE49_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE49_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE49}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_WIND_WALK}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force50" value="1" {FORCE50_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force50" value="0" {FORCE50_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE50_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE50}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force51" value="1" {FORCE51_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force51" value="0" {FORCE51_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE51_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE51}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force52" value="1" {FORCE52_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force52" value="0" {FORCE52_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE52_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE52}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_LION_SHOUT}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force53" value="1" {FORCE53_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force53" value="0" {FORCE53_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE53_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE53}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force54" value="1" {FORCE54_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force54" value="0" {FORCE54_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE54_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE54}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force55" value="1" {FORCE55_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force55" value="0" {FORCE55_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE55_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE55}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_CONCENTRATION}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force56" value="1" {FORCE56_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force56" value="0" {FORCE56_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE56_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE56}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force57" value="1" {FORCE57_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force57" value="0" {FORCE57_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE57_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE57}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force58" value="1" {FORCE58_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force58" value="0" {FORCE58_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE58_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE58}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_THUNDERBOLT_FORCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force59" value="1" {FORCE59_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force59" value="0" {FORCE59_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE59_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE59}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force60" value="1" {FORCE60_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force60" value="0" {FORCE60_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE60_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE60}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_HEAVEN_FORCE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force61" value="1" {FORCE61_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force61" value="0" {FORCE61_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE61_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE61}</span></td>
					  </tr>
					</table>
				</div>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
					<th class="thTop" width="8%" align="center">{L_SILK_MASTERY}</th>
					<th class="thTop" align="center" onclick="switchMenu('force')">{L_FORCE}</th>
				  </tr>
				</table>
				<div id="force" style="display: none">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_SELF_HEAL}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force62" value="1" {FORCE62_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force62" value="0" {FORCE62_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE62_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE62}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force63" value="1" {FORCE63_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force63" value="0" {FORCE63_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE63_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE63}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force64" value="1" {FORCE64_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force64" value="0" {FORCE64_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE64_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE64}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force65" value="1" {FORCE65_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force65" value="0" {FORCE65_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE65_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE65}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FORCE_CURE}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force66" value="1" {FORCE66_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force66" value="0" {FORCE66_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE66_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE66}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force67" value="1" {FORCE67_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force67" value="0" {FORCE67_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE67_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE67}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force68" value="1" {FORCE68_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force68" value="0" {FORCE68_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE68_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE68}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force69" value="1" {FORCE69_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force69" value="0" {FORCE69_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE69_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE69}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_HEAL}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force70" value="1" {FORCE70_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force70" value="0" {FORCE70_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE70_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE70}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force71" value="1" {FORCE71_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force71" value="0" {FORCE71_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE71_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE71}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force72" value="1" {FORCE72_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force72" value="0" {FORCE72_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE72_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE72}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_REBIRTH}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force73" value="1" {FORCE73_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force73" value="0" {FORCE73_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE73_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE73}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force74" value="1" {FORCE74_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force74" value="0" {FORCE74_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE74_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE74}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force75" value="1" {FORCE75_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force75" value="0" {FORCE75_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE75_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE75}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_NATURAL_THERAPY}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force76" value="1" {FORCE76_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force76" value="0" {FORCE76_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE76_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE76}</span></td>
					  </tr>
					</table>				
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force77" value="1" {FORCE77_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force77" value="0" {FORCE77_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE77_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE77}</span></td>
					  </tr>
					</table>	
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force78" value="1" {FORCE78_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force78" value="0" {FORCE78_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE78_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE78}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_VITAL_SPOT}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force79" value="1" {FORCE79_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force79" value="0" {FORCE79_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE79_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE79}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force80" value="1" {FORCE80_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force80" value="0" {FORCE80_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE80_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE80}</span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tr>
					    <td class="row2" width="8%"></td>
					    <td class="row2" align="center"><span class="gen"><b>{L_FORCE_INCREASING}</b></span></td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="1" width="100%">
					  <tr>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force81" value="1" {FORCE81_YES} /></td>
					    <td class="row1" width="4%" align="center"><input type="radio" name="force81" value="0" {FORCE81_NO} /></td>
						<td class="row1" align="right" width="46%">{FORCE81_IMG}</td>
					    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE81}</span></td>
					  </tr>
					</table>
				</div>
			</div>
			
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			<tr>
				<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
			</tr>
			</table>
				
		</tr>
	</table>

</form>