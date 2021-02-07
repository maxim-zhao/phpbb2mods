function _hideBBCode() 
{ 
   this.objs = []; 
   return this; 
} 
_hideBBCode.prototype.IsDisplaySupported = function() 
{ 
   // Opera: Only v7+ supports write access to display attribute ! 
   if( window.opera && !document.childNodes ) return false; 
   // Other DOM browsers and MSIE4+ support it as well. 
   if( document.getElementById || document.all ) return true; 
   // This is where legacy browsers fall. NS4, Hotjava, etc. 
   return false; 
} 
_hideBBCode.prototype.getObj = function(obj) 
{ 
   return ( document.getElementById ? document.getElementById(obj) : 
         ( document.all ? document.all[obj] : 
         ( document.layers ? document.layers[obj] : null ) ) ); 
} 
_hideBBCode.prototype.displayObj = function(obj, status) 
{ 
   var x = this.getObj(obj); 
   if(!x) return; 
   var css = ( document.layers ? x : x.style ); 
   if( this.IsDisplaySupported() ) 
   { 
      css.display = status; 
   } 
   else 
   { 
      css.visibility = ( status == 'none' ? 'hidden' : 'visible' ); 
   } 
} 
_hideBBCode.prototype.open = function(l_hide) 
{ 
   var s='', randomId = 'hide' + Math.floor(Math.random() * 15000); 
   var style = ( this.IsDisplaySupported() ? 'display:none;' : 'visibility:hidden;' ); 
   if( document.layers ) { style = 'position:relative;' + style; } 
   s += '<div><a class="postlink" href="javascript:hideBBCode.showHide(\'' + randomId + '\');" onmouseover="top.status=\'\';" onfocus="this.blur();">' + l_hide + '</a></div>'; 
   s += '<div id="' + randomId + '" style="'+style+'">'; 
   document.write(s); 
   this.objs[randomId] = 'none'; 
} 
_hideBBCode.prototype.close = function() 
{ 
   document.write('</div>'); 
} 
_hideBBCode.prototype.showHide = function(obj) 
{ 
   if( !this.objs[obj] ) return; 
   this.objs[obj] = ((this.objs[obj]=='none') ? 'block':'none'); 
   this.displayObj(obj, this.objs[obj]); 
} 
var hideBBCode = new _hideBBCode();