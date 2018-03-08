<h2 align="center">NewX Framework</h2>

## 安装说明
使用composer一键安装
```
composer require beansir/newx-framework
```

## 目录结构
* app // 应用目录（可自定义）
    * config // 配置目录
        * component.php // 组件配置 
        * config.php // 配置文件
        * database.php // 数据库配置
        * function.php // 自定义全局函数
    * controllers // 控制器目录
        * HomeController.php // 默认控制器（可于应用配置中更改）
    * models // 模型目录
    * views // 视图目录
        * home // 控制器视图目录
            * index.php 视图文件
        * layout.php // 视图布局文件
    * public // 资源目录
        * index.php // 入口文件

## MVC（Model View Controller）

#### 控制器 Controller
```php
<?php
namespace app\controllers; // 命名空间必须与应用文件夹名以及应用配置中的应用名称保持一致
use newx\base\BaseController;
class HomeController extends BaseController // 控制器首字母大写并以Controller为后缀，继承框架底层控制器基类
{
    public function actionIndex() // 方法名首字母大写并以action为前缀
    {
        $data = [];
        
        // 方式一 布局视图渲染
        $this->layout = 'test'; // 自定义布局文件名，默认layout，也可以目录形式命名，例如：test/test
        $output = $this->view('index', $data);
        
        // 方式二 非布局视图渲染
        $output = $this->view('index', $data, false);
        
        return $output;
    }
}
```

#### 模型 Model
```php
<?php
namespace app\models;
use newx\orm\base\Model;
class UserModel extends Model // 模型首字母大写并以Model为后缀，继承框架底层模型基类
{
    public $table = 'user'; // 数据表
    public $db = 'default'; // 数据库配置
}
```
简洁优雅的数据库交互用法请参考[NewX ORM文档](https://github.com/BeanYellow/newx-orm)

## AES数据加密
```php
<?php
$aes = new \newx\mcrypt\Aes(); // 默认CBC模式
$str = $aes->encrypt($str); // 加密（加密后默认base64编码，可用第二个参数更改）
$str = $aes->decrypt($str); // 解密
```