<?php	
// edited by swizec to make compatible with ClB
// version 0.12.1
// edited yet again for phpBB2

// basic security
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

class Sajax
{

	// constructor
	function Sajax ( $debug, $request = 'GET' )
	{
		$this->sajax_debug_mode = $debug;
		$this->sajax_export_list = array();
		$this->sajax_request_type = $request;
		$this->sajax_remote_uri = '';
		$this->sajax_js_has_been_shown = 0;
		$this->export = array();
	}
	
	/*
	 * CODE
	 *
	 */ 
	 
	//
	// Initialize the Sajax library.
	//
	function sajax_init() {
	}
	
	//
	// Helper function to return the script's own URI. 
	// 
	function sajax_get_my_uri() {
		$uri = '';
		$uri= substr( strrchr( $HTTP_SERVER_VARS[ 'PHP_SELF' ], "/"), 1 );
		if ( count( $HTTP_GET_VARS ) != 0 )
		{
			$uri .= '?';
			foreach ( $HTTP_GET_VARS as $name => $val )
			{
				$uri .= $name . '=' . $val . '&';
			}
			$uri = substr( $uri, 0, -1 );
		}
		
		return $uri;
	}
	
	//
	// Helper function to return an eval()-usable representation
	// of an object in JavaScript.
	// 
	function sajax_get_js_repr($value) {
		$type = gettype($value);
		
		if ($type == "boolean" ||
			$type == "integer") {
			return "parseInt($value)";
		} 
		elseif ($type == "double") {
			return "parseFloat($value)";
		} 
		elseif ($type == "array" || $type == "object" ) {
			//
			// XXX Arrays with non-numeric indices are not
			// permitted according to ECMAScript, yet everyone
			// uses them.. We'll use an object.
			// 
			$s = "{ ";
			if ($type == "object") {
				$value = get_object_vars($value);
			} 
			foreach ($value as $k=>$v) {
				$esc_key = $this->sajax_esc($k);
				if (is_numeric($k)) 
					$s .= "$k: " . $this->sajax_get_js_repr($v) . ", ";
				else
					$s .= "\"$esc_key\": " . $this->sajax_get_js_repr($v) . ", ";
			}
			return substr($s, 0, -2) . " }";
		} 
		else {
			$esc_val = $this->sajax_esc($value);
			$s = "\"$esc_val\"";
			return $s;
		}
	}

	function sajax_handle_client_request() {		
		$mode = "";
		
		if (! empty($HTTP_GET_VARS["rs"])) 
			$mode = "get";
		
		if (!empty($HTTP_POST_VARS["rs"]))
			$mode = "post";
			
		if (empty($mode)) 
			return;

		$target = "";
		
		if ($mode == "get") {
			// Bust cache in the head
			header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
			header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			// always modified
			header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
			header ("Pragma: no-cache");                          // HTTP/1.0
			$func_name = $HTTP_GET_VARS["rs"];
			if (! empty($HTTP_GET_VARS["rsargs"])) {
				$args = explode( '{$$}', $HTTP_GET_VARS["rsargs"] );
			}else
				$args = array();
		}
		else {
			$func_name = $HTTP_POST_VARS["rs"];
			if (! empty($HTTP_POST_VARS["rsargs"])) 
				$args = explode( '{$$}', $HTTP_POST_VARS["rsargs"] );
			else
				$args = array();
		}
		
// 		$arr = get_defined_functions();
// 		print_R( $arr[ 'user' ] );
		if (! in_array($func_name, $this->sajax_export_list))
 			echo "-:$func_name not callable";
 		else {
			echo "+:";
			$result = call_user_func_array($func_name, $args);
			echo "var res = " . $this->sajax_get_js_repr($result) . "; res;";
		}
		exit;
	}
	
	function sajax_get_common_js() {		
		$t = strtoupper($this->sajax_request_type);
		if ($t != "" && $t != "GET" && $t != "POST") 
			return "// Invalid type: $t.. \n\n";
			
		$debug = $this->sajax_debug_mode ? "true" : "false";
		
		return '
		
		// remote scripting library
		// (c) copyright 2005 modernmethod, inc
		var sajax_debug_mode = ' . $debug . ';
		var sajax_request_type = "' . $t . '";
		var sajax_target_id = "";
		
		function sajax_debug(text) {
			if (sajax_debug_mode)
				alert("RSD: " + text)
		}
 		function sajax_init_object() {
 			sajax_debug("sajax_init_object() called..")
 			
 			var A;
			try {
				A=new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					A=new ActiveXObject("Microsoft.XMLHTTP");
				} catch (oc) {
					A=null;
				}
			}
			if(!A && typeof XMLHttpRequest != "undefined")
				A = new XMLHttpRequest();
			if (!A)
				sajax_debug("Could not create connection object.");
			return A;
		}
		function sajax_do_call(func_name, args) {
			var i, x, n;
			var uri;
			var post_data;
			var target_id;
			
			sajax_debug("in sajax_do_call().." + sajax_request_type + "/" + sajax_target_id);
			target_id = sajax_target_id;
			if (sajax_request_type == "") 
				sajax_request_type = "GET";
			
			uri = "' . $this->sajax_remote_uri . '";
			if (sajax_request_type == "GET") {
			
				if (uri.indexOf("?") == -1) 
					uri += "?rs=" + escape(func_name);
				else
					uri += "&rs=" + escape(func_name);
				uri += "&rst=" + escape(sajax_target_id);
				uri += "&rsrnd=" + new Date().getTime();
				
				arg = "";
				for ( i = 0; i < args.length; i++ ) {
					arg += \'{$$}\' + args[ i ];
				}
				arg = arg.substring( 4 );
				
				uri += "&rsargs=" + escape( arg );

				post_data = null;
			} 
			else if (sajax_request_type == "POST") {
				post_data = "rs=" + escape(func_name);
				post_data += "&rst=" + escape(sajax_target_id);
				post_data += "&rsrnd=" + new Date().getTime();
				
				uri += "&rsargs=" + escape( arg );
				
			}
			else {
				alert("Illegal request type: " + sajax_request_type);
			}
			
			x = sajax_init_object();
			x.open(sajax_request_type, uri, true);
			
			if (sajax_request_type == "POST") {
				x.setRequestHeader("Method", "POST " + uri + " HTTP/1.1");
				x.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			}
			
			x.onreadystatechange = function() {
				if (x.readyState != 4) 
					return;

				sajax_debug("received " + x.responseText);
				
				var status;
				var data;
				status = x.responseText.charAt(0);
				data = x.responseText.substring(2);
				if (status == "-") 
					alert("Error: " + data);
				else {
					if (target_id != "") 
						document.getElementById(target_id).innerHTML = eval(data);
					else
						args[args.length-1](eval(data));
				}
			}
			sajax_debug(func_name + " uri = " + uri + "/post = " + post_data);
			x.send(post_data);
			sajax_debug(func_name + " waiting..");
			delete x;
			return true;
		}';
	}
	
	// javascript escape a value
	function sajax_esc($val)
	{
		$val = str_replace("\\", "\\\\", $val);
		$val = str_replace("\r", "\\r", $val);
		$val = str_replace("\n", "\\n", $val);
		return str_replace('"', '\\"', $val);
	}

	function sajax_get_one_stub($func_name) {
		
		$html = '
		// wrapper for ' . $func_name . '
		
		function x_' . $func_name . '() {
			sajax_do_call("' . $func_name . '", arguments);
		}';
		return $html;
	}
	
	function sajax_export() {
		$this->sajax_export_list = $this->export;
	}
	
	function sajax_show_javascript()
	{
		echo $this->sajax_get_javascript();
	}
	
	function sajax_get_javascript()
	{
		$html = "";
		if (! $this->sajax_js_has_been_shown) {
			$html .= $this->sajax_get_common_js();
			$this->sajax_js_has_been_shown = 1;
		}
		foreach ($this->sajax_export_list as $func) {
			$html .= $this->sajax_get_one_stub($func);
		}
		return $html;
	}
	
	function add2export( $funcname, $args = '' )
	{
		if ( strpos( $funcname, '->' ) !== FALSE )
		{
			$func = explode( '->', $funcname );
			$class = $func[ 0 ];
			$funcname = $func[ count( $func )-1 ];
			$func = implode( '->', $func );
			$call = 'function ' . $funcname . '(' . $args . ') { $' . $class . ' = $GLOBALS[ strtolower( \'' . $class . '\' ) ]; return $'. $func . '(' . $args . '); }';
			eval ( $call );
		}
		
		$this->export[] = $funcname;
	}
}
?>
