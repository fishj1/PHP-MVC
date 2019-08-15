<?php
//定义最终的学生控制器类,并继承基础控制器类
final class StudentController extends BaseController
{
	//显示列表
	public function index()
	{
		$modelObj = FactoryModel::getInstance("StudentModel");
		$arrs = $modelObj->fetchAll();
		include VIEW_PATH."index.html";
	}

	//显示添加的表单
	public function add()
	{
		include VIEW_PATH."add.html";
	}

	//插入数据
	public function insert()
	{
		//获取表单提交值
		$data['name']	= $_POST['name'];
		$data['sex']	= $_POST['sex'];
		$data['age']	= $_POST['age'];
		$data['edu']	= $_POST['edu'];
		$data['salary'] = $_POST['salary'];
		$data['bonus']	= $_POST['bonus'];
		$data['city']	= $_POST['city'];
		//创建模型类对象
		$modelObj = FactoryModel::getInstance("StudentModel");
		//写入数据
		if($modelObj->insert($data))
		{
			$this->jump("学生信息添加成功！","?p=Admin&c=Student");
		}else{
			$this->jump("学生信息添加失败！","?p=Admin&c=Student");
		}
	}

	//显示修改的表单
	public function edit()
	{
		//获取地址栏传递的id
		$id = $_GET['id'];
		//创建模型类对象
		$modelObj = FactoryModel::getInstance("StudentModel");
		//获取指定id的数据
		$arr = $modelObj->fetchOne($id);
		//加载视图文件
		include VIEW_PATH."edit.html";
	}

	//更新数据
	public function update()
	{
		//获取表单提交值
		$id				= $_POST['id'];
		$data['name']	= $_POST['name'];
		$data['sex']	= $_POST['sex'];
		$data['age']	= $_POST['age'];
		$data['edu']	= $_POST['edu'];
		$data['salary']	= $_POST['salary'];
		$data['bonus']	= $_POST['bonus'];
		$data['city']	= $_POST['city'];
		//创建模型类对象
		$modelObj = FactoryModel::getInstance("StudentModel");
		//判断记录是否更新成功
		if($modelObj->update($data,$id))
		{
			$this->jump("id={$id}记录更新成功！","?p=Admin&c=Student");
		}else
		{
			$this->jump("id={$id}记录更新失败！","?p=Admin&c=Student");
		}
	}

	//删除记录
	public function delete()
	{
		$id = $_GET['id'];
		$modelObj = FactoryModel::getInstance("StudentModel");
		if($modelObj->delete($id))
		{
			$this->jump("id={$id}记录删除成功！","?p=Admin&c=Student");
		}else{
			$this->jump("id={$id}记录删除失败！","?p=Admin&c=Student");
		}	
	}
}