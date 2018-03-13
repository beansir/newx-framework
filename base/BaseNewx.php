<?php
/**
 * BaseNewx
 * @author: bean
 * @version: 1.0
 */
namespace newx\base;

use newx\helpers\ArrayHelper;
use newx\orm\NewxOrm;

class BaseNewx
{
    /**
     * 应用主体
     * @var Application
     */
    private static $_app;

    /**
     * 第三方库
     * @var array
     */
    public static $thirdLibrary;

    /**
     * 类加载
     * @var array
     */
    public static $classLoads = [];

    /**
     * 加载基础数据
     */
    public static function load()
    {
        // 自动加载类
        require NEWX_PATH . '/base/AutoLoader.php';

        // 全局函数库
        require NEWX_PATH . '/function.php';

        // 第三方库名单
        static::$thirdLibrary = require NEWX_PATH . '/config/thirdLibrary.php';
    }

    /**
     * 运行应用主体
     * @param array $config 基础配置
     */
    public static function run($config = [])
    {
        // 加载ORM
        $db = ArrayHelper::value($config, 'database');
        NewxOrm::load($db);

        // 加载自定义函数库
        $file = APP_PATH . 'config/function.php';
        if (file_exists($file)) {
            require_once $file;
        }

        // 创建应用
        $app = new Application($config);
        $app->run();
    }

    /**
     * 配置应用主体
     * @param object $app 应用主体
     * @param array $configs 配置信息
     * @return bool
     */
    public static function setApp($app, $configs = [])
    {
        if (empty($configs)) {
            return false;
        }

        // 配置项
        foreach ($configs as $property => $config) {
            switch ($property) {
                // 组件
                case 'component':
                    $app->component = new Component($config);
                    break;
                default:
                    break;
            }
        }
        self::$_app = $app;

        return true;
    }

    /**
     * 获取应用主体
     * @return Application
     */
    public static function getApp()
    {
        return self::$_app;
    }

    /**
     * 配置对象属性
     * @param object $object
     * @param array $data
     * @return object
     */
    public static function set($object, $data = [])
    {
        if (!is_object($object) || empty($data) || !is_array($data)) {
            return $object;
        }
        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $object->{$key} = $value;
            }
        }
        return $object;
    }

    /**
     * 获取数据库连接
     * @param null $name
     * @return \newx\orm\base\Connection|null
     */
    public static function getDb($name = 'default')
    {
        return NewxOrm::getDb($name);
    }

    /**
     * 获取组件
     * @return Component
     */
    public static function getComponent()
    {
        return self::getApp()->component;
    }
}