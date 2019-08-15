<?php
//定义最终的新闻控制器类，并继承基础控制器类
final class NewsController extends BaseController
{
	//显示列表
	public function index()
	{
		$modelObj = FactoryModel::getInstance('NewsModel');
		$arrs = $modelObj->fetchAll();
		include VIEW_PATH."index.html";
	}

	//删除记录
	public function delete()
	{
		$id = $_GET['id'];
		$modelObj = FactoryModel::getInstance('NewsModel');
		if($modelObj->delete($id))
		{
			$this->jump("id={$id}记录删除成功！","?p=Home&c=News");
		}else{
			$this->jump("id={$id}记录删除失败！","?p=Home&c=News");			
		}
	}
}