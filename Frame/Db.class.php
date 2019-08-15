<?php
//定义最终的单例的数据库工具类
final class Db
{
	//私有的静态的保存对象的属性
	private static $obj = NULL;

	//私有的数据库配置信息
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	private $charset;

	//私有的构造方法：阻止类外new对象
	private function __construct()
	{
		$this->db_host = $GLOBALS['config']['db_host'];
		$this->db_user = $GLOBALS['config']['db_user'];
		$this->db_pass = $GLOBALS['config']['db_pass'];
		$this->db_name = $GLOBALS['config']['db_name'];
		$this->charset = $GLOBALS['config']['charset'];
		$this->connectDb(); //连接MySQL服务器
		$this->selectDb();  //选择数据库
		$this->setCharset();//设置字符集
	}

	//私有的克隆方法：阻止类外clone对象
	private function __clone(){}

	//公共的静态的创建对象的方法
	public static function getInstance()
	{
		//判断当前对象是否存在
		if(!self::$obj instanceof self){
			//如果对象不存在，则创建它
			self::$obj = new self();
		}
		//如果对象存在，直接返回
		return self::$obj;
	}

	//私有的连接MySQL服务器的方法
	private function connectDb()
	{
		if(!@mysql_connect($this->db_host,$this->db_user,$this->db_pass))
			die("PHP连接MySQL服务器失败！");
	}

	//私有的选择数据库的方法
	private function selectDb()
	{
		if(!mysql_select_db($this->db_name))
			die("选择数据库{$this->db_name}失败！");
	}

	//私有的设置字符集
	private function setCharset()
	{
		$this->exec("SET NAMES {$this->charset}");
	}

	//公共的执行SQL语句的方法：insert、update、delete、set、create、drop等
	//返回结果是布尔值
	public function exec($sql)
	{
		//将SQL语句转成全小写：$sql = "select * from student"
		$sql = strtolower($sql);
		//判断SQL语句是不是SELECT语句
		if(substr($sql,0,6)=='select')	{
			die("该方法不能执行SELECT语名");
		}
		//执行SQL语句，并返回布尔值
		return mysql_query($sql);
	}

	//私有的执行SQL语句的方法：select
	//返回的结果是结果集
	private function query($sql)
	{
		//将SQL语句转成全小写：$sql = "select * from student"
		$sql = strtolower($sql);
		//判断SQL语句是不是SELECT语句
		if(substr($sql,0,6)!='select')	{
			die("该方法不能执行非SELECT语名");
		}
		//执行SQL语句，并返回结果集
		return mysql_query($sql);
	}

	//公共的获取单行记录的方法(一维数组)
	public function fetchOne($sql,$type=3)
	{
		//执行SQL语句，并返回结果集
		$result = $this->query($sql);

		//定义返回的数组的类型
		$types = array(
			1	=> MYSQL_NUM,
			2	=> MYSQL_BOTH,
			3	=> MYSQL_ASSOC,
		);

		//返回一条记录
		return mysql_fetch_array($result,$types[$type]);
	}

	//公共的获取多行记录的方法(二维数组)
	public function fetchAll($sql,$type=3)
	{
		//执行SQL语句，并返回结果集
		$result = $this->query($sql);

		//定义返回的数组的类型
		$types = array(
			1	=> MYSQL_NUM,
			2	=> MYSQL_BOTH,
			3	=> MYSQL_ASSOC,
		);

		//循环从结果集中取出所有记录，并存入一个新数组中
		while($row=mysql_fetch_array($result,$types[$type]))
		{
			$arrs[] = $row;
		}

		//返回二维数组
		return $arrs;
	}

	//公共的获取记录数的方法
	public function rowCount($sql)
	{
		//执行SQL语句，并返回结果集
		$result = $this->query($sql);
		//返回记录数
		return mysql_num_rows($result);
	}
}