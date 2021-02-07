//
// KSA: Keep Session Alive!
//

function _KSA(session_length, spacer)
{
	this.interval = ( session_length > 120 ? (session_length - 30) : 30 ) * 1000;	// interval in milliseconds.
	this.spacer = spacer.replace(/&amp;/, '&');
}
_KSA.prototype.refresh = function()
{
	document.images['ksa_img'].src = this.spacer;
	setTimeout('KSA.refresh();', this.interval);
}
_KSA.prototype.run = function()
{
	if( document.images && document.images['ksa_img'] )
	{
		setTimeout('KSA.refresh();', this.interval);
	}
}

function doOnLoad_KSA()
{
	if( oldOnLoad_KSA )
	{
		oldOnLoad_KSA();
		oldOnLoad_KSA = null;
	}
	if( KSA ) KSA.run();
}
var	oldOnLoad_KSA = window.onload;
window.onload = doOnLoad_KSA;
