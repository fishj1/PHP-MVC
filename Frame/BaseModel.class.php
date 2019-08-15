<?php
//定义抽象的基础模型类
abstract class BaseModel
{
	//受保护的保存数据库对象的属性
	protected $db = NULL;

	//构造方法
	public function __construct()
	{
		$this->db = Db::getInstance();
	}
}