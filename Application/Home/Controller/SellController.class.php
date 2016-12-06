<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台发布信息首页控制器
 * 主要获取发布信息首页聚合数据
 */
class SellController extends HomeController {

	//发布信息首页
    public function index(){

        $lists    = D('Document')->lists(null);

        $this->assign('lists',$lists);//列表
        $User = M('sell'); // 实例化User对象
		$count      = $User->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,1);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$selllist = $User->order('add_time')->limit($Page->firstRow.','.$Page->listRows)->select();

		//查询信息的一张图片
		$albumtable  = M('album');
		foreach ($selllist as $key => $value) {
				$selllist[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
		}
		$this->assign('selllist',$selllist);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    //发布信息
    public function add(){

        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);
        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页

        $this->display();
    }

    //信息详情
    public function details(){

       $get = I('get.');
       $albumtable  = M('album');
       $imglist = $albumtable->where('sell_id = '.$get['id'])->select();
       $this->assign('imglist',$imglist);//相册
       $selltable  = M('sell');
       $sellinfo = $selltable->where('id = '.$get['id'])->find();
       $this->assign('sellinfo',$sellinfo);
        $this->display();
    }

    //发布信息添加处理加入数据库
    public function addinfo(){
    	$post = I('post.');


    	if(!$post['img']){
    		$this->error('车辆图片最少上传一张');
    	}

    	if(empty($post['brand_id'])){
    		$this->error('车辆品牌必须选择');
    	}
    	if($post['colour'] == ''){
    		$this->error('车辆颜色必须选择');
    	}
    	if($post['years'] == ''){
    		$this->error('车辆首次上牌年份必须填写');
    	}
    	if($post['driven'] == ''){
    		$this->error('车辆行驶里程必须填写');
    	}
    	if($post['sfer_price'] == ''){
    		$this->error('车辆转让价格必须填写');
    	}
    	if($post['description'] == ''){
    		$this->error('车辆补充说明必须填写');
    	}
    	if($post['contacts'] == ''){
    		$this->error('车辆联系人必须填写');
    	}
    	if($post['contact_number'] == ''){
    		$this->error('车辆联系电话必须填写');
    	}
    	if($post['address'] == ''){
    		$this->error('看车地址必须填写');
    	}

    	if($_FILES['license']['error'] > 0){
    		$this->error('车辆行驶证图片上传错误，请从新选择图片上传');
    	}

    	if($_FILES['frame']['error'] > 0){
    		$this->error('车辆行驶证图片上传错误，请从新选择图片上传');
    	}

    	vendor("FileUpload.FileUpload");


			$up = new \FileUpload;
			

		    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)

		    $lu = date('Ymd');
		    $mode = '0777';
		    $dir = './Uploads/sellimg/'.$lu.'/';
		    if (!is_dir($dir)){
		    	@mkdir($dir, $mode);
		    }

		    $up -> set("path",$dir);
		    $up -> set("maxsize", 2000000);
		    $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
		    $up -> set("israndname", true);
		  
		    //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
		    if($up -> upload("license")) {
		    	$post['license'] = $up->getFileName();
		    }

		    if($up -> upload("frame")) {
		    	$post['frame'] = $up->getFileName();
		    }
		    $img = $post['img'];

		    unset($post['img']);
		    $post['add_time'] = time();
		    //插入数据库
		    $m = M("sell");

			$id = $m->add($post);

			$a = M("album");
			//加入相册信息
			for ($i=0; $i < count($img); $i++) { 
				$arr = array(
						'imgurl'=>$img[$i],
						'sell_id'=>$id
					);
				$a->add($arr);
			}

			$this->sussecc('提交成功！！',U('Sell/index'));
			


        
    }

    //文件上传
    public function fileupload(){

        vendor("FileUpload.FileUpload");


			$up = new \FileUpload;
			

		    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)

		    $lu = date('Ymd');
		    $mode = '0777';
		    $dir = './Uploads/sellimg/'.$lu.'/';
		    if (!is_dir($dir)){
		    	@mkdir($dir, $mode);
		    }

		    $up -> set("path",$dir);
		    $up -> set("maxsize", 2000000);
		    $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
		    $up -> set("israndname", true);
		  
		    //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
		    if($up -> upload("file")) {
		        //获取上传后文件名子
		        $imgname = $up->getFileName();
		        $arr = array("imgname"=>$imgname,'error'=>'0','msg'=>'上传成功！');
		        echo json_encode($arr);die; 
		        //echo '</pre>';
		    } else {

		        //获取上传失败以后的错误提示
		        
		        $arr = array("imgname"=>$imgname,'error'=>1,'msg'=>$up->getErrorMsg());
		        echo json_encode($arr);die;
		    }

    }

}