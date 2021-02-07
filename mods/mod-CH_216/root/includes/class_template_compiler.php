<?php
//
//	file: includes/class_template_compiler.php
//	author: ptirhiik
//	begin: 16/01/2004
//	version: 1.6.4 - 11/05/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//
//	Nb. : this one is in its greatest part a simplified version of phpBB 2.1.x 
//	template engine, so credits for good things go to PsoTFX, and eventual bugs to me :).
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class tpl_compiler
{
	// Various counters and storage arrays
	var $block_names;
	var $block_else_level;
	var $block_nesting_level;

	function tpl_compiler()
	{
		$this->block_names = array();
		$this->block_else_level = array();
		$this->block_nesting_level = 0;
	}

	function compile($code)
	{
		global $config;

		// Remove any "loose" php ... we want to give admins the ability
		// to switch on/off PHP for a given template. Allowing unchecked
		// php is a no-no. There is a potential issue here in that non-php
		// content may be removed ... however designers should use entities 
		// if they wish to display < and >
		$match_php_tags = array('\\?php[\n\r\s\t]+', '[\\?%]=', '[\\?%][^\w]', 'script[\n\r\s\t]+language[\n\r\s\t]*=[\n\r\s\t]*[\'"]php[\'"]');
		$code = preg_replace('#<(' . implode('|', $match_php_tags) . ')#is', '&lt;$1', $code);

		// remove also tabulations
		$code = preg_replace("/([\n\r])([\s\t]*)/", '\1', $code);

		// Pull out all block/statement level elements and seperate plain text
		preg_match_all('#<!-- PHP -->(.*?)<!-- ENDPHP -->#s', $code, $matches);
		$php_blocks = $matches[1];
		$code = preg_replace('#<!-- PHP -->(.*?)<!-- ENDPHP -->#s', '<!-- PHP -->', $code);

		preg_match_all('#<!-- (.*?) (.*?)?[ ]?-->#s', $code, $blocks);
		$text_blocks = preg_split('#<!-- (.*?) (.*?)?[ ]?-->#s', $code);
		unset($code);
		for ( $i = 0; $i < count($text_blocks); $i++ )
		{
			$this->compile_var_tags($text_blocks[$i]);
		}

		$compile_blocks = array();
		$count_text_blocks = count($text_blocks);
		for ( $i = 0; $i < $count_text_blocks; $i++ )
		{
			$block = isset($blocks[1][$i]) ? $blocks[1][$i] :false;
			switch ( $block )
			{
				case 'BEGIN':
					$this->block_else_level[] = false;
					$compile_blocks[] = '<?php ' . $this->compile_tag_block($blocks[2][$i]) . ' ?>';
					break;

				case 'BEGINELSE':
					$this->block_else_level[ sizeof($this->block_else_level) - 1 ] = true;
					$compile_blocks[] = '<?php }}else{ ?>';
					break;

				case 'END':
					array_pop($this->block_names);
					$compile_blocks[] = '<?php ' . ((array_pop($this->block_else_level)) ? '}' : '}}') . ' ?>';
					break;

				case 'BEGINGLOBAL':
					$this->block_else_level[] = false;
					$compile_blocks[] = '<?php ' . $this->compile_tag_block($blocks[2][$i], true) . ' ?>';
					break;

				case 'BEGINELSEGLOBAL':
					$this->block_else_level[ sizeof($this->block_else_level) - 1 ] = true;
					$compile_blocks[] = '<?php }}else{ ?>';
					break;

				case 'ENDGLOBAL':
					$compile_blocks[] = '<?php ' . ((array_pop($this->block_else_level)) ? '}' : '}}') . ' ?>';
					break;

				case 'IF':
					$compile_blocks[] = '<?php ' . $this->compile_tag_if($blocks[2][$i], false) . ' ?>';
					break;

				case 'ELSE':
					$compile_blocks[] = '<?php }else{ ?>';
					break;

				case 'ELSEIF':
					$compile_blocks[] = '<?php ' . $this->compile_tag_if($blocks[2][$i], true) . ' ?>';
					break;

				case 'ENDIF':
					$compile_blocks[] = '<?php } ?>';
					break;

				case 'DEFINE':
					$compile_blocks[] = '<?php ' . $this->compile_tag_define($blocks[2][$i], true) . ' ?>';
					break;

				case 'UNDEFINE':
					$compile_blocks[] = '<?php ' . $this->compile_tag_define($blocks[2][$i], false) . ' ?>';
					break;

				case 'INCLUDE':
					$blocks[2][$i] = str_replace(array('(', ')'), array(', ', ''), $blocks[2][$i]);
					$compile_blocks[] = '<?php $this->_include(\'' . trim($blocks[2][$i]) . '\'); ?>';
					break;

				case 'INCLUDEPHP':
					$compile_blocks[] = '<?php @include(\'' . trim($blocks[2][$i]) . '\'); ?>';
					break;

				case 'PHP':
					$php_block = '';
					list(, $php_block) = @each($php_blocks);
					if ( !empty($php_blocks) )
					{
						$compile_blocks[] = '<?php ' . $php_block . ' ?>';
					}
					break;

				default:
					$compile_blocks[] = empty($blocks[0][$i]) ? '' : $this->compile_var_tags($blocks[0][$i]);
					break;
			}
		}

		$template_php = '';
		$count_text_blocks = count($text_blocks);
		for ( $i = 0; $i < $count_text_blocks; $i++ )
		{
			// remove orphean lines when appropriate
			$text_block[$i] = preg_replace("/^([\n\r]{2,})/", '', $text_blocks[$i]);
			$template_php .= (trim($text_blocks[$i]) == '' ? '' : $text_blocks[$i]) . trim($compile_blocks[$i]);
		}

		// There will be a number of occassions where we switch into and out of
		// PHP mode instantaneously. Rather than "burden" the parser with this
		// we'll strip out such occurences, minimising such switching
		// also remove orphean lines
		return str_replace(' ?><?php ', '', $template_php);
	}

	function compile_var_tags(&$text_blocks)
	{
		// change template varrefs into PHP varrefs
		$varrefs = array();

		// This one will handle varrefs WITH namespaces
		preg_match_all('#\{(([a-z0-9\-_]+?\.)+?)([a-z0-9\-_]+?)\}#is', $text_blocks, $varrefs);

		$count_varrefs_1 = count($varrefs[1]);
		for ($j = 0; $j < $count_varrefs_1; $j++)
		{
			$namespace = $varrefs[1][$j];
			$varname = $varrefs[3][$j];
			$new = $this->generate_block_varref($namespace, $varname);

			$text_blocks = str_replace($varrefs[0][$j], $new, $text_blocks);
		}

		// This will handle the remaining root-level varrefs
		$varref = '$d[\'.\'][0][\'\1\']';
		$text_blocks = preg_replace('#\{([a-z0-9\-_]*?)\}#is', '<?php if(isset(' . $varref . ')){$this->_echo(' . $varref . ');}else{echo \'\';} ?>', $text_blocks);

		return $text_blocks;
	}

	function compile_tag_block($tag_args, $global=false)
	{
		// Allow for control of looping (indexes start from zero):
		// foo(2)    : Will start the loop on the 3rd entry
		// foo(-2)   : Will start the loop two entries from the end
		// foo(3,4)  : Will start the loop on the fourth entry and end it on the fourth
		// foo(3,-4) : Will start the loop on the fourth entry and end it four from last
		$loop_start = 0;
		$loop_end = '$_' . $tag_args . '_count';
		if (preg_match('#^(.*?)\(([\-0-9]+)(,([\-0-9]+))?\)$#', $tag_args, $match))
		{
			$tag_args = $match[1];
			$loop_start = ($match[2] < 0) ? '$_' . $tag_args . '_count ' . ($match[2] - 1) : $match[2];
			$loop_end = ($match[4]) ? (($match[4] < 0) ? '$_' . $tag_args . '_count ' . $match[4] : ($match[4] + 1)) : '$_' . $tag_args . '_count';
		}

		if ( !$global )
		{
			if ( empty($this->block_names) )
			{
				$this->block_names = array();
			}
			array_push($this->block_names, $tag_args);
		}
		$varref = (sizeof($this->block_names) < 2) || $global ? '$d[\'' . $tag_args . '\']' : $this->generate_block_data_ref(implode('.', $this->block_names), false);
		return 'if(isset(' . $varref . ')){for($_' . $tag_args . '_i=' . $loop_start . ',$_' . $tag_args . '_count=count(' . $varref . ');$_' . $tag_args . '_i<' . $loop_end . ';$_' . $tag_args . '_i++){';
	}

	/**
	 * Generates a reference to the given variable inside the given (possibly nested)
	 * block namespace. This is a string of the form:
	 * ' . $d['parent'][$_parent_i]['$child1'][$_child1_i]['$child2'][$_child2_i]...['varname'] . '
	 * It's ready to be inserted into an "echo" line in one of the templates.
	 * NOTE: expects a trailing "." on the namespace.
	 */
	function generate_block_varref($namespace, $varname)
	{
		$varref = $this->generate_block_data_ref(substr($namespace, 0, strlen($namespace) - 1), true) . '[\'' . $varname . '\']';
		return '<?php if(isset(' . $varref . ')){$this->_echo(' . $varref . ');}else{echo \'\';} ?>';
	}

	/**
	 * Generates a reference to the array of data values for the given
	 * (possibly nested) block namespace. This is a string of the form:
	 * $d['parent'][$_parent_i]['$child1'][$_child1_i]['$child2'][$_child2_i]...['$childN']
	 *
	 * If $include_last_iterator is true, then [$_childN_i] will be appended to the form shown above.
	 * NOTE: does not expect a trailing "." on the blockname.
	 */
	function generate_block_data_ref($blockname, $include_last_iterator)
	{
		// Get an array of the blocks involved.
		$blocks = explode('.', $blockname);
		$blockcount = sizeof($blocks) - 1;
		$varref = '$d';

		// Build up the string with everything but the last child.
		for ($i = 0; $i < $blockcount; $i++)
		{
			$varref .= '[\'' . $blocks[$i] . '\'][$_' . $blocks[$i] . '_i]';
		}

		// Add the block reference for the last child.
		$varref .= '[\'' . $blocks[$blockcount] . '\']';

		// Add the iterator for the last child if requried.
		if ($include_last_iterator)
		{
			$varref .= '[$_' . $blocks[$blockcount] . '_i]';
		}

		return $varref;
	}

	function compile_tag_define($tag_args, $op)
	{
		preg_match('#^(([a-z0-9\-_]+?\.)+?)?\$([A-Z][A-Z0-9_\-]*?)( = (\'?)(.*?)(\'?))?$#', $tag_args, $match);

		if (empty($match[3]) || (empty($match[6]) && $op))
		{
			return;
		}

		if (!$op)
		{
			return 'unset(' . (($match[1]) ? $this->generate_block_data_ref(substr($match[1], 0, -1), true, true) . '[\'' . $match[3] . '\']' : '$d[\'DEFINE\'][\'.\'][\'' . $match[3] . '\']') . ');';
		}

		// Are we a string?
		if ($match[5] && $match[7])
		{
			$match[6] = "'" . addslashes(str_replace(array('\\\'', '\\\\'), array('\'', '\\'), $match[6])) . "'";
		}
		else
		{
			preg_match('#(true|false|\.)#i', $match[6], $type);

			switch (strtolower($type[1]))
			{
				case 'true':
				case 'false':
					$match[6] = strtoupper($match[6]);
					break;
				case '.';
					$match[6] = doubleval($match[6]);
					break;
				default:
					$match[6] = intval($match[6]);
					break;
			}
		}

		return (($match[1]) ? $this->generate_block_data_ref(substr($match[1], 0, -1), true, true) . '[\'' . $match[3] . '\']' : '$d[\'DEFINE\'][\'.\'][\'' . $match[3] . '\']') . ' = ' . $match[6] . ';';
	}

	// This is from Smarty
	function compile_tag_if($tag_args, $elseif)
	{
        /* Tokenize args for 'if' tag. */
        preg_match_all('/(?:
                         "[^"\\\\]*(?:\\\\.[^"\\\\]*)*"         |
                         \'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'     |
                         [(),]                                  |
                         [^\s(),]+)/x', $tag_args, $match);

        $tokens = $match[0];
        $is_arg_stack = array();

        for ($i = 0, $size = sizeof($tokens); $i < $size; $i++)
		{
			$token = &$tokens[$i];

			switch ($token)
			{
                case '!':
                case '%':
                case '!==':
                case '==':
                case '===':
                case '>':
                case '<':
                case '!=':
                case '<>':
                case '<<':
                case '>>':
                case '<=':
                case '>=':
                case '&&':
                case '||':
				case '|':
				case '^':
				case '&':
				case '~':
				case ')':
				case ',':
				case '+':
				case '-':
				case '*':
				case '/':
				case '@':
					break;

				case 'eq':
					$token = '==';
					break;

				case 'ne':
				case 'neq':
					$token = '!=';
					break;

				case 'lt':
					$token = '<';
					break;

				case 'le':
				case 'lte':
					$token = '<=';
					break;

				case 'gt':
					$token = '>';
					break;

				case 'ge':
				case 'gte':
					$token = '>=';
					break;

				case 'and':
					$token = '&&';
					break;

				case 'or':
					$token = '||';
					break;

				case 'not':
					$token = '!';
					break;

				case 'mod':
					$token = '%';
					break;

				case '(':
					array_push($is_arg_stack, $i);
					break;

				case 'is':
					$is_arg_start = ($tokens[$i-1] == ')') ? array_pop($is_arg_stack) : $i-1;
					$is_arg	= implode('	', array_slice($tokens,	$is_arg_start, $i -	$is_arg_start));

					$new_tokens	= $this->_parse_is_expr($is_arg, array_slice($tokens, $i+1));

					array_splice($tokens, $is_arg_start, count($tokens), $new_tokens);

					$i = $is_arg_start;

				default:
					if (preg_match('#^(([a-z0-9\-_]+?\.)+?)?(\$)?([A-Z]+[A-Z0-9\-_]+)$#s', $token, $varrefs))
					{
						$token = (!empty($varrefs[1])) ? $this->generate_block_data_ref(substr($varrefs[1], 0, -1), true, $varrefs[3]) . '[\'' . $varrefs[4] . '\']' : (($varrefs[3]) ? '$d[\'DEFINE\'][\'.\'][\'' . $varrefs[4] . '\']' : '$d[\'.\'][0][\'' . $varrefs[4] . '\']');
					}
					break;
            }
        }

		return (($elseif) ? '} elseif (' : 'if (') . (implode(' ', $tokens) . ') { ');
	}

	// This is from Smarty
	function _parse_is_expr($is_arg, $tokens)
	{
		$expr_end =	0;
		$negate_expr = false;

		if (($first_token = array_shift($tokens)) == 'not')
		{
			$negate_expr = true;
			$expr_type = array_shift($tokens);
		}
		else
		{
			$expr_type = $first_token;
		}

		switch ($expr_type)
		{
			case 'even':
				if (@$tokens[$expr_end] == 'by')
				{
					$expr_end++;
					$expr_arg =	$tokens[$expr_end++];
					$expr =	"!(($is_arg	/ $expr_arg) % $expr_arg)";
				}
				else
				{
					$expr =	"!($is_arg % 2)";
				}
				break;

			case 'odd':
				if (@$tokens[$expr_end] == 'by')
				{
					$expr_end++;
					$expr_arg =	$tokens[$expr_end++];
					$expr =	"(($is_arg / $expr_arg)	% $expr_arg)";
				}
				else
				{
					$expr =	"($is_arg %	2)";
				}
				break;

			case 'div':
				if (@$tokens[$expr_end] == 'by')
				{
					$expr_end++;
					$expr_arg =	$tokens[$expr_end++];
					$expr =	"!($is_arg % $expr_arg)";
				}
				break;

			default:
				break;
		}

		if ($negate_expr)
		{
			$expr =	"!($expr)";
		}

		array_splice($tokens, 0, $expr_end,	$expr);

		return $tokens;
	}
}

?>