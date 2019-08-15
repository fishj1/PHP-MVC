<?php
//定义最终的框架初始类
final class Frame
{
	//公共的静态的初始化方法
	public static function run()
	{
		self::initCharset();	//初始化字符集设置
		self::initConfig();		//初始化配置信息
		self::initRoute();		//初始化路由参数
		self::initConst();		//初始化目录常量设置
		self::initAutoLoad();	//初始化类的自动加载
		self::initDispatch();	//初始化请求分发
	}

	//初始化字符集设置
	private static function initCharset()
	{
		header("content-type:text/html;charset=utf-8");
	}

	//初始化配置信息
	private static function initConfig()
	{
		$GLOBALS['config'] = require_once("./App/Conf/Config.php");
	}

	//初始化路由参数
	private static function initRoute()
	{
		$p = isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['default_platform'];   //平台参数
		$c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];	//控制器参数
		$a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];		//用户动作参数
		define("PLAT",$p);  //平台常量，常量可以在任何地方使用
		define("CONTROLLER",$c);
		define("ACTION",$a);
	}

	//初始化目录常量
	private static function initConst()
	{
		define("DS",DIRECTORY_SEPARATOR); //目录分割符，跟随操作系统变化
		define("ROOT_PATH",getcwd()); //网站根目录
		define("FRAME_PATH",ROOT_PATH.DS."Frame".DS); //Frame目录
		define("APP_PATH",ROOT_PATH.DS."App".DS); //App目录
		define("CONTROLLER_PATH",APP_PATH.PLAT.DS."Controller".DS); //Controller目录
		define("MODEL_PATH",APP_PATH.PLAT.DS."Model".DS); //Model目录
		define("VIEW_PATH",APP_PATH.PLAT.DS."View".DS.CONTROLLER.DS); //View目录		
	}

	//初始化类的自动加载
	private static function initAutoLoad()
	{
		spl_autoload_register(function($className){
			//构建类文件路径数组
			$arr = array(
				FRAME_PATH."$className.class.php",
				MODEL_PATH."$className.class.php",
				CONTROLLER_PATH."$className.class.php",
			);
			//循环判断当前类文件是否存在
			foreach($arr as $filename)
			{
				//如果类文件存在，则包含
				if(file_exists($filename)) require_once($filename);
			}
		});		
	}

	//初始化请求分发
	private static function initDispatch()
	{
		//创建控制器类的对象
		$controllerClassName = CONTROLLER . "Controller"; 
		$controllerObj = new $controllerClassName();

		//调用控制器对象的不同方法
		$actionName = ACTION;
		$controllerObj->$actionName();		
	}
}