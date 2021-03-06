<?php
// PukPukiPlus.
// $Id: attach.inc.php,v 1.92.51 2012/10/11 19:05:00 Logue Exp $
// Copyright (C)
//   2010-2012 PukiWiki Advance Developers Team <http://pukiwiki.logue.be/>
//   2005-2009 PukiWiki Plus! Team
//   2003-2007,2009,2011 PukiWiki Developers Team
//   2002-2003 PANDA <panda@arino.jp> http://home.arino.jp/
//   2002      Y.MASUI <masui@hisec.co.jp> http://masui.net/pukiwiki/
//   2001-2002 Originally written by yu-ji
// License: GPL v2 or (at your option) any later version
//
// File attach plugin
use PukiWiki\File\AttachFile;
use PukiWiki\Auth\Auth;
use PukiWiki\Spam\Spam;
use PukiWiki\Factory;
use PukiWiki\Router;
use PukiWiki\Utility;

// NOTE (PHP > 4.2.3):
//    This feature is disabled at newer version of PHP.
//    Set this at php.ini if you want.
// Max file size for upload on PHP (PHP default: 2MB)


defined('PLUGIN_ATTACH_ILLEGAL_CHARS_PATTERN')	or define('PLUGIN_ATTACH_ILLEGAL_CHARS_PATTERN', '/[%|=|&|?|#|\r|\n|\0|\@|\t|;|\$|+|\\|\[|\]|\||^|{|}]/');		// default: 4MB

defined('PLUGIN_ATTACH_UPLOAD_MAX_FILESIZE')	or define('PLUGIN_ATTACH_UPLOAD_MAX_FILESIZE', '4M');		// default: 4MB
ini_set('upload_max_filesize', PLUGIN_ATTACH_UPLOAD_MAX_FILESIZE);

// Max file size for upload on script of PukiWikiX_FILESIZE
defined('PLUGIN_ATTACH_MAX_FILESIZE')		or define('PLUGIN_ATTACH_MAX_FILESIZE', (2048 * 1024));		// default: 1MB

// 管理者だけが添付ファイルをアップロードできるようにする
defined('PLUGIN_ATTACH_UPLOAD_ADMIN_ONLY')	or define('PLUGIN_ATTACH_UPLOAD_ADMIN_ONLY', FALSE);		// FALSE or TRUE

// 管理者だけが添付ファイルを削除できるようにする
defined('PLUGIN_ATTACH_DELETE_ADMIN_ONLY')	or define('PLUGIN_ATTACH_DELETE_ADMIN_ONLY', FALSE);		// FALSE or TRUE

// 管理者が添付ファイルを削除するときは、バックアップを作らない
// PLUGIN_ATTACH_DELETE_ADMIN_ONLY=TRUEのとき有効
defined('PLUGIN_ATTACH_DELETE_ADMIN_NOBACKUP')	or define('PLUGIN_ATTACH_DELETE_ADMIN_NOBACKUP', FALSE);	// FALSE or TRUE

// アップロード/削除時にパスワードを要求する(ADMIN_ONLYが優先)
defined('PLUGIN_ATTACH_PASSWORD_REQUIRE')	or define('PLUGIN_ATTACH_PASSWORD_REQUIRE', FALSE);		// FALSE or TRUE

// 添付ファイル名を変更できるようにする
defined('PLUGIN_ATTACH_RENAME_ENABLE')		or define('PLUGIN_ATTACH_RENAME_ENABLE', TRUE);			// FALSE or TRUE

// ファイルのアクセス権
defined('PLUGIN_ATTACH_FILE_MODE')		or define('PLUGIN_ATTACH_FILE_MODE', 0644);
// define('PLUGIN_ATTACH_FILE_MODE', 0604);			// for XREA.COM

// mime-typeを記述したページ
define('PLUGIN_ATTACH_CONFIG_PAGE_MIME', 'plugin/attach/mime-type');

defined('PLUGIN_ATTACH_UNKNOWN_COMPRESS')	or define('PLUGIN_ATTACH_UNKNOWN_COMPRESS', 0);			// 1(compress) or 0(raw)
defined('PLUGIN_ATTACH_COMPRESS_TYPE')		or define('PLUGIN_ATTACH_COMPRESS_TYPE', 'TGZ');		// TGZ, GZ, BZ2 or ZIP

// 添付ファイルキャッシュを使う（ページの表示やページごとの添付ファイル一覧表示は早くなりますが、全ページではむしろ重くなります）
defined('PLUGIN_ATTACH_USE_CACHE')    or define('PLUGIN_ATTACH_USE_CACHE', false);
// 添付ファイルのキャッシュの接頭辞
defined('PLUGIN_ATTACH_CACHE_PREFIX') or define('PLUGIN_ATTACH_CACHE_PREFIX', 'attach-');

function plugin_attach_init()
{
	global $_string;
	$messages = array(
		'_attach_messages' => array(
			'msg_uploaded'	=> T_('Uploaded the file to $1'),
			'msg_deleted'	=> T_('Deleted the file in $1'),
			'msg_freezed'	=> T_('The file has been frozen.'),
			'msg_unfreezed'	=> T_('The file has been unfrozen'),
			'msg_upload'	=> T_('Upload to $1'),
			'msg_info'		=> T_('File information'),
			'msg_confirm'	=> T_('Delete %s.'),
			'msg_list'		=> T_('List of attached file(s)'),
			'msg_listpage'	=> T_('List of attached file(s) in $1'),
			'msg_listall'	=> T_('Attached file list of all pages'),
			'msg_file'		=> T_('Attach file'),
			'msg_maxsize'	=> T_('Maximum file size is %s.'),
			'msg_count'		=> T_('%s download'),
			'msg_password'	=> T_('password'),
			'msg_adminpass'	=> T_('Administrator password'),
			'msg_delete'	=> T_('Delete file.'),
			'msg_freeze'	=> T_('Freeze file.'),
			'msg_unfreeze'	=> T_('Unfreeze file.'),
			'msg_renamed'	=> T_('The file has been renamed'),
			'msg_isfreeze'	=> T_('File is frozen.'),
			'msg_rename'	=> T_('Rename'),
			'msg_newname'	=> T_('New file name'),
			'msg_require'	=> T_('(require administrator password)'),
			'msg_filesize'	=> T_('size'),
			'msg_type'		=> T_('type'),
			'msg_date'		=> T_('date'),
			'msg_dlcount'	=> T_('access count'),
			'msg_md5hash'	=> T_('MD5 hash'),
			'msg_page'		=> T_('Page'),
			'msg_filename'	=> T_('Stored filename'),
			'msg_thispage'	=> T_('This page'),
			'err_noparm'	=> T_('Cannot upload/delete file in $1'),
			'err_exceed'	=> T_('File size too large to $1'),
			'err_exists'	=> T_('File already exists in $1'),
			'err_notfound'	=> T_('Could not find the file in $1'),
			'err_noexist'	=> T_('File does not exist.'),
			'err_delete'	=> T_('Cannot delete file in  $1'),
			'err_rename'	=> T_('Cannot rename this file'),
			'err_password'	=> $_string['invalidpass'],
			'err_upload'	=> T_('It failed in uploading.'),
			'err_adminpass'	=> T_('Wrong administrator password'),
			'err_ini_size'	=> T_('The value of the upload_max_filesize directive of php.ini is exceeded.'),
			'err_form_size'	=> T_('MAX_FILE_SIZE specified by the HTML form is exceeded.'),
			'err_partial'	=> T_('Only part is uploaded.'),
			'err_no_file'	=> T_('The file was not uploaded.'),
			'err_no_tmp_dir'=> T_('There is no temporary directory.'),
			'err_cant_write'=> T_('It failed in writing in the disk.'),
			'err_extension'	=> T_('The uploading of the file was stopped by the enhancement module.'),
			'btn_upload'	=> T_('Upload'),
			'btn_info'		=> T_('Information'),
			'btn_submit'	=> T_('Submit'),
			'err_too_long'	=> T_('Query string (page name and/or file name) too long'),
			'err_nopage'	=> T_('No such page'),
			'err_tmp_fail'	=> T_('It failed in the generation of a temporary file.'),
			'err_load_file'	=> T_('The uploaded file cannot be read.'),			// アップロードされたファイルが読めません。
			'err_write_tgz'	=> T_('The compression file cannot be written.'),	// 圧縮ファイルが書けません。
			'err_filename'	=> T_('File name is too long. Please rename more short file name before upoload.')	// ファイル名が長すぎます。アップロードする前に短いファイル名にしてください。
		),
	);
	set_plugin_messages($messages);
}

//-------- convert
function plugin_attach_convert()
{
	global $vars;

	$page = isset($vars['page']) ? $vars['page'] : '';

	$nolist = $noform = FALSE;
	if (func_num_args() > 0) {
		foreach (func_get_args() as $arg) {
			$arg = strtolower($arg);
			$nolist |= ($arg == 'nolist');
			$noform |= ($arg == 'noform');
		}
	}

	$ret = '';
	if (! $nolist) {
		$obj  = new AttachPages($page);
		$ret .= $obj->toString($page, TRUE);
	}
	if (! $noform) {
		$ret .= attach_form($page);
	}

	return $ret;
}

//-------- action
function plugin_attach_action()
{
	global $vars, $_attach_messages, $_string;

	// Backward compatible
	if (isset($vars['openfile'])) {
		$vars['file'] = $vars['openfile'];
		$vars['pcmd'] = 'open';
	}
	if (isset($vars['delfile'])) {
		$vars['file'] = $vars['delfile'];
		$vars['pcmd'] = 'delete';
	}

	$pcmd  = isset($vars['pcmd'])  ? $vars['pcmd']  : NULL;
	$refer = isset($vars['refer']) ? $vars['refer'] : NULL;
	$pass  = isset($vars['pass'])  ? $vars['pass']  : NULL;
	$page  = isset($vars['page'])  ? $vars['page']  : $refer;

	if (isset($page)){
		$wiki = Factory::Wiki($page);

		if (!empty($refer) && $wiki->isValied()) {
			if(in_array($pcmd, array('info', 'open', 'list'))) {
				$wiki->checkReadable();
			} else {
				$wiki->checkEditable();
			}
		}
	}

	// Dispatch
	if (isset($_FILES['attach_file'])) {
		// Upload
		return attach_upload($_FILES['attach_file'], $refer, $pass);
	} else {
		switch ($pcmd) {
		case 'delete':	/*FALLTHROUGH*/
		case 'freeze':
		case 'unfreeze':
			// if (PKWK_READONLY) die_message('PKWK_READONLY prohibits editing');
			if (Auth::check_role('readonly')) die_message( $_string['error_prohibit'] );
		}
		switch ($pcmd) {
			case 'info'     : return attach_info();
			case 'delete'   : return attach_delete();
			case 'open'     : return attach_open();
			case 'list'     : return attach_list($page);
			case 'freeze'   : return attach_freeze(TRUE);
			case 'unfreeze' : return attach_freeze(FALSE);
			case 'rename'   : return attach_rename();
			case 'upload'   : return attach_showform();
			case 'form'     : return array('msg'  =>str_replace('$1', $refer, $_attach_messages['msg_upload']), 'body'=>attach_form($refer));
			case 'progress' : return get_upload_progress();
		}
		return (empty($page) || ! $wiki->isValied()) ? attach_list() : attach_showform();
	}
}

//-------- call from skin
function attach_filelist()
{
	global $vars, $_attach_messages;

	$page = isset($vars['page']) ? $vars['page'] : '';
	$obj = new AttachPages($page, 0);

	return isset($obj->pages[$page]) ? ('<dl class="attach_filelist">'."\n".'<dt>'.$_attach_messages['msg_file'].' :</dt>'."\n".$obj->toString($page, TRUE, 'dl') . '</dl>'."\n") : '';
}

//-------- 実体
// ファイルアップロード
// $pass = NULL : パスワードが指定されていない
// $pass = TRUE : アップロード許可
function attach_upload($file, $page, $pass = NULL)
{
	global $_attach_messages, $_string;

	$wiki = Factory::Wiki($page);

	// if (PKWK_READONLY) die_message('PKWK_READONLY prohibits editing');
	if (Auth::check_role('readonly')) die_message($_string['error_prohibit']);

	// Check query-string
	$query = Router::get_cmd_uri('attach', '', '', array(
		'refer'=>$page,
		'pcmd'=>'info',
		'file'=>$file['name']
	));

	if ($file['error'] !== UPLOAD_ERR_OK) {
		return array(
			'result'=>FALSE,
			'msg'=>'<p class="alert alert-danger">'.attach_set_error_message($file['error']).'</p>'
		);
	}


	if (PKWK_QUERY_STRING_MAX && strlen($query) > PKWK_QUERY_STRING_MAX) {
		pkwk_common_headers();
		echo($_attach_messages['err_too_long']);
		exit;
	} else if (! $wiki->isValied()) {
		die_message($_attach_messages['err_nopage']);
	} else if ($file['tmp_name'] == '' || ! is_uploaded_file($file['tmp_name'])) {
		return array(
			'result'=>FALSE,
			'msg'=>$_attach_messages['err_upload']);
	} else if ($file['size'] > PLUGIN_ATTACH_MAX_FILESIZE) {
		return array(
			'result'=>FALSE,
			'msg'=>$_attach_messages['err_exceed']);
	} else if (! is_pagename($page) || ($pass !== TRUE && ! is_editable($page))) {
		return array(
			'result'=>FALSE,'
			msg'=>$_attach_messages['err_noparm']);

	// } else if (PLUGIN_ATTACH_UPLOAD_ADMIN_ONLY && $pass !== TRUE &&
	} else if (PLUGIN_ATTACH_UPLOAD_ADMIN_ONLY && Auth::check_role('role_contents_admin') && $pass !== TRUE &&
		  ($pass === NULL || ! pkwk_login($pass))) {
		return array(
			'result'=>FALSE,
			'msg'=>$_attach_messages['err_adminpass']);
	}

	if (PLUGIN_ATTACH_USE_CACHE){
		global $cache;
		$cache['wiki']->removeItem(PLUGIN_ATTACH_CACHE_PREFIX.md5($refer));
	}

	return attach_doupload($file, $page, $pass);
}

function attach_set_error_message($err_no)
{
	global $_attach_messages;

	switch($err_no) {
		case UPLOAD_ERR_INI_SIZE:
			return $_attach_messages['err_ini_size'];
		case UPLOAD_ERR_FORM_SIZE:
			return $_attach_messages['err_form_size'];
		case UPLOAD_ERR_PARTIAL:
			return $_attach_messages['err_partial'];
		case UPLOAD_ERR_NO_FILE:
			return $_attach_messages['err_no_file'];
		case UPLOAD_ERR_NO_TMP_DIR:
			return $_attach_messages['err_no_tmp_dir'];
		case UPLOAD_ERR_CANT_WRITE:
			return $_attach_messages['err_cant_write'];
		case UPLOAD_ERR_EXTENSION:
			return $_attach_messages['err_extension'];
	}
	return $_attach_messages['err_upload'];
}

function attach_gettext($path, $lock=FALSE)
{
	$fp = @fopen($path, 'r');
	if ($fp == FALSE) return FALSE;

	if ($lock) {
		@flock($fp, LOCK_SH);
	}

	// Returns a value
	$result = fread($fp, filesize($path));

	if ($lock) {
		@flock($fp, LOCK_UN);
		@fclose($fp);
	}
	return $result;
}

function attach_doupload(&$file, $page, $pass=NULL, $temp='', $copyright=FALSE, $notouch=FALSE)
{
	global $_attach_messages, $_strings;
	global $notify, $notify_subject, $notify_exclude, $spam;

	// Check Illigal Chars
	if (preg_match(PLUGIN_ATTACH_ILLEGAL_CHARS_PATTERN, $file['name'])){
		Utility::dieMessage($_strings['illegal_chars']);
	}

	$type = Utility::getMimeInfo($file['tmp_name']);
	$must_compress = (PLUGIN_ATTACH_UNKNOWN_COMPRESS !== 0) ? attach_is_compress($type,PLUGIN_ATTACH_UNKNOWN_COMPRESS) : false;

	// ファイル名の長さをチェック
	$filename_length = strlen(Utility::encode($page).'_'.Utility::encode($file['name']));
	if ( $filename_length  >= 255 || ($must_compress && $filename_length >= 251 )){
		return array(
			'result'=>FALSE,
			'msg'=>$_attach_messages['err_filename']
		);
	}

	if ($must_compress) {
		// if attach spam, filtering attach file.
		$vars['uploadname'] = $file['name'];
		$vars['uploadtext'] = attach_gettext($file['tmp_name']);
		if ($vars['uploadtext'] === '' || $vars['uploadtext'] === FALSE) return FALSE;

		//global $spam;
		if ($spam !== 0) {
			if (isset($spam['method']['attach'])) {
				$_method = & $spam['method']['attach'];
			} else if (isset($spam['method']['_default'])) {
				$_method = & $spam['method']['_default'];
			} else {
				$_method = array();
			}
			$exitmode = isset($spam['exitmode']) ? $spam['exitmode'] : '';
			Spam::pkwk_spamfilter('File Attach', $page, $vars, $_method, $exitmode);
		}
	}

	if ($must_compress && is_uploaded_file($file['tmp_name'])) {
		switch (PLUGIN_ATTACH_COMPRESS_TYPE){
			case 'TGZ' :
				if (exist_plugin('dump')) {
					$obj = new AttachFile($page, $file['name'] . '.tgz');
					if ($obj->exist)
						return array('result'=>FALSE,
							'msg'=>$_attach_messages['err_exists']);

					$tar = new tarlib();
					$tar->create(CACHE_DIR, 'tgz') or
						die_message( $_attach_messages['err_tmp_fail'] );
					$tar->add_file($file['tmp_name'], $file['name']);
					$tar->close();

					@rename($tar->filename, $obj->filename);
					chmod($obj->filename, PLUGIN_ATTACH_FILE_MODE);
					@unlink($tar->filename);
				}
			break;
			case 'GZ' :
				if (extension_loaded('zlib')) {
					$obj = new AttachFile($page, $file['name'] . '.gz');
					if ($obj->exist)
						return array('result'=>FALSE,
							'msg'=>$_attach_messages['err_exists']);

					$tp = fopen($file['tmp_name'],'rb') or
						die_message($_attach_messages['err_load_file']);
					$zp = gzopen($obj->filename, 'wb') or
						die_message($_attach_messages['err_write_tgz']);

					while (!feof($tp)) { gzwrite($zp,fread($tp, 8192)); }
					gzclose($zp);
					fclose($tp);
					chmod($obj->filename, PLUGIN_ATTACH_FILE_MODE);
					@unlink($file['tmp_name']);
				}
			break;
			case 'ZIP' :
				if (class_exists('ZipArchive')) {
					$obj = new AttachFile($page, $file['name'] . '.zip');
					if ($obj->exist)
						return array('result'=>FALSE,
							'msg'=>$_attach_messages['err_exists']);
					$zip = new ZipArchive();

					$zip->addFile($file['tmp_name'],$file['name']);
					// if ($zip->status !== ZIPARCHIVE::ER_OK)
					if ($zip->status !== 0)
						die_message( $_attach_messages['err_upload'].'('.$zip->status.').' );
					$zip->close();
					chmod($obj->filename, PLUGIN_ATTACH_FILE_MODE);
					@unlink($file['tmp_name']);
				}
			break;
			case 'BZ2' :
				if (extension_loaded('bz2')){
					$obj = new AttachFile($page, $file['name'] . '.bz2');
					if ($obj->exist)
						return array('result'=>FALSE,
							'msg'=>$_attach_messages['err_exists']);

					$tp = fopen($file['tmp_name'],'rb') or
						die_message($_attach_messages['err_load_file']);
					$zp = bzopen($obj->filename, 'wb') or
						die_message($_attach_messages['err_write_tgz']);

					while (!feof($tp)) { bzwrite($zp,fread($tp, 8192)); }
					bzclose($zp);
					fclose($tp);
					chmod($obj->filename, PLUGIN_ATTACH_FILE_MODE);
					@unlink($file['tmp_name']);
				}
			break;
			default:
//miko
				$obj = new AttachFile($page, $file['name']);
				if ($obj->exist)
					return array('result'=>FALSE,
						'msg'=>$_attach_messages['err_exists']);

				if (move_uploaded_file($file['tmp_name'], $obj->filename))
					chmod($obj->filename, PLUGIN_ATTACH_FILE_MODE);
			break;
		}
	}else{
		$obj = new AttachFile($page, $file['name']);
			if (isset($obj->exist) )
				return array('result'=>FALSE,
					'msg'=>$_attach_messages['err_exists']);

			if (move_uploaded_file($file['tmp_name'], $obj->filename))
				chmod($obj->filename, PLUGIN_ATTACH_FILE_MODE);
	}

	// ページのタイムスタンプを更新
	Factory::Wiki($page)->touch();

	$obj->getstatus();
	$obj->status['pass'] = ($pass !== TRUE && $pass !== NULL) ? md5($pass) : '';
	$obj->setstatus();

	if ($notify) {
		$notify_exec = TRUE;
		foreach ($notify_exclude as $exclude) {
			$exclude = preg_quote($exclude);
			if (substr($exclude, -1) == '.')
				$exclude = $exclude . '*';
			if (preg_match('/^' . $exclude . '/', get_remoteip())) {
				$notify_exec = FALSE;
				break;
			}
		}
	} else {
		$notify_exec = FALSE;
	}

	if ($notify_exec !== FALSE) {
		$footer['ACTION']   = 'File attached';
		$footer['FILENAME'] = $file['name'];
		$footer['FILESIZE'] = $file['size'];
		$footer['PAGE']     = $page;
		$footer['URI'] = get_cmd_uri('attach','',array('refer'=>$page,'pcmd'=>'info','file'=>$file['name']));
		$footer['USER_AGENT']  = TRUE;
		$footer['REMOTE_ADDR'] = TRUE;

		pkwk_mail_notify($notify_subject, "\n", $footer);
	}

	return array(
		'result'=>TRUE,
		'msg'=>sprintf($_attach_messages['msg_uploaded'],Utility::htmlsc($page)));
}

// ファイルタイプによる圧縮添付の判定
function attach_is_compress($type,$compress=1)
{
	if (empty($type)) return $compress;
	list($discrete,$composite_tmp) = explode('/', strtolower($type));
	if (strstr($type,';') === false) {
		$composite = $composite_tmp;
		$parameter = '';
	} else {
		list($composite,$parameter) = explode(';', $composite_tmp);
		$parameter = trim($parameter);
	}
	unset($composite_tmp);

	// type
	static $composite_type = array(
		'application' => array(
			'msword'			=> 0, // doc
			'vnd.ms-excel'		=> 0, // xls
			'vnd.ms-powerpoint'	=> 0, // ppt
			'vnd.visio'			=> 0,
			'octet-stream'		=> 0, // bin dms lha lzh exe class so dll img iso
			'x-bcpio'			=> 0, // bcpio
			'x-bittorrent'		=> 0, // torrent
			'x-bzip2'			=> 0, // bz2
			'x-compress'		=> 0,
			'x-cpio'			=> 0, // cpio
			'x-dvi'				=> 0, // dvi
			'x-gtar'			=> 0, // gtar
			'x-gzip'			=> 0, // gz tgz
			'x-rpm'				=> 0, // rpm
			'x-shockwave-flash'	=> 0, // swf
			'zip'				=> 0, // zip
			'x-7z-compressed'	=> 0, // 7zip
			'x-lzh-compressed'	=> 0, // LZH
			'x-rar-compressed'	=> 0, // RAR
			'x-java-archive'	=> 0, // jar
			'x-javascript'		=> 1, // js
			'ogg'				=> 0, // ogg
			'pdf'				=> 0, // pdf
		),
	);
	if (isset($composite_type[$discrete][$composite])) {
		return $composite_type[$discrete][$composite];
	}

	// discrete-type
	static $discrete_type = array(
		'text'			=> 1,
		'image'			=> 0,
		'audio'			=> 0,
		'video'			=> 0,
	);
	return isset($discrete_type[$discrete]) ? $discrete_type[$discrete] : $compress;
}

// 詳細フォームを表示
function attach_info($err = '')
{
	global $vars, $_attach_messages;

	foreach (array('refer', 'file', 'age') as $var)
		${$var} = isset($vars[$var]) ? $vars[$var] : '';

	$obj = new AttachFile($refer, $file, $age);
	return $obj->getstatus() ?
		$obj->info($err) :
		array('msg'=>$_attach_messages['err_notfound']);
}

// 削除
function attach_delete()
{
	global $vars, $_attach_messages;

	foreach (array('refer', 'file', 'age', 'pass') as $var)
		${$var} = isset($vars[$var]) ? $vars[$var] : '';

	if (is_freeze($refer) || ! is_editable($refer))
		return array('msg'=>$_attach_messages['err_noparm']);

	$obj = new AttachFile($refer, $file, $age);
	if (! $obj->getstatus())
		return array('msg'=>$_attach_messages['err_notfound']);

	if (PLUGIN_ATTACH_USE_CACHE){
		global $cache;
		$cache['wiki']->removeItem(PLUGIN_ATTACH_CACHE_PREFIX.md5($refer));
	}

	return $obj->delete($pass);
}

// 凍結
function attach_freeze($freeze)
{
	global $vars, $_attach_messages;

	foreach (array('refer', 'file', 'age', 'pass') as $var) {
		${$var} = isset($vars[$var]) ? $vars[$var] : '';
	}

	if (is_freeze($refer) || ! is_editable($refer)) {
		return array('msg'=>$_attach_messages['err_noparm']);
	} else {
		$obj = new AttachFile($refer, $file, $age);
		return $obj->getstatus() ?
			$obj->freeze($freeze, $pass) :
			array('msg'=>$_attach_messages['err_notfound']);
	}
}

// リネーム
function attach_rename()
{
	global $vars, $_attach_messages;

	foreach (array('refer', 'file', 'age', 'pass', 'newname') as $var) {
		${$var} = isset($vars[$var]) ? $vars[$var] : '';
	}

	if (is_freeze($refer) || ! is_editable($refer)) {
		return array('msg'=>$_attach_messages['err_noparm']);
	}
	$obj = new AttachFile($refer, $file, $age);
	if (! $obj->getstatus())
		return array('msg'=>$_attach_messages['err_notfound']);

	cache_timestamp_touch('attach');
	return $obj->rename($pass, $newname);
}

// ダウンロード
function attach_open()
{
	global $vars, $_attach_messages;

	foreach (array('refer', 'file', 'age') as $var) {
		${$var} = isset($vars[$var]) ? $vars[$var] : '';
	}

	$obj = new AttachFile($refer, $file, $age);
	return $obj->getstatus() ?
		$obj->open() :
		array('msg'=>$_attach_messages['err_notfound']);
}

// 一覧取得
function attach_list()
{
	global $vars, $_attach_messages, $_string;

	if (Auth::check_role('safemode')) die_message( $_string['prohibit'] );

	$refer = isset($vars['refer']) ? $vars['refer'] : '';
	$obj = new AttachPages($refer);

	if ($refer == ''){
		$msg = $_attach_messages['msg_listall'];
		$body = (isset($obj->pages)) ?
			$obj->toString($refer, FALSE) :
			$_attach_messages['err_noexist'];
	}else{
		$msg = str_replace('$1', htmlsc($refer), $_attach_messages['msg_listpage']);
		$body = (isset($obj->pages[$refer])) ?
			$obj->toRender($refer, FALSE) :
			$_attach_messages['err_noexist'];
	}

	return array('msg'=>$msg, 'body'=>$body);
}

// アップロードフォームを表示 (action時)
function attach_showform()
{
	global $vars, $_attach_messages, $_string;

	if (Auth::check_role('safemode')) die_message( $_string['prohibit'] );

	$page = isset($vars['page']) ? $vars['page'] : '';
	$isEditable = check_editable($page, true, false);

	$vars['refer'] = $page;

	$html = array();
	if (!IS_AJAX){
		$attach_list = attach_list($page);
		$html[] = '<p><small>[<a href="' . Router::get_cmd_uri('attach', null, null, array('pcmd'=>'list')) . '">'.$_attach_messages['msg_listall'].'</a>]</small></p>';
		if ($isEditable){
			$html[] = '<h3>' . str_replace('$1', $page, $_attach_messages['msg_upload']) . '</h3>'. "\n";
			$html[] = attach_form($page);
		}
		$html[] = '<h3>' . str_replace('$1', $page, $_attach_messages['msg_listpage']) . '</h3>'. "\n";
		$html[] = $attach_list['body'];
	}else{
		$html[] = '<div class="tabs" role="application">';
		$html[] = '<ul role="tablist">';
		if ($isEditable){
			$html[] = '<li role="tab"><a href="' .get_cmd_uri('attach', null, null, array('pcmd'=>'form', 'refer'=>$page)) . '">' . str_replace('$1', $_attach_messages['msg_thispage'], $_attach_messages['msg_upload']) . '</a></li>';
		}
		$html[] = '<li role="tab"><a href="' .get_cmd_uri('attach', null, null, array('pcmd'=>'list', 'refer'=>$page)) . '">' . str_replace('$1', $_attach_messages['msg_thispage'], $_attach_messages['msg_listpage']) . '</a></li>';
		$html[] = '</ul>';
		$html[] = '</div>';
	}

	return array(
		'msg'=>$_attach_messages['msg_upload'],
		'body'=>join("\n",$html)
	);
}



// アップロードフォームの出力
function attach_form($page)
{
	global $_attach_messages;

	if (! ini_get('file_uploads'))	return '<p class="alert alert-warning">#attach(): <code>file_uploads</code> disabled.</p>';
	if (! Factory::Wiki($page)->has())			return '#attach(): No such page<br />';

	$attach_form[] = '<form enctype="multipart/form-data" action="' . Router::get_script_uri() . '" method="post" class="form-inline plugin-attach-form" data-collision-check="false">';
	$attach_form[] = '<input type="hidden" name="cmd" value="attach" />';
	$attach_form[] = '<input type="hidden" name="pcmd" value="post" />';
	$attach_form[] = '<input type="hidden" name="refer" value="'. Utility::htmlsc($page) .'" />';
	$attach_form[] = '<input type="hidden" name="max_file_size" value="' . PLUGIN_ATTACH_MAX_FILESIZE . '" />';
	$attach_form[] = '<div class="form-group">';
	$attach_form[] = '<label for="_p_attach_file" class="sr-only">' . $_attach_messages['msg_file'] . ':</label>';
	$attach_form[] = '<input type="file" name="attach_file" id="_p_attach_file" class="form-control" />';
	$attach_form[] = '</div>';
	if ((PLUGIN_ATTACH_PASSWORD_REQUIRE || PLUGIN_ATTACH_UPLOAD_ADMIN_ONLY) && Auth::check_role('role_contents_admin')){
		$attach_form[] = '<div class="form-group">';
		$attach_form[] = '<input type="password" name="pass" size="8" class="form-control" />';
		$attach_form[] = '</div>';
	}
	$attach_form[] = '<input class="btn btn-primary" type="submit" value="' . $_attach_messages['btn_upload'] . '" />';
	$attach_form[] = '</form>';
	$attach_form[] = '<ul class="attach_info">';
	$attach_form[] = ( (PLUGIN_ATTACH_PASSWORD_REQUIRE || PLUGIN_ATTACH_UPLOAD_ADMIN_ONLY) && Auth::check_role('role_contents_admin')) ?
						('<li>' . $_attach_messages[PLUGIN_ATTACH_UPLOAD_ADMIN_ONLY ? 'msg_adminpass' : 'msg_password'] . '</li>') : '';
	$attach_form[] = '<li>' . sprintf($_attach_messages['msg_maxsize'], '<var>' . number_format(PLUGIN_ATTACH_MAX_FILESIZE / 1024) . '</var>KB') . '</li>';
	$attach_form[] = '</ul>';

	return join("\n",$attach_form);
}

//-------- クラス
// ファイルコンテナ
class AttachFiles
{
	var $page;
	var $files = array();
	private $attach_file = 'PukiWiki\File\AttachFile';

	function __construct($page)
	{
		$this->page = $page;
	}

	function add($file, $age)
	{
		$this->files[$file][$age] = new AttachFile($this->page, $file, $age);
	}

	// ファイル一覧を取得
	function toString($flat = null,$tag = '')
	{
		global $_title;

		if (! check_readable($this->page, FALSE, FALSE)) {
			return str_replace('$1', make_pagelink($this->page), $_title['cannotread']);
		} else if ($tag == 'dl'){
			return $this->to_ddtag();
		} else if ($flat) {
			return $this->to_flat();
		}

		$ret = '';
		$files = array_keys($this->files);
		sort($files, SORT_STRING);

		foreach ($files as $file) {
			$_files = array();
			foreach (array_keys($this->files[$file]) as $age) {
				$_files[$age] = $this->files[$file][$age]->toString(FALSE, TRUE);
			}
			if (! isset($_files[0])) {
				$_files[0] = htmlsc($file);
			}
			ksort($_files, SORT_NUMERIC);
			$_file = $_files[0];
			unset($_files[0]);
			$ret .= " <li>$_file\n";
			if (count($_files)) {
				$ret .= "<ul>\n<li>" . join("</li>\n<li>", $_files) . "</li>\n</ul>\n";
			}
			$ret .= " </li>\n";
		}
		return make_pagelink($this->page) . "\n<ul>\n$ret</ul>\n";
	}

	// ファイル一覧を取得(inline)
	function to_flat()
	{
		$ret = '';
		$files = array();
		foreach (array_keys($this->files) as $file) {
			if (isset($this->files[$file][0])) {
				$files[$file] = & $this->files[$file][0];
			}
		}
		uasort($files, array($this->attach_file, 'datecomp'));
		foreach (array_keys($files) as $file) {
			$ret .= $files[$file]->toString(TRUE, TRUE) . ' ';
		}

		return $ret;
	}

	// dlタグで一覧
	function to_ddtag()
	{
		$ret = '';
		$files = array();
		foreach (array_keys($this->files) as $file) {
			if (isset($this->files[$file][0])) {
				$files[$file] = & $this->files[$file][0];
			}
		}
		uasort($files, array($this->attach_file, 'datecomp'));
		foreach (array_keys($files) as $file) {
			$ret .= '<dd>'.str_replace("\n",'',$files[$file]->toString(TRUE, TRUE)) . '</dd>'."\n";
		}

		return $ret;
	}

	// ファイル一覧をテーブルで取得
	function toRender($flat)
	{
		global $_attach_messages;
		global $_title;

		if (! check_readable($this->page, FALSE, FALSE)) {
			return str_replace('$1', make_pagelink($this->page), $_title['cannotread']);
		} else if ($flat) {
			return $this->to_flat();
		}

		$ret = '';
		$files = array_keys($this->files);
		sort($files, SORT_STRING);

		foreach ($files as $file) {
			$_files = array();
			foreach (array_keys($this->files[$file]) as $age) {
				$_files[$age] = $this->files[$file][$age]->toString(FALSE, TRUE);
			}
			if (! isset($_files[0])) {
				$_files[0] = htmlsc($file);
			}
			//pr($this->files[$file]);
			ksort($_files, SORT_NUMERIC);
			$_file = $_files[0];
			unset($_files[0]);
			$fileinfo = $this->files[$file];
			if (isset( $fileinfo[0])){
				$ret .= join('',array(
					'<tr><td>' . $_file . '</td>',
					'<td>' . $fileinfo[0]->size_str . '</td>',
					'<td>' . $fileinfo[0]->type . '</td>',
					'<td>' . $fileinfo[0]->time_str . '</td></tr>'
				))."\n";
			}
			// else{ ... } // delated FIX me!
		}
		return '<table class="table attach_table" data-pagenate="true"><thead>' . "\n" .
		       '<tr><th>' . $_attach_messages['msg_file'] . '</th>' .
		       '<th>' . $_attach_messages['msg_filesize'] . '</th>' .
		       '<th>' . $_attach_messages['msg_type'] . '</th>' .
		       '<th>' . $_attach_messages['msg_date'] . '</th></tr></thead>'."\n".
		       '<tbody>' . "\n$ret</tbody></table>\n";
	}
}

// ページコンテナ
class AttachPages
{
	var $pages = array();

	function AttachPages($page = '', $age = NULL, $purge = false)
	{
		global $cache;
		$handle = opendir(UPLOAD_DIR) or
			die('directory ' . UPLOAD_DIR . ' is not exist or not readable.');

		if ($purge)
			$cache['wiki']->clearByPrefix(PLUGIN_ATTACH_CACHE_PREFIX);

		$cache_name = (PLUGIN_ATTACH_USE_CACHE && $page !== '') ? PLUGIN_ATTACH_CACHE_PREFIX.md5($page) : null;

		if ($page !== '' && isset($cache_name) && $cache['wiki']->hasItem($cache_name) ){
			$this->pages[$page] = (object)$cache['wiki']->getItem($cache_name);
		}else{
			$page_pattern = ($page == '') ? '(?:[0-9A-F]{2})+' : preg_quote(encode($page), '/');
			$age_pattern = ($age === NULL) ?
				'(?:\.([0-9]+))?' : ($age ?  "\.($age)" : '');
			$pattern = "/^({$page_pattern})_((?:[0-9A-F]{2})+){$age_pattern}$/";

			$matches = array();
			$_page2 = '';
			while (($file = readdir($handle)) !== FALSE) {
				if (! preg_match($pattern, $file, $matches)) continue;
				$_page = decode($matches[1]);
				if (! check_readable($_page, FALSE, FALSE)) continue;

				if (PLUGIN_ATTACH_USE_CACHE){
					$_cache_name = PLUGIN_ATTACH_CACHE_PREFIX.md5($_page);
					if ( $cache['wiki']->hasItem($_cache_name) ){
						$this->pages[$_page] = $cache['wiki']->getItem($_cache_name);
						continue;
					}
				}

				$_file = decode($matches[2]);
				$_age  = isset($matches[3]) ? $matches[3] : 0;
				if (! isset($this->pages[$_page])) {
					$this->pages[$_page] = new AttachFiles($_page);
				}
				$this->pages[$_page]->add($_file, $_age);
				if (PLUGIN_ATTACH_USE_CACHE){
					$_page2 = $_page;
				}
			}
			closedir($handle);

			// ページごとの添付ファイル情報をキャッシュ
			if (PLUGIN_ATTACH_USE_CACHE){
				if ($page !== '' && isset($this->pages[$page])){
					$cache['wiki']->setItem(PLUGIN_ATTACH_CACHE_PREFIX.md5($page), $this->pages[$page]);
				}else{
					foreach ($this->pages as $line){
						$md5 = PLUGIN_ATTACH_CACHE_PREFIX.md5($line->page);
						if (! $cache['wiki']->hasItem($md5)){
							$cache['wiki']->setItem($md5, $this->pages[$line->page]);
						}
					}
				}
			}
		}
	}

	function toString($page = '', $flat = FALSE, $tag = '')
	{
		if ($page !== '') {
			return (! isset($this->pages[$page])) ? '' : $this->pages[$page]->toString($flat,$tag);
		}
		$ret = '';

		$pages = array_keys($this->pages);
		sort($pages, SORT_STRING);

		foreach ($pages as $page) {
			if (check_non_list($page)) continue;
			$ret .= '<li>' . $this->pages[$page]->toString($flat) . '</li>' . "\n";
		}
		return "\n" . '<ul>' . "\n" . $ret . '</ul>' . "\n";
	}

	function toRender($page = '', $pattern = 0)
	{
		if ($page != '') {
			if (! isset($this->pages[$page])) {
				return '';
			} else {
				return $this->pages[$page]->toRender($pattern);
			}
		}
		$ret = '';

		$pages = array_keys($this->pages);
		sort($pages, SORT_STRING);

		foreach ($pages as $page) {
			if (check_non_list($page)) continue;
			$ret .= '<tr><td>' . $this->pages[$page]->toRender($pattern) . '</td></tr>' . "\n";
		}
		return "\n" . '<table>' . "\n" . $ret . '</table>' . "\n";
	}
}
/* End of file attach.inc.php */
/* Location: ./wiki-common/plugin/attach.inc.php */