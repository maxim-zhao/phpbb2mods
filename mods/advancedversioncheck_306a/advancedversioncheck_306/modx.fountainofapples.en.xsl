<?xml version="1.0" encoding="UTF-8" ?>
<!-- MODX by the phpBB MOD Team XSL file v1.0 copyright 2005-2006 the phpBB MOD Team. 
	Fountain of Apples phpBB MODs XSL file v1.0 Copyright 2006 Douglas Bell. -->
<!DOCTYPE xsl:stylesheet[
	<!ENTITY nbsp "&#160;">
]>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:mod="http://www.phpbb.com/mods/xml/modx-1.0.xsd">
	<xsl:output method="html" omit-xml-declaration="no" indent="yes" />
<xsl:variable name="title" select="mod:mod/mod:header/mod:title" />
<xsl:variable name="version">
<xsl:for-each select="mod:mod/mod:header/mod:mod-version">
	<xsl:call-template name="give-version">
		</xsl:call-template>
	</xsl:for-each>
</xsl:variable>
	<xsl:template match="mod:mod">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Language" content="en-GB" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<style>

/* Style for a "Recommendation" */

/*
   Copyright 1997-2003 W3C (MIT, ERCIM, Keio). All Rights Reserved.
   The following software licensing rules apply:
   http://www.w3.org/Consortium/Legal/copyright-software */

/* Updated by Jon Stanley for use in phpBB XML MOD */

/* Updated by David Smith to look subSilvery for phpBB */

html, body {
  font-family: Verdana, Arial, Helvetica, sans-serif;
  color: black;
  background: white url("xsl/background.png");
  background-position: center;
  background-attachment: fixed;
  background-repeat: no-repeat;
 }
:link { color : #006699; background: transparent }
:visited { color : #006699; background: transparent }
a:active { color : #006699; background: transparent }

a:link img, a:visited img { border-style: none } /* no border on img links */

a img { color: white; }        /* trick to hide the border in Netscape 4 */
@media all {                   /* hide the next rule from Netscape 4 */
  a img { color: inherit; }    /* undo the color change above */
}

th, td { /* ns 4 */
  font-family: sans-serif;
}

h1, h2, h3, h4, h5, h6 { text-align: left }
/* background should be transparent, but WebTV has a bug */
h1, h2, h3 { color: #000000 }
h1 { font: bold 170% Verdana, sans-serif }
h2 { font: bold 140% Verdana, sans-serif }
h3 { font: bold 120% Verdana, sans-serif }
h4 { font: bold 100% Verdana, sans-serif }
h5 { font: italic 100% Verdana, sans-serif }
h6 { font: small-caps 100% Verdana, sans-serif }

.hide { display: none }

div.head { margin-bottom: 1em }
div.head h1 { margin-top: 2em; clear: both }
div.head table { margin-left: 2em; margin-top: 2em }

p.copyright { font-size: small }
p.copyright small { font-size: small }

pre { margin-left: 2em }
/*
p {
  margin-top: 0.6em;
  margin-bottom: 0.6em;
}
*/
dt, dd { margin-top: 0; margin-bottom: 0 } /* opera 3.50 */
dt { font-weight: bold }

pre, code { font-family: monospace } /* navigator 4 requires this */

ul.toc {
  list-style: disc;		/* Mac NS has problem with 'none' */
  list-style: none;
}

@media aural {  
  h1, h2, h3 { stress: 20; richness: 90 }
  .hide { speak: none }
  p.copyright { volume: x-soft; speech-rate: x-fast }
  dt { pause-before: 20% }
  pre { speak-punctuation: code } 
}

/* Additional styles */

/*
div.editFile {border: 2px solid #333333; margin: 0em 0em 2em; padding: 1em 1em; background: #D1D7DC;}
div.editFile h2 { font-size: 170%; margin: 0.4em 0em; }
div.action { border: 2px solid #DD6900; padding: 1em; background: #DEE3E7; margin: 1em 0em; }
div.action p { font-weight: normal; margin-top: 0px; margin-bottom: 0px; font-size: 0.8em; }
div.action h3 { margin-top: 0px; margin-bottom: 0px; }
div.action pre { padding: 0.2em; background: #EFEFEF; border: 2px solid #006699; overflow: scroll; width: 95%; }
div.editFile pre { padding: 0.2em; background: #EFEFEF; border: 2px solid #006699; overflow: scroll; width: 95%; } */

div.editFile {border: 2px solid #333333; margin: 0em 0em 2em; padding: 1em 1em;}
div.editFile h2 { font-size: 170%; margin: 0.4em 0em; }
div.action { border: 2px solid #DD6900; padding: 1em; margin: 1em 0em; }
div.action p { font-weight: normal; margin-top: 0px; margin-bottom: 0px; font-size: 0.8em; }
div.action h3 { margin-top: 0px; margin-bottom: 0px; }
div.action pre { padding: 0.2em; background: #FFFFFF; border: 2px solid #006699; overflow: scroll; width: 95%; }
div.editFile pre { padding: 0.2em; background: #FFFFFF; border: 2px solid #006699; overflow: scroll; width: 95%; }

strong.red { color: red; }

/* Styles for the Navigation section */
#header_links {
font-family: Arial, Verdana, Sans-Serif;
font-size: 18px;
text-align: center;
}

#header_links a {
color: #006699;
font-weight: bold;
}

#header_links a:hover {
color: #000099;
font-weight: bold;
}

</style>

<script type="text/javascript"><!--//--><![CDATA[//><!--
function SXBB_IsIEMac()
{
	// Any better way to detect IEMac?
	var ua = String(navigator.userAgent).toLowerCase();
	if( document.all && ua.indexOf("mac") >= 0 )
	{
		return true;
	}
	return false;
}

function select_text(id)
{
	var o = document.getElementById(id);
	if( !o )
	{
		return;
	}
	var r, s;
	if( document.selection && !SXBB_IsIEMac() )
	{
		// Works on: IE5+
		// To be confirmed: IE4? / IEMac fails?
		r = document.body.createTextRange();
		r.moveToElementText(o);
		r.select();
	}
	else if( document.createRange && (document.getSelection || window.getSelection) )
	{
		// Works on: Netscape/Mozilla/Konqueror/Safari
		// To be confirmed: Konqueror/Safari use window.getSelection ?
		r = document.createRange();
		r.selectNodeContents(o);
		s = window.getSelection ? window.getSelection() : document.getSelection();
		s.removeAllRanges();
		s.addRange(r);
	}
}
//--><!]]></script>
				<title>phpBB MOD &#187; <xsl:value-of select="$title" /></title>
			</head>
			<body>
				<div id="modInfo">
					<xsl:for-each select="mod:header">
						<xsl:call-template name="give-header"></xsl:call-template>
					</xsl:for-each>
					<div id="modInstructions">
						<xsl:for-each select="mod:action-group">
							<xsl:call-template name="give-actions"></xsl:call-template>
						</xsl:for-each>
					</div>
					<div class="endMOD">
						<h1>Save all files. End of MOD.</h1>
						<p>You have finished the installation for this MOD. Upload all changed files to your website. If the installation went bad, simply restore your backed up files.</p>
					</div>
				</div>
				<hr />
				<p style="font-size: 12px">MOD UA XSLT File Copyright &#169; 2006 The phpBB Group.</p>
				<p style="font-size: 12px">The MODX XSLT Fountain of Apples Edition is Copyright &#169; 2006 Douglas Bell.</p>
				<p style="font-size: 12px">Advanced Version Check is Copyright &#169; 2005-2006 Douglas Bell, released under the <a href="docs/LICENSE.txt">GNU General Public License</a> (<a href="http://www.gnu.org/copyleft/gpl.html">alternate link</a>), either version 2 or (at your option) any later version. If borrowing code from this MOD, please retain its copyright information.</p>
				<p style="font-size: 12px">The Fountain of Apples phpBB MODs website and logo are Copyright &#169; 2006 Douglas Bell. Apple, the Apple logo, and Mac are trademarks of Apple Computer, Inc., registered in the U.S. and other countries. The Made on a Mac Badge is a trademark of Apple Computer, Inc., used with permission. The MODX logo is an trade mark of the phpBB MOD Team and is Copyright &#169; 2006 the phpBB MOD Team.</p>
				<div style="text-align: center"><a href="http://www.phpbb.com"><img src="xsl/phpBB.gif" alt="phpBB community" style="border: 0" /></a>&nbsp; &nbsp;<a href="http://www.apple.com"><img src="xsl/madeonamac.gif" alt="Made on a Mac" style="width: 88px; height: 31px; border:0" /></a>&nbsp; &nbsp;<a href="http://www.phpbb.com/mods/modx/"><img src="xsl/modx_badge.png" alt="MODX" style="border:0" /></a></div>
			</body>
		</html>
	</xsl:template>
	<xsl:template name="give-header">
		<a href="http://foamods.sourceforge.net"><img src="xsl/modslogo.png" alt="Fountain of Apples phpBB MODs" style="border:0" /></a>
		<hr />
		<h1>Advanced Version Check Version <xsl:value-of select="$version" /> Installation</h1>
		<h2>About this MOD</h2>
		<dl>
			<dt>Title:</dt>
			<dd>
				<xsl:if test="count(mod:title) > 1">
					<dl id="title">
						<xsl:for-each select="mod:title">
							<dl id="{generate-id()}">
								<dt>
									<xsl:value-of select="@lang" />
								</dt>
								<dd style='white-space:pre;'>
									<xsl:value-of select="current()" />
								</dd>
							</dl>
						</xsl:for-each>
					</dl>
				</xsl:if>
				<xsl:if test="count(mod:title) = 1">
					<xsl:value-of select="mod:title" />
				</xsl:if>
			</dd>
			<dt>Description:</dt>
			<dd>
				<xsl:if test="count(mod:description) > 1">
					<dl id="description">
						<xsl:for-each select="mod:description">
							<dl id="{generate-id()}">
								<dt>
									<xsl:value-of select="@lang" />
								</dt>
								<dd>
									<xsl:call-template name="add-line-breaks">
										<xsl:with-param name="string">
											<xsl:value-of select="current()" />
										</xsl:with-param>
									</xsl:call-template>
								</dd>
							</dl>
						</xsl:for-each>
					</dl>
				</xsl:if>
				<xsl:if test="count(mod:description) = 1">
					<xsl:call-template name="add-line-breaks">
						<xsl:with-param name="string">
							<xsl:value-of select="mod:description" />
						</xsl:with-param>
					</xsl:call-template>
				</xsl:if>
			</dd>
			<dt>Version:</dt>
			<dd>
				<xsl:for-each select="mod:mod-version">
					<xsl:call-template name="give-version"></xsl:call-template>
				</xsl:for-each>
			</dd>
			<xsl:for-each select="mod:installation">
				<xsl:call-template name="give-installation"></xsl:call-template>
			</xsl:for-each>
		</dl>
		<xsl:for-each select="mod:author-group">
			<h2>Author<xsl:if test="count(mod:author) > 1">s</xsl:if></h2>
			<xsl:call-template name="give-authors"></xsl:call-template>
		</xsl:for-each>
		<h2>Files To Edit</h2>
		<xsl:for-each select="../mod:action-group">
			<xsl:call-template name="give-files-to-edit"></xsl:call-template>
		</xsl:for-each>
		<h2>Included Files</h2>
		<xsl:if test="count(../mod:action-group/mod:copy/mod:file) = 0">
			<p>No files have been included with this MOD.</p>
		</xsl:if>
		<xsl:for-each select="../mod:action-group">
			<xsl:call-template name="give-files-included"></xsl:call-template>
		</xsl:for-each>
		<hr />
		<div id="modDisclaimer">
			<h1>Disclaimer</h1>
			<p>For security purposes, please check: <a href="http://www.phpbb.com/mods/">http://www.phpbb.com/mods/</a> for the latest version of this MOD. Although MODs are checked before being allowed in the MODs Database there is no guarantee that there are no security problems within the MOD. No support will be given for MODs not found within the MODs Database which can be found at <a href="http://www.phpbb.com/mods/">http://www.phpbb.com/mods/</a></p>
			<h2>Author Notes</h2>
			<xsl:if test="count(mod:author-notes) > 1">
				<dl id="author-notes">
					<xsl:for-each select="mod:author-notes">
						<dl id="{generate-id()}">
							<dt>
								<xsl:value-of select="@lang" />
							</dt>
							<dd>
								<xsl:call-template name="add-line-breaks">
									<xsl:with-param name="string">
										<xsl:value-of select="current()" />
									</xsl:with-param>
								</xsl:call-template>
							</dd>
						</dl>
					</xsl:for-each>
				</dl>
			</xsl:if>
			<xsl:if test="count(mod:author-notes) = 1">
				<xsl:call-template name="add-line-breaks">
					<xsl:with-param name="string">
						<xsl:value-of select="mod:author-notes" />
					</xsl:with-param>
				</xsl:call-template>
			</xsl:if>
			<xsl:for-each select="mod:history">
				<xsl:call-template name="give-mod-history"></xsl:call-template>
			</xsl:for-each>
			<h3>License</h3>
			<p>This MOD has been licensed under the following license:</p>
			<p style='white-space:pre;'>
				<xsl:value-of select="mod:license" />
			</p>
			<h3>Other Notes</h3>
			<p>Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD</p>
			<p>This MOD was designed for phpBB<xsl:value-of select="mod:installation/mod:target-version/mod:target-primary" /> and may not function as stated on other phpBB versions. MODs for phpBB3.0 will <strong>not</strong> work on phpBB2.0 and vice versa.</p>
			<xsl:if test="./mod:mod-version/mod:minor mod 2 != 0 or ./mod:mod-version/mod:major = 0">
				<p>
					<strong class="red">This MOD is development quality. It is not recommended that you install it on a live forum.</strong>
				</p>
			</xsl:if>
		</div>
		<hr />
	</xsl:template>
	<xsl:template name="give-authors">
		<xsl:for-each select="mod:author">
			<xsl:call-template name="give-author"></xsl:call-template>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="give-author">
		<dl>
			<dt>Username:</dt>
			<dd>
				<a href="http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&amp;u={mod:username}">
					<xsl:value-of select="mod:username" />
				</a>
			</dd>
			<xsl:if test="mod:email != 'N/A' and mod:email != 'n/a' and mod:email != ''">
				<dt>Email:</dt>
				<dd>
					<a href="mailto:{mod:email}">
						<xsl:value-of select="mod:email" />
					</a>
				</dd>
			</xsl:if>
			<dt>Realname:</dt>
			<dd>
				<xsl:value-of select="mod:realname" />
			</dd>
			<xsl:if test="mod:homepage != 'N/A' and mod:homepage != 'n/a' and mod:homepage!=''">
				<dt>WWW:</dt>
				<dd>
					<a href="{mod:homepage}">
						<xsl:value-of select="mod:homepage" />
					</a>
				</dd>
			</xsl:if>
		</dl>
		<br />
	</xsl:template>
	<xsl:template name="give-version"><xsl:value-of select="concat(mod:major, '.', mod:minor, '.', mod:revision, mod:release)" /></xsl:template>
	<xsl:template name="give-installation">
		<dt>Installation Level:</dt>
		<dd>
			<xsl:if test="mod:level='easy'">Easy</xsl:if>
			<xsl:if test="mod:level='moderate'">Moderate</xsl:if>
			<xsl:if test="mod:level='hard'">Hard</xsl:if>
		</dd>
		<dt>Installation Time:</dt>
		<dd>~<xsl:value-of select="floor(mod:time div 60)" /> minutes</dd>
	</xsl:template>
	<xsl:template name="give-mod-history">
		<xsl:if test="count(mod:entry)>1">
			<h2>MOD History</h2>
			<dl>
				<xsl:for-each select="mod:entry">
					<xsl:call-template name="give-history-entry"></xsl:call-template>
				</xsl:for-each>
			</dl>
		</xsl:if>
	</xsl:template>
	<xsl:template name="give-history-entry">
		<dt><xsl:value-of select="substring(mod:date,1,10)" /> - Version 
			<xsl:for-each select="mod:rev-version">
					<xsl:call-template name="give-version"></xsl:call-template>
				</xsl:for-each></dt>
		<dd>
			<xsl:if test="count(mod:changelog) > 1">
				<xsl:for-each select="mod:changelog">
					<xsl:call-template name="give-history-entry-changelog"></xsl:call-template>
				</xsl:for-each>
			</xsl:if>
			<xsl:if test="count(mod:changelog) = 1">
				<xsl:for-each select="mod:changelog">
					<xsl:call-template name="give-history-entry-changelog-single"></xsl:call-template>
				</xsl:for-each>
			</xsl:if>
		</dd>
	</xsl:template>
	<xsl:template name="give-history-entry-changelog">
		<dl>
			<dt>
				<xsl:value-of select="@lang" />
			</dt>
			<dd>
				<ul>
					<xsl:for-each select="mod:change">
						<li>
							<xsl:value-of select="current()" />
						</li>
					</xsl:for-each>
				</ul>
			</dd>
		</dl>
	</xsl:template>
	<xsl:template name="give-history-entry-changelog-single">
		<ul>
			<xsl:for-each select="mod:change">
				<li>
					<xsl:value-of select="current()" />
				</li>
			</xsl:for-each>
		</ul>
	</xsl:template>
	<xsl:template name="give-files-to-edit">
		<ul>
			<xsl:for-each select="mod:open">
				<xsl:call-template name="give-file"></xsl:call-template>
			</xsl:for-each>
		</ul>
	</xsl:template>
	<xsl:template name="give-files-included">
		<ul>
			<xsl:for-each select="mod:copy">
				<xsl:call-template name="give-file-copy"></xsl:call-template>
			</xsl:for-each>
		</ul>
	</xsl:template>
	<xsl:template name="give-file">
		<li>
			<xsl:value-of select="@src" />
			<xsl:if test="position()!=last()">,</xsl:if>
		</li>
	</xsl:template>
	<xsl:template name="give-file-copy">
		<xsl:for-each select="mod:file">
			<li>
				<xsl:value-of select="@from" />
				<xsl:if test="position()!=last()">,</xsl:if>
			</li>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="give-actions">
		<xsl:if test="count(mod:sql) > 0">
			<h1>SQL</h1>
		</xsl:if>
		<xsl:for-each select="mod:sql">
			<xsl:call-template name="give-sql"></xsl:call-template>
		</xsl:for-each>
		<xsl:if test="count(mod:copy) > 0">
			<h1>File Copy</h1>
		</xsl:if>
		<xsl:for-each select="mod:copy">
			<xsl:call-template name="give-filez"></xsl:call-template>
		</xsl:for-each>
		<h1>Edits</h1>
		<p>Click on the action name to select the code</p>
		<xsl:for-each select="mod:open">
			<xsl:call-template name="give-fileo"></xsl:call-template>
		</xsl:for-each>
		<xsl:call-template name="give-manual"></xsl:call-template>
	</xsl:template>
	<xsl:template name="give-sql">
		<div class="action">
			<pre>
				<xsl:value-of select="current()" />
			</pre>
		</div>
	</xsl:template>
	<xsl:template name="give-manual">
		<xsl:for-each select="mod:diy-instructions">
			<div class="editFile">
				<h2>DIY Instructions<xsl:if test="count(../mod:diy-instructions) > 1"> (<xsl:value-of select="@lang" />)</xsl:if></h2>
				<p>These are manual instructions that cannot be performed automatically. You should follow these instructions carefully.</p>
				<pre>
					<xsl:value-of select="current()" />
				</pre>
			</div>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="give-fileo">
		<div class="editFile">
			<h2>Open: <xsl:value-of select="@src" /></h2>
			<xsl:for-each select="mod:edit">
				<div class="action">
					<xsl:for-each select="mod:find|mod:action|mod:inline-edit|mod:comment">
						<xsl:if test="name() = 'find'">
							<h3 onClick="select_text('{generate-id()}')">Find</h3>
							<p><strong>Tip:</strong> This may be a partial find and not the whole line.
<xsl:if test="@type = 'regex'">
									<br />
									<em>This find contains an advanced feature known as regular expressions, click here to learn more.</em>
								</xsl:if>
</p>
							<pre id="{generate-id()}">
								<xsl:value-of select="current()" />
							</pre>
						</xsl:if>
						<xsl:if test="name() = 'action'">
							<xsl:if test="@type = 'after-add'">
								<h3 onClick="select_text('{generate-id()}')">Add after</h3>
								<p><strong>Tip:</strong> Add these lines on a new blank line after the preceding line(s) to find.</p>
							</xsl:if>
							<xsl:if test="@type = 'before-add'">
								<h3 onClick="select_text('{generate-id()}')">Add before</h3>
								<p><strong>Tip:</strong> Add these lines on a new blank line before the preceding line(s) to find.</p>
							</xsl:if>
							<xsl:if test="@type = 'replace-with'">
								<h3 onClick="select_text('{generate-id()}')">Replace With</h3>
								<p><strong>Tip:</strong> Replace the preceding line(s) to find with the following lines.</p>
							</xsl:if>
							<xsl:if test="@type = 'operation'">
								<h3 onClick="select_text('{generate-id()}')">Increment</h3>
								<p><strong>Tip:</strong> Replace the preceding line(s) to find with the following lines.</p>
							</xsl:if>
							<pre id="{generate-id()}">
								<xsl:value-of select="current()" />
							</pre>
						</xsl:if>
						<xsl:if test="name() = 'comment'">
							<dl>
								<dt>Comment:<xsl:if test="count(../mod:comment) > 1"> (<xsl:value-of select="@lang" />)</xsl:if></dt>
								<dd>
									<xsl:call-template name="add-line-breaks">
										<xsl:with-param name="string">
											<xsl:value-of select="current()" />
										</xsl:with-param>
									</xsl:call-template>
								</dd>
							</dl>
						</xsl:if>
						<xsl:if test="name() = 'inline-edit'">
							<div class="action">
								<xsl:for-each select="mod:inline-find|mod:inline-action|mod:inline-comment">
									<xsl:if test="name() = 'inline-find'">
										<h3 onClick="select_text('{generate-id()}')">In-line Find</h3>
										<p><strong>Tip:</strong> This is a partial match of a line for in-line operations.
<xsl:if test="@type = 'regex'">
												<br />
												<em>This find contains an advanced feature known as regular expressions, click here to learn more.</em>
											</xsl:if>
</p>
										<pre id="{generate-id()}">
											<xsl:value-of select="current()" />
										</pre>
									</xsl:if>
									<xsl:if test="name() = 'inline-action'">
										<xsl:if test="@type = 'after-add'">
											<h3 onClick="select_text('{generate-id()}')">In-line Add after</h3>
										</xsl:if>
										<xsl:if test="@type = 'before-add'">
											<h3 onClick="select_text('{generate-id()}')">In-line Add before</h3>
										</xsl:if>
										<xsl:if test="@type = 'replace-with'">
											<h3 onClick="select_text('{generate-id()}')">In-line Replace With</h3>
										</xsl:if>
										<xsl:if test="@type = 'operation'">
											<h3 onClick="select_text('{generate-id()}')">In-line Increment</h3>
											<p><strong>Tip:</strong> This allows you to alter integers. For help on what each operator means, click here.</p>
										</xsl:if>
										<pre id="{generate-id()}">
											<xsl:value-of select="current()" />
										</pre>
									</xsl:if>
									<xsl:if test="name() = 'inline-comment'">
										<p>
											<strong>Comment:</strong>
											<em>
												<xsl:value-of select="current()" />
											</em>
										</p>
									</xsl:if>
								</xsl:for-each>
							</div>
						</xsl:if>
					</xsl:for-each>
				</div>
			</xsl:for-each>
		</div>
	</xsl:template>
	<xsl:template name="give-filez">
		<dl>
			<xsl:for-each select="mod:file">
				<dt>Copy: <xsl:value-of select="@from" /></dt>
				<dd>To: <xsl:value-of select="@to" /></dd>
			</xsl:for-each>
		</dl>
	</xsl:template>
	<xsl:template name="give-sub-action-find">
		<p>Find</p>
		<pre>
			<xsl:value-of select="find-string" />
		</pre>
		<xsl:if test="count(in-line) > 0">
			<div class="action">
				<xsl:for-each select="in-line">
					<xsl:for-each select="find-in-line|edit-in-line">
						<xsl:if test="name() = 'find-in-line'">
							<xsl:call-template name="give-sub-action-in-line-find"></xsl:call-template>
						</xsl:if>
						<xsl:if test="name() = 'edit-in-line'">
							<xsl:call-template name="give-sub-action-in-line-edit"></xsl:call-template>
						</xsl:if>
					</xsl:for-each>
				</xsl:for-each>
			</div>
		</xsl:if>
	</xsl:template>
	<xsl:template name="give-sub-action-in-line-find">
		<p>In-line, Find</p>
		<pre>
			<xsl:value-of select="find-string-in-line" />
		</pre>
	</xsl:template>
	<xsl:template name="give-sub-action-edit">
		<xsl:if test="@action = 'replace'">
			<p>Replace, Add</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'after'">
			<p>After, Add</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'before'">
			<p>Before, Add</p>
		</xsl:if>
		<pre>
			<xsl:value-of select="current()" />
		</pre>
	</xsl:template>
	<xsl:template name="give-sub-action-in-line-edit">
		<xsl:if test="@action = 'replace'">
			<p>In-line, Replace With</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'after'">
			<p>In-line, After, Add</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'before'">
			<p>In-line, Before, Add</p>
		</xsl:if>
		<xsl:if test="@action = 'operation'">
			<p>In-line, perform the following mathematical operation</p>
			<xsl:variable name="oper_body" select="@operation" />
			<pre>
				<xsl:value-of select="$oper_body" />
			</pre>
		</xsl:if>
		<pre>
			<xsl:value-of select="current()" />
		</pre>
	</xsl:template>
	<!-- add-line-breaks borrowed from http://www.stylusstudio.com/xsllist/200103/post40180.html -->
	<xsl:template name="add-line-breaks">
		<xsl:param name="string" select="." />
		<xsl:choose>
			<xsl:when test="contains($string, '&#xA;')">
				<xsl:value-of select="substring-before($string, '&#xA;')" />
				<br />
				<xsl:call-template name="add-line-breaks">
					<xsl:with-param name="string" select="substring-after($string, '&#xA;')" />
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$string" />
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>