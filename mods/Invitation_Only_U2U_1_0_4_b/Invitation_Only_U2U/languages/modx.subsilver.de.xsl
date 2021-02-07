<?xml version="1.0" encoding="UTF-8" ?>
<!-- MODX by the phpBB MOD Team XSL file v1.0 copyright 2005-2006 the phpBB MOD Team. 
	$Id: modx.subsilver.de.xsl,v 1.1 2006/07/09 16:46:08 hsudhof Exp $ -->
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
				<meta http-equiv="Content-Language" content="de-DE" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<style>

/* Style for a "Recommendation" */

/*
   Copyright 1997-2003 W3C (MIT, ERCIM, Keio). All Rights Reserved.
   The following software licensing rules apply:
   http://www.w3.org/Consortium/Legal/copyright-software */

/* $Id: modx.subsilver.de.xsl,v 1.1 2006/07/09 16:46:08 hsudhof Exp $ */

/* Updated by Jon Stanley for use in phpBB XML MOD */

/* Updated by David Smith to look subSilvery for phpBB */

html, body {
  font-family: Verdana, Arial, Helvetica, sans-serif;
  color: black;
  background: #E5E5E5;
  background-position: top left;
  background-attachment: fixed;
  background-repeat: no-repeat;
  }
:link { color : #006699; background: transparent }
:visited { color : #006699; background: transparent }
a:active { color : #006699; background: transparent }
a:hover { text-decoration: underline; color : #DD6900; }

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
h1, h2, h3 { color: #006699 }
h1 { font: 170% sans-serif }
h2 { font: 140% sans-serif }
h3 { font: 120% sans-serif }
h4 { font: bold 100% sans-serif }
h5 { font: italic 100% sans-serif }
h6 { font: small-caps 100% sans-serif }

.hide { display: none }

div.head { margin-bottom: 1em }
div.head h1 { margin-top: 2em; clear: both }
div.head table { margin-left: 2em; margin-top: 2em }

p.copyright { font-size: small }
p.copyright small { font-size: small }

@media screen {  /* hide from IE3 */
a[href]:hover { background: #ffa }
}

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

div.editFile {border: 2px solid #333333; margin: 0em 0em 2em; padding: 1em 1em; background: #D1D7DC;}
div.editFile h2 { font-size: 170%; margin: 0.4em 0em; }
div.action { border: 2px solid #DD6900; padding: 1em; background: #DEE3E7; margin: 1em 0em; }
div.action p { font-weight: normal; margin-top: 0px; margin-bottom: 0px; font-size: 0.8em; }
div.action h3 { margin-top: 0px; margin-bottom: 0px; }
div.action pre { padding: 0.2em; background: #EFEFEF; border: 2px solid #006699; overflow: scroll; width: 95%; }
div.editFile pre { padding: 0.2em; background: #EFEFEF; border: 2px solid #006699; overflow: scroll; width: 95%; }

#pageBody { background-color: #FFFFFF; border: 1px #98AAB1 solid; padding: 1em 1em;}

hr	{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px;}

strong.red { color: red; }

</style>

<script type="text/javascript"><!--//--><![CDATA[//><!--
function select_text(id)
{
	var o = document.getElementById(id);
	if( !o ) return;
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
				<div id="pageBody">
					<div id="modInfo">
						<xsl:for-each select="mod:header">
							<xsl:call-template name="give-header"></xsl:call-template>
						</xsl:for-each>
						<div id="modInstructions">
							<xsl:for-each select="mod:action-group">
								<xsl:call-template name="give-actions"></xsl:call-template>
							</xsl:for-each>
						</div>
						<hr />
						<div class="endMOD">
							<h1>Alle Dateien abspeichern. Ende der MOD.</h1>
							<p>Du hast die Installation der Mod abgeschlossen. Lade alle veränderten Dateien auf Deine Website hoch. Sollte etwas schiefgegangen sein, so verwende Deine Backups zur Wiederherstellung.</p>
						</div>
					</div>
				</div>
				<p class="copyright" style="text-align: center; font-size: 10px;">MOD UA XSLT File Copyright &#169; 2006 The phpBB Group, this MOD is copyright to the author<xsl:if test="count(author) > 1">s</xsl:if> listed above.</p>
			</body>
		</html>
	</xsl:template>
	<xsl:template name="give-header">
		<h1>Installationsanleitung für '<xsl:value-of select="$title" />' Version <xsl:value-of select="$version" /></h1>
		<h2>Über diese Mod</h2>
		<dl>
			<dt>Titel:</dt>
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
			<dt>Beschreibung:</dt>
			<dd>
				<xsl:if test="count(mod:description) > 1">
					<dl id="description">
						<xsl:for-each select="mod:description[@lang='de-DE']">
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
		<h2>Zu verändernde Dateien</h2>
		<xsl:for-each select="../mod:action-group">
			<xsl:call-template name="give-files-to-edit"></xsl:call-template>
		</xsl:for-each>
		<h2>Mitgelieferte Dateien</h2>
		<xsl:if test="count(../mod:action-group/mod:copy/mod:file) = 0">
			<p>Diese Mod enthält keine Dateien.</p>
		</xsl:if>
		<xsl:for-each select="../mod:action-group">
			<xsl:call-template name="give-files-included"></xsl:call-template>
		</xsl:for-each>
		<hr />
		<div id="modDisclaimer">
			<h1>Disclaimer</h1>
			<p>Aus Sicherheitsgründen auf  <a href="http://www.phpbb.com/mods/">http://www.phpbb.com/mods/</a> nach neueren Versionen dieser Mod suchen. Von anderen Quellen heruntergeladene Mods können bösartige Programme enthalten. phpBB.com bietet nur Unterstützung für Mods aus der Datenbank von: <a href="http://www.phpbb.com/mods/">http://www.phpbb.com/mods/</a></p>
			<h2>Hinweise des Autors</h2>
			<xsl:if test="count(mod:author-notes) > 1">
				<dl id="author-notes">
					<xsl:for-each select="mod:author-notes[@lang='de-DE']">
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
			<h3>Lizenz</h3>
			<p>Diese Mod steht unter der folgenden Lizenz:</p>
			<p style='white-space:pre;'>
				<xsl:value-of select="mod:license" />
			</p>
			<h3>Weitere Hinweise</h3>
			<p>Vor der Installation der Mod, bitte alle Dateien sichern.</p>
			<p>Diese Mod wurde für phpBB<xsl:value-of select="mod:installation/mod:target-version/mod:target-primary" /> entworfen und funktioniert eventuell nicht mit anderen Versionen. MODs für phpBB3.0 funktionieren <strong>keinesfalls</strong> mit phpBB2.0 und umgekehrt.</p>
			<xsl:if test="./mod:mod-version/mod:minor mod 2 != 0 or ./mod:mod-version/mod:major = 0">
				<p>
					<strong class="red">Diese Mod ist noch in der Entwicklung. Es wird davon abgeraten sie einzusetzen.</strong>
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
			<dt>Echter Name:</dt>
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
		<dt>Schwierigkeitsgrad der Installation:</dt>
		<dd>
			<xsl:if test="mod:level='easy'">Einfach</xsl:if>
			<xsl:if test="mod:level='intermediate'">Mittel</xsl:if>
			<xsl:if test="mod:level='advanced'">Schwer</xsl:if>
		</dd>
		<dt>Zeitaufwand der Installation:</dt>
		<dd>~<xsl:value-of select="floor(mod:time div 60)" /> Minuten</dd>
	</xsl:template>
	<xsl:template name="give-mod-history">
		<xsl:if test="count(mod:entry)>1">
			<h2>MOD Versionsgeschichte:</h2>
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
				<xsl:for-each select="mod:changelog[@lang='de-DE']">
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
			<h1>Dateien kopieren</h1>
		</xsl:if>
		<xsl:for-each select="mod:copy">
			<xsl:call-template name="give-filez"></xsl:call-template>
		</xsl:for-each>
		<h1>Edits</h1>
		<p>Auf den Aktionsnamen klicken, um den Code auszuwählen</p>
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
				<h2>DIY Anweisungen<xsl:if test="count(../mod:diy-instructions) > 1"> (<xsl:value-of select="@lang" />)</xsl:if></h2>
				<p>Dies sind Aktionen, die nicht automatisch durchgeführt werden können. Folge den Anweisungen sorgfältig.</p>
				<pre>
					<xsl:value-of select="current()" />
				</pre>
			</div>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="give-fileo">
		<div class="editFile">
			<h2>Öffnen: <xsl:value-of select="@src" /></h2>
			<xsl:for-each select="mod:edit">
				<div class="action">
					<xsl:for-each select="mod:find|mod:action|mod:inline-edit|mod:comment[@lang='de-DE']">
						<xsl:if test="name() = 'find'">
							<h3 onClick="select_text('{generate-id()}')">Finde</h3>
							<p><strong>Hinweis:</strong> Dies mag nur ein Teil einer Zeile sein.
<xsl:if test="@type = 'regex'">
									<br />
									<em>Diese "Finde" Anweisung enthält einen regulären Ausdruck (regular expressen). Hier klicken, um mehr zu lernen.</em>
								</xsl:if>
</p>
							<pre id="{generate-id()}">
								<xsl:value-of select="current()" />
							</pre>
						</xsl:if>
						<xsl:if test="name() = 'action'">
							<xsl:if test="@type = 'after-add'">
								<h3 onClick="select_text('{generate-id()}')">Einfügen, nach</h3>
								<p><strong>Hinweis:</strong> Füge diese Zeilen in einer neuen, leeren Zeile unter den gefunden Zeilen ein.</p>
							</xsl:if>
							<xsl:if test="@type = 'before-add'">
								<h3 onClick="select_text('{generate-id()}')">Einfügen, davor</h3>
								<p><strong>Hinweis:</strong> Füge diese Zeilen in einer neuen, leeren Zeile <strong>über</strong> den gefunden Zeilen ein.</p>
							</xsl:if>
							<xsl:if test="@type = 'replace-with'">
								<h3 onClick="select_text('{generate-id()}')">Ersetzen mit</h3>
								<p><strong>Hinweis:</strong> Ersetze die gefundenen Zeilen mit diesen.</p>
							</xsl:if>
							<xsl:if test="@type = 'operation'">
								<h3 onClick="select_text('{generate-id()}')">Erhöhen</h3>
								<p><strong>Hinweis:</strong> Ersetze die gefundenen Zeilen mit diesen.</p>
							</xsl:if>
							<pre id="{generate-id()}">
								<xsl:value-of select="current()" />
							</pre>
						</xsl:if>
						<xsl:if test="name() = 'comment'">
							<dl>
								<dt>Kommentar:<xsl:if test="count(../mod:comment) > 1"> (<xsl:value-of select="@lang" />)</xsl:if></dt>
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
										<h3 onClick="select_text('{generate-id()}')">In der Zeile finden</h3>
										<p><strong>Hinweis:</strong> Dies ist nur ein Teil der Zeile
<xsl:if test="@type = 'regex'">
												<br />
												<em>Diese "Finde" Anweisung enthält einen regulären Ausdruck (regular expressen). Hier klicken, um mehr zu lernen.</em>
											</xsl:if>
</p>
										<pre id="{generate-id()}">
											<xsl:value-of select="current()" />
										</pre>
									</xsl:if>
									<xsl:if test="name() = 'inline-action'">
										<xsl:if test="@type = 'after-add'">
											<h3 onClick="select_text('{generate-id()}')">In der Zeile einfügen, danach</h3>
										</xsl:if>
										<xsl:if test="@type = 'before-add'">
											<h3 onClick="select_text('{generate-id()}')">In der Zeile einfügen, davor</h3>
										</xsl:if>
										<xsl:if test="@type = 'replace-with'">
											<h3 onClick="select_text('{generate-id()}')">In der Zeile ersetzen</h3>
										</xsl:if>
										<xsl:if test="@type = 'operation'">
											<h3 onClick="select_text('{generate-id()}')">In der Zeile erhöhen</h3>
											<p><strong>Hinweis:</strong> Diese Anweisung wirkt sich auf Zahlen in dieser Zeile Aus. Hier klicken, um mehr zu erfahren.</p>
										</xsl:if>
										<pre id="{generate-id()}">
											<xsl:value-of select="current()" />
										</pre>
									</xsl:if>
									<xsl:if test="name() = 'inline-comment'">
										<p>
											<strong>Kommentar:</strong>
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
				<dt>Kopiere: <xsl:value-of select="@from" /></dt>
				<dd>Nach: <xsl:value-of select="@to" /></dd>
			</xsl:for-each>
		</dl>
	</xsl:template>
	<xsl:template name="give-sub-action-find">
		<p>Finde</p>
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
		<p>In der Zeile finden</p>
		<pre>
			<xsl:value-of select="find-string-in-line" />
		</pre>
	</xsl:template>
	<xsl:template name="give-sub-action-edit">
		<xsl:if test="@action = 'replace'">
			<p>Ersetzen</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'after'">
			<p>danach Einfügen</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'before'">
			<p>davor Einfügen</p>
		</xsl:if>
		<pre>
			<xsl:value-of select="current()" />
		</pre>
	</xsl:template>
	<xsl:template name="give-sub-action-in-line-edit">
		<xsl:if test="@action = 'replace'">
			<p>In der Zeile, ersetzen</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'after'">
			<p>In der Zeile, danach einfügen</p>
		</xsl:if>
		<xsl:if test="@action = 'add' and @where = 'before'">
			<p>In der Zeile, davor einfügen</p>
		</xsl:if>
		<xsl:if test="@action = 'operation'">
			<p>In der Zeile eine mathematische Operation durchführen.</p>
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