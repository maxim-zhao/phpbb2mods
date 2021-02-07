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
				<td class="row1" width="8%"><span class="gen">{L_SILK_SN}:</span></td>
				<td class="row2"><input type="hidden" name="username" value="{SILKROAD_USERNAME}" /><span class="gen">{SILKROAD_USERNAME}</span></td>
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
			    <th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
			    <th class="thTop" align="center">{L_QUEST}</th>
			  </tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST1_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest1')"><span class="gen">{L_QUEST1}</span></td>
			  </tr>
			</table>
			<div id="quest1" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST1_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST2_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest2')"><span class="gen">{L_QUEST2}</span></td>
			  </tr>
			</table>
			<div id="quest2" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST2_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST3_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest3')"><span class="gen">{L_QUEST3}</span></td>
			  </tr>
			</table>
			<div id="quest3" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST3_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST4_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest4')"><span class="gen">{L_QUEST4}</span></td>
			  </tr>
			</table>
			<div id="quest4" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST4_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST5_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest5')"><span class="gen">{L_QUEST5}</span></td>
			  </tr>
			</table>
			<div id="quest5" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST5_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST6_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest6')"><span class="gen">{L_QUEST6}</span></td>
			  </tr>
			</table>
			<div id="quest6" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST6_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST7_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest7')"><span class="gen">{L_QUEST7}</span></td>
			  </tr>
			</table>
			<div id="quest7" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST7_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST8_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest8')"><span class="gen">{L_QUEST8}</span></td>
			  </tr>
			</table>
			<div id="quest8" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST8_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST9_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest9')"><span class="gen">{L_QUEST9}</span></td>
			  </tr>
			</table>
			<div id="quest9" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST9_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST10_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest10')"><span class="gen">{L_QUEST10}</span></td>
			  </tr>
			</table>
			<div id="quest10" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST10_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST11_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest11')"><span class="gen">{L_QUEST11}</span></td>
			  </tr>
			</table>
			<div id="quest11" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST11_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST12_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest12')"><span class="gen">{L_QUEST12}</span></td>
			  </tr>
			</table>
			<div id="quest12" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST12_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST13_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest13')"><span class="gen">{L_QUEST13}</span></td>
			  </tr>
			</table>
			<div id="quest13" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST13_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST14_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest14')"><span class="gen">{L_QUEST14}</span></td>
			  </tr>
			</table>
			<div id="quest14" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST14_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST15_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest15')"><span class="gen">{L_QUEST15}</span></td>
			  </tr>
			</table>
			<div id="quest15" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST15_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST16_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest16')"><span class="gen">{L_QUEST16}</span></td>
			  </tr>
			</table>
			<div id="quest16" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST16_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST17_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest17')"><span class="gen">{L_QUEST17}</span></td>
			  </tr>
			</table>
			<div id="quest17" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST17_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST18_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest18')"><span class="gen">{L_QUEST18}</span></td>
			  </tr>
			</table>
			<div id="quest18" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST18_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST11_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest19')"><span class="gen">{L_QUEST19}</span></td>
			  </tr>
			</table>
			<div id="quest19" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST19_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST20_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest20')"><span class="gen">{L_QUEST20}</span></td>
			  </tr>
			</table>
			<div id="quest20" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST20_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST21_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest21')"><span class="gen">{L_QUEST21}</span></td>
			  </tr>
			</table>
			<div id="quest21" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST21_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST22_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest22')"><span class="gen">{L_QUEST22}</span></td>
			  </tr>
			</table>
			<div id="quest22" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST22_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST23_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest23')"><span class="gen">{L_QUEST23}</span></td>
			  </tr>
			</table>
			<div id="quest23" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST23_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST24_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest24')"><span class="gen">{L_QUEST24}</span></td>
			  </tr>
			</table>
			<div id="quest24" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST24_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST25_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest25')"><span class="gen">{L_QUEST25}</span></td>
			  </tr>
			</table>
			<div id="quest25" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST25_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST26_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest26')"><span class="gen">{L_QUEST26}</span></td>
			  </tr>
			</table>
			<div id="quest26" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST26_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST27_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest27')"><span class="gen">{L_QUEST27}</span></td>
			  </tr>
			</table>
			<div id="quest27" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST27_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST28_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest28')"><span class="gen">{L_QUEST28}</span></td>
			  </tr>
			</table>
			<div id="quest28" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST28_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST29_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest29')"><span class="gen">{L_QUEST29}</span></td>
			  </tr>
			</table>
			<div id="quest29" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST29_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST30_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest30')"><span class="gen">{L_QUEST30}</span></td>
			  </tr>
			</table>
			<div id="quest30" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST30_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST31_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest31')"><span class="gen">{L_QUEST31}</span></td>
			  </tr>
			</table>
			<div id="quest31" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST31_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST32_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest32')"><span class="gen">{L_QUEST32}</span></td>
			  </tr>
			</table>
			<div id="quest32" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST32_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST33_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest33')"><span class="gen">{L_QUEST33}</span></td>
			  </tr>
			</table>
			<div id="quest33" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST33_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST34_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest34')"><span class="gen">{L_QUEST34}</span></td>
			  </tr>
			</table>
			<div id="quest34" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST34_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST35_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest35')"><span class="gen">{L_QUEST35}</span></td>
			  </tr>
			</table>
			<div id="quest35" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST35_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST36_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest36')"><span class="gen">{L_QUEST36}</span></td>
			  </tr>
			</table>
			<div id="quest36" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST36_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST37_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest37')"><span class="gen">{L_QUEST37}</span></td>
			  </tr>
			</table>
			<div id="quest37" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST37_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST38_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest38')"><span class="gen">{L_QUEST38}</span></td>
			  </tr>
			</table>
			<div id="quest38" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST38_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST39_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest39')"><span class="gen">{L_QUEST39}</span></td>
			  </tr>
			</table>
			<div id="quest39" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST39_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST40_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest40')"><span class="gen">{L_QUEST40}</span></td>
			  </tr>
			</table>
			<div id="quest40" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST40_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST41_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest41')"><span class="gen">{L_QUEST41}</span></td>
			  </tr>
			</table>
			<div id="quest41" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST41_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST42_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest42')"><span class="gen">{L_QUEST42}</span></td>
			  </tr>
			</table>
			<div id="quest42" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST42_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST43_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest43')"><span class="gen">{L_QUEST43}</span></td>
			  </tr>
			</table>
			<div id="quest43" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST43_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST44_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest44')"><span class="gen">{L_QUEST44}</span></td>
			  </tr>
			</table>
			<div id="quest44" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST44_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST45_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest45')"><span class="gen">{L_QUEST45}</span></td>
			  </tr>
			</table>
			<div id="quest45" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST45_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST46_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest46')"><span class="gen">{L_QUEST46}</span></td>
			  </tr>
			</table>
			<div id="quest46" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST46_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST47_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest47')"><span class="gen">{L_QUEST47}</span></td>
			  </tr>
			</table>
			<div id="quest47" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST47_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST48_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest48')"><span class="gen">{L_QUEST48}</span></td>
			  </tr>
			</table>
			<div id="quest48" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST48_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST49_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest49')"><span class="gen">{L_QUEST49}</span></td>
			  </tr>
			</table>
			<div id="quest49" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST49_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST50_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest50')"><span class="gen">{L_QUEST50}</span></td>
			  </tr>
			</table>
			<div id="quest50" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST50_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST51_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest51')"><span class="gen">{L_QUEST51}</span></td>
			  </tr>
			</table>
			<div id="quest51" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST51_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST52_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest52')"><span class="gen">{L_QUEST52}</span></td>
			  </tr>
			</table>
			<div id="quest52" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST52_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST53_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest53')"><span class="gen">{L_QUEST53}</span></td>
			  </tr>
			</table>
			<div id="quest53" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST53_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST54_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest54')"><span class="gen">{L_QUEST54}</span></td>
			  </tr>
			</table>
			<div id="quest54" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST54_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST55_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest55')"><span class="gen">{L_QUEST55}</span></td>
			  </tr>
			</table>
			<div id="quest55" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST55_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST56_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest56')"><span class="gen">{L_QUEST56}</span></td>
			  </tr>
			</table>
			<div id="quest56" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST56_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST57_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest57')"><span class="gen">{L_QUEST57}</span></td>
			  </tr>
			</table>
			<div id="quest57" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST57_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST58_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest58')"><span class="gen">{L_QUEST58}</span></td>
			  </tr>
			</table>
			<div id="quest58" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST58_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST59_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest59')"><span class="gen">{L_QUEST59}</span></td>
			  </tr>
			</table>
			<div id="quest59" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST59_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST60_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest60')"><span class="gen">{L_QUEST60}</span></td>
			  </tr>
			</table>
			<div id="quest60" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST60_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST61_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest61')"><span class="gen">{L_QUEST61}</span></td>
			  </tr>
			</table>
			<div id="quest61" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						<td class="row2"><span class="gen">{L_QUEST61_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST62_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest62')"><span class="gen">{L_QUEST62}</span></td>
			  </tr>
			</table>
			<div id="quest62" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST62_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST63_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest63')"><span class="gen">{L_QUEST63}</span></td>
			  </tr>
			</table>
			<div id="quest63" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST63_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST64_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest64')"><span class="gen">{L_QUEST64}</span></td>
			  </tr>
			</table>
			<div id="quest64" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST64_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST65_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest65')"><span class="gen">{L_QUEST65}</span></td>
			  </tr>
			</table>
			<div id="quest65" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST65_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST66_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest66')"><span class="gen">{L_QUEST66}</span></td>
			  </tr>
			</table>
			<div id="quest66" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST66_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST67_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest67')"><span class="gen">{L_QUEST67}</span></td>
			  </tr>
			</table>
			<div id="quest67" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST67_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST68_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest68')"><span class="gen">{L_QUEST68}</span></td>
			  </tr>
			</table>
			<div id="quest68" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST68_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST69_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest69')"><span class="gen">{L_QUEST69}</span></td>
			  </tr>
			</table>
			<div id="quest69" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST69_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST70_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest70')"><span class="gen">{L_QUEST70}</span></td>
			  </tr>
			</table>
			<div id="quest70" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST70_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST71_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest71')"><span class="gen">{L_QUEST71}</span></td>
			  </tr>
			</table>
			<div id="quest71" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST71_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST72_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest72')"><span class="gen">{L_QUEST72}</span></td>
			  </tr>
			</table>
			<div id="quest72" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST72_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST73_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest73')"><span class="gen">{L_QUEST73}</span></td>
			  </tr>
			</table>
			<div id="quest73" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST73_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST74_STATUS}</span></td>
			    <td class="row1" align="center" onmouseover="this.className='row2'" onmouseout="this.className='row1'" onclick="switchMenu('quest74')"><span class="gen">{L_QUEST74}</span></td>
			  </tr>
			</table>
			<div id="quest74" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST74_DESC}</span></td>
					</tr>
				</table>
			</div>

			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <td class="row1" width="8%" align="center"><span class="gen">{QUEST75_STATUS}</span></td>
			    <td class="row1" align="center" onclick="switchMenu('quest75')"><span class="gen">{L_QUEST75}</span></td>
			  </tr>
			</table>
			<div id="quest75" style="display: none">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<td class="row1" width="8%"></td>
						
						<td class="row2"><span class="gen">{L_QUEST75_DESC}</span></td>
					</tr>
				</table>
			</div>
		</div>

		<div id="skills" style="display: none">
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL1_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL1_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL1}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL2_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL2_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL2}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL3_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL4_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL4_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL4}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL5_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL5_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL5}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL6_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL6_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL6}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL7_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL7_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL7}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL8_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL9_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL9_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL9}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL10_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL10_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL10}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL11_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL12_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL12_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL12}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL13_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL13_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL13}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL14_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL15_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL15_IMG}</td>					
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL15}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL16_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL16_IMG}</td>					
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL16}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL17_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL18_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL18_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL18}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL19_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL19_IMG}</td>					
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL19}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL20_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL21_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL21_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL21}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL22_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL23_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL23_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL23}</span></td>
				  </tr>
				</table>
			</div>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL24_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL24_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL24}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL25_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL25_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL25}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL26_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL27_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL27_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL27}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL28_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL28_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL28}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL29_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL30_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL30_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL30}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL31_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL31_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL31}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL32_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL33_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL33_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL33}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL34_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL34_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL34}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL35_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL36_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL36_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL36}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL37_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL37_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL37}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL38_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL39_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL39_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL39}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL40_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL40_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL40}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL41_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL41_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL41}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL42_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL42_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL42}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL43_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL44_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL44_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL44}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL45_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL46_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL46_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL46}</span></td>
				  </tr>
				</table>
			</div>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL47_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL47_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL47}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL48_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL48_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL48}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL49_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL50_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL50_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL50}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL51_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL51_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL51}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL52_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL53_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL53_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL53}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL54_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL54_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL54}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL55_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL56_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL56_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL56}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL57_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL57_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL57}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL58_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL59_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL59_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL59}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL60_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL60_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL60}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL61_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL62_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL62_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL62}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL63_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL63_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL63}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL64_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL65_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL65_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL65}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL66_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{SKILL67_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{SKILL67_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_SKILL67}</span></td>
				  </tr>
				</table>
			</div>
		</div>

		<div id="forces" style="display: none">
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
			    <th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE1_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE1_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE1}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE2_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE2_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE2}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE3_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE3_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE3}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE4_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE5_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE5_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE5}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE6_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE6_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE6}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE7_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE7_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE7}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE8_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE9_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE9_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE9}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE10_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE10_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE10}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE11_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE12_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE12_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE12}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE13_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE13_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE13}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE14_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE15_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE15_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE15}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE16_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE16_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE16}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE17_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE18_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE18_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE18}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE19_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE20_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE20_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE20}</span></td>
				  </tr>
				</table>
			</div>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
				<th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE21_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE21_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE21}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE22_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE22_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE22}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE23_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE23_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE23}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE24_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE25_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE25_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE25}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE26_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE26_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE26}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE27_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE27_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE27}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE28_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE29_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE29_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE29}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE30_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE30_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE30}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE31_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE32_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE32_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE32}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE33_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE33_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE33}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE34_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE35_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE35_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE35}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE36_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE36_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE36}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE37_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE38_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE38_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE38}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE39_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE39_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE39}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE40_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE41_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE41_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE41}</span></td>
				  </tr>
				</table>
			</div>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
				<th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE42_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE42_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE42}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE43_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE43_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE43}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE44_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE44_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE44}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE45_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE46_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE46_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE46}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE47_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE47_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE47}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE48_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE48_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE48}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE49_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE50_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE50_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE50}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE51_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE51_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE51}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE52_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE53_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE53_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE53}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE54_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE54_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE54}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE55_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE56_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE56_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE56}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE57_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE57_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE57}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE58_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE59_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE59_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE59}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE60_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE61_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE61_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE61}</span></td>
				  </tr>
				</table>
			</div>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			  <tr>
				<th class="thTop" width="8%" align="center">{L_SILK_STATUS}</th>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE62_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE62_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE62}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE63_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE63_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE63}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE64_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE64_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE64}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE65_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE66_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE66_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE66}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE67_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE67_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE67}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE68_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE68_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE68}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE69_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE70_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE70_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE70}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE71_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE71_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE71}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE72_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE73_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE73_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE73}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE74_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE74_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE74}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE75_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE76_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE76_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE76}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE77_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE77_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE77}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE78_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE79_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE79_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE79}</span></td>
				  </tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
				  <tr>
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE80_STATUS}</span></td>
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
				    <td class="row1" width="8%" align="center"><span class="gen">{FORCE81_STATUS}</span></td>
					<td class="row1" align="right" width="46%">{FORCE81_IMG}</td>
				    <td class="row1" align="left" width="46%"><span class="gen">{L_FORCE81}</span></td>
				  </tr>
				</table>
			</div>
		</div>

	</tr>
</table>