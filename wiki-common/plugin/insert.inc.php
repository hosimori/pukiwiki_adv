<?php
// $Id: insert.inc.php,v 1.16.5 2011/02/05 10:58:00 Logue Exp $
//
// Text inserting box plugin

define('INSERT_COLS', 70); // Columns of textarea
define('INSERT_ROWS',  5); // Rows of textarea
define('INSERT_INS',   1); // Order of insertion (1:before the textarea, 0:after)
use PukiWiki\Auth\Auth;
use PukiWiki\Factory;
use PukiWiki\Utility;

function plugin_insert_action()
{
	global $vars, $cols, $rows;
//	global $_title_collided, $_msg_collided, $_title_updated;

$_title_collided   = T_('On updating $1, a collision has occurred.');
$_title_updated    = T_('$1 was updated');
$_msg_collided = T_('It seems that someone has already updated this page while you were editing it.<br />
 + is placed at the beginning of a line that was newly added.<br />
 ! is placed at the beginning of a line that has possibly been updated.<br />
 Edit those lines, and submit again.');

	// if (PKWK_READONLY) die_message('PKWK_READONLY prohibits editing');
	if (Auth::check_role('readonly')) die_message('PKWK_READONLY prohibits editing');
	if (! isset($vars['msg']) || $vars['msg'] == '') return;

	$vars['msg'] = preg_replace('/' . "\r" . '/', '', $vars['msg']);
	$insert = ($vars['msg'] != '') ? "\n" . $vars['msg'] . "\n" : '';

	$postdata = array();
	$wiki = Factory::Wiki($vars['refer']);
	$insert_no = 0;


	foreach($wiki->get() as $line) {
		if (! INSERT_INS) $postdata .= $line;
		if (preg_match('/^#insert$/i', $line)) {
			if ($insert_no == $vars['insert_no'])
				$postdata[] = $insert;
			$insert_no++;
		}
		if (INSERT_INS) $postdata[] = $line;
	}

	$postdata_input = $insert . "\n";

	$body = '';
	if ($wiki->digest() !== $vars['digest']) {
		$title = $_title_collided;
		$body = $_msg_collided . "\n";

		$script = get_script_uri();
		$s_refer  = Utility::htmlsc($vars['refer']);
		$s_digest = Utility::htmlsc($vars['digest']);
		$s_postdata_input = Utility::htmlsc($postdata_input);

		$body .= <<<EOD
<form action="$script" method="post" class="plugin-insert-form">
	<input type="hidden" name="cmd" value="preview" />
	<input type="hidden" name="refer" value="$s_refer" />
	<input type="hidden" name="digest" value="$s_digest" />
	<textarea name="msg" rows="$rows" cols="$cols" id="msg" class="form-control">$s_postdata_input</textarea>
</form>
EOD;
	} else {
		$wiki->set($postdata);

		$title = $_title_updated;
	}
	$retvars['msg']  = $title;
	$retvars['body'] = $body;

	$vars['page'] = $vars['refer'];

	return $retvars;
}

function plugin_insert_convert()
{
	global $vars, $digest;
	static $numbers = array();

	$_btn_insert = T_('add');

	// if (PKWK_READONLY) return ''; // Show nothing
	if (Auth::check_role('readonly')) return ''; // Show nothing

	if (! isset($numbers[$vars['page']])) $numbers[$vars['page']] = 0;

	$insert_no = $numbers[$vars['page']]++;

	$script = get_script_uri();
	$s_page   = Utility::htmlsc($vars['page']);
	$s_digest = Utility::htmlsc($digest);
	$s_cols = INSERT_COLS;
	$s_rows = INSERT_ROWS;
	$string = <<<EOD
<form action="$script" method="post" class="insert_form">
	<input type="hidden" name="insert_no" value="$insert_no" />
	<input type="hidden" name="refer"  value="$s_page" />
	<input type="hidden" name="cmd" value="insert" />
	<input type="hidden" name="digest" value="$s_digest" />
	<textarea name="msg" rows="$s_rows" cols="$s_cols" class="form-control"></textarea><br />
	<input type="submit" class="btn btn-primary" name="insert" value="$_btn_insert" />
</form>
EOD;

	return $string;
}
/* End of file insert.inc.php */
/* Location: ./wiki-common/plugin/insert.inc.php */
