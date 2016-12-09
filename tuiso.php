<?php

$mysql_host='192.168.0.159';        //host name
$mysql_user='qbtcyh';     //login name
$mysql_pwd='qbtcyh';      //password
$mysql_db='qbt_ot';       //name of database
$db_path=mysql_connect ($mysql_host,$mysql_user,$mysql_pwd);//链接数据库
$table_db=$mysql_db;

mysql_query("SET NAMES utf8");//编码

$conn=$db_path;
if (!$conn)
  {
  die('错误提示: ' . mysql_error());
  }
mysql_select_db($table_db,$conn);


$time = 60;
$sql = " SELECT id,is_outdate,add_time,uid FROM onethink_buying WHERE is_outdate = 0 ";
$data = get_all($sql );
if(!empty($data)){
        foreach ($data as $key => $value) {
            if($value["add_time"] > $time){
                 $query = " UPDATE  onethink_buying SET is_outdate=1 WHERE id =".$value["id"];

             $id  =   $result = mysql_query($query);
               $data = array(
                    'uid'  => $value['uid'],
                    'from'  => '管理员',
                    'content' => '您发布的求购消息已过期',
                    'release_time'  =>  $value['add_time'],
                );
    $sql ="INSERT INTO onethink_xinxi (`uid`,`from`,`content`,`release_time`) VALUES('{$value['uid']}','管理员','您发布的求购消息已过期','{$value['add_time']}')";
               $result = mysql_query($sql);
            }
        }
}




function get_all($sql){
    global $conn;
    //$sql='SELECT * FROM '.$table.' ORDER BY number ASC';//查询语句 从student 表中选择所有数据
    $res=mysql_query($sql,$conn);//执行查询
    $data=array();//建立一个数组用于存放数据库的查询结果
    if($res && mysql_num_rows($res)>0){ //mysql_num_rows()函数用于获取查询返回的记录数;
        while($temp=mysql_fetch_assoc($res)){
            $data[]=$temp;
        }
    }
    //mysql_free_result($res); //释放结果集
    return $data;
}

