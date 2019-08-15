<?php
//定义最终的工厂模型类
final class FactoryModel
{
	//私有的静态的保存不同对象的数组属性
	private static $arrModelObj = array();
	
	//公共的静态的创建不同模型类对象的方法
	public static function getInstance($modelClassName)
	{
		/*
			self::$arrModelObj['StudentModel'] = 学生模型类对象
			self::$arrModelObj['NewsModel']    = 新闻模型类对象
		*/
		//判断当前模型类对象是否存在
		if(!isset(self::$arrModelObj[$modelClassName])){
			//如果当前模型类对象不存在，则创建并保存它
			self::$arrModelObj[$modelClassName] = new $modelClassName();
		}
		//返回当前模型类对象
		return self::$arrModelObj[$modelClassName];
	}
}