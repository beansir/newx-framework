<?php
/**
 * Newx
 * @author: bean
 * @version: 1.0
 */

// 框架根目录
defined('NEWX_PATH') or define('NEWX_PATH', __DIR__);

require NEWX_PATH . '/base/BaseNewx.php';

class Newx extends \newx\base\BaseNewx {}

Newx::load();