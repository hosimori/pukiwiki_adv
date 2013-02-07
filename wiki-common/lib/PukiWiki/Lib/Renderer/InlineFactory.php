<?php
/**
 * インライン変換ファクトリークラス
 *
 * @package   PukiWiki\Lib\Renderer
 * @access    public
 * @author    Logue <logue@hotmail.co.jp>
 * @copyright 2012-2013 PukiWiki Advance Developers Team
 * @create    2012/12/18
 * @license   GPL v2 or (at your option) any later version
 * @version   $Id: InlineFactory.php,v 1.0.0 2013/02/01 19:54:00 Logue Exp $
 */
namespace PukiWiki\Lib\Renderer;
use PukiWiki\Lib\Renderer\InlineConverter;

class InlineFactory{
	public static function factory($string, $page = ''){
		global $vars;
		static $converter;
		if (!isset($converter)) $converter = new InlineConverter();
		$clone = $converter->getClone($converter);
		return $clone->convert($string, !empty($page) ? $page : $vars['page']);
	}
}

/* End of file InlineFactory.php */
/* Location: ./vender/PukiWiki/Lib/Renderer/InlineFactory.php */