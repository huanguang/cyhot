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
class BuyController extends HomeController {

	//发布信息首页
    public function index(){

        $lists    = D('Document')->lists(null);
        $Document = M('document');
        $category = M('category');
        //查询品牌出来
        $brandlist = $category->where('pid = 41')->select();
        
        $this->assign('brandlist',$brandlist);
        $get = I('get.');//接受筛选条件
        $type_id = 0;
        $brand_id = 0;
        $gearbox_id = 0;
        $carage_id = 0;
        $driven_id = 0;
        $price_id = 0;
        $where = array();
        $where_html = '';
        if(!empty($get['type_id'])){
        	$where['type_id'] = $get['type_id'];
        	$type_id = $get['type_id'];
        	$type_title = $Document->where('id = '.$type_id)->getField('title');
        	
        }
        if(!empty($get['brand_id'])){
        	$where['brand_id'] = $get['brand_id'];
        	//$where .= " AND brand_id = ".$get['brand_id'];
        	$brand_id = $get['brand_id'];
        	$brand_title = $category->where('id = '.$brand_id)->getField('title');
        	
        }
        if(!empty($get['gearbox_id'])){
        	$where['gearbox_id'] = $get['gearbox_id'];
        	//$where .= " AND gearbox_id = ".$get['gearbox_id'];
        	$gearbox_id = $get['gearbox_id'];
        	$gearbox_title = $Document->where('id = '.$gearbox_id)->getField('title');
        	
        }
        if(!empty($get['carage_id'])){
        	$where['carage_id'] = $get['carage_id'];
        	//$where .= " AND carage_id = ".$get['carage_id'];
        	$carage_id = $get['carage_id'];
        	$carage_title = $Document->where('id = '.$carage_id)->getField('title');
        	
        }
        if(!empty($get['driven_id'])){
        	$where['driven_id'] = $get['driven_id'];
        	//$where .= " AND driven_id = ".$get['driven_id'];
        	$driven_id = $get['driven_id'];
        	$driven_title = $Document->where('id = '.$driven_id)->getField('title');
        	
        }
        if(!empty($get['price_id'])){
        	$where['price_id'] = $get['price_id'];
        	//$where .= " AND price_id = ".$get['price_id'];
        	$price_id = $get['price_id'];
        	$price_title = $Document->where('id = '.$price_id)->getField('title');
        	

        }

        if(!empty($get['type_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Buy/index',array('type_id'=>0,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$type_title.'</a></dd>';

        if(!empty($get['brand_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Buy/index',array('type_id'=>$type_id,'brand_id'=>0,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$brand_title.'</a></dd>';

        if(!empty($get['gearbox_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Buy/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>0,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$gearbox_title.'</a></dd>';

        if(!empty($get['carage_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Buy/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>0,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$carage_title.'</a></dd>';

        if(!empty($get['driven_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Buy/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>0,'price_id'=>$price_id)).'">'.$driven_title.'</a></dd>';

        if(!empty($get['price_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Buy/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>0)).'">'.$price_title.'</a></dd>';

   
        //把对应的选中的信息查出来
        $this->assign('type_id',$type_id);
        $this->assign('brand_id',$brand_id);
        $this->assign('gearbox_id',$gearbox_id);
        $this->assign('carage_id',$carage_id);
        $this->assign('driven_id',$driven_id);
        $this->assign('price_id',$price_id);
        $this->assign('where_html',$where_html);
        $this->assign('lists',$lists);//列表
        $where['is_status'] = 1;
        $Buy = M('buying'); // 实例化buying对象
		$count      = $Buy->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$buylist = $Buy->where($where)->order('add_time')->limit($Page->firstRow.','.$Page->listRows)->select();
		//根据字段id查询属性名称
		
		foreach ($buylist as $key => $value) {
			$buylist[$key]['type'] =  $Document->where('id = '.$value['type_id'])->getField('title') ? :'不限';
			$buylist[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title') ? :'不限';
			$buylist[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title') ? :'不限';
			$buylist[$key]['carage'] =  $Document->where('id = '.$value['carage_id'])->getField('title') ? :'不限';
			$buylist[$key]['driven'] =  $Document->where('id = '.$value['driven_id'])->getField('title') ? :'不限';
			$buylist[$key]['price'] =  $Document->where('id = '.$value['price_id'])->getField('title') ? :'不限';
			$buylist[$key]['add_time'] = date('Y-m-d',$value['add_time']);
		}
		$this->assign('buylist',$buylist);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    //发布信息
    public function add(){
        if ( !is_login() ) {
            $this->error( '您还没有登陆',U('User/login') );
        }
        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);
        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $Category  = M('category');
        $list = $Category->where('pid = 41')->select();
        
        //print_r($lists);die;
        $this->assign('list',$list);//品牌
        //print_r($lists)
        $this->assign('page',D('Document')->page);//分页

        $this->display();
    }

    //信息详情
    public function details(){

       $get = I('get.');

       $buytable  = M('buying');
       $buylinfo = $buytable->where('id = '.$get['id'])->find();
       //格式化数据
      		$Document = M('document');
       		$buylinfo['type'] =  $Document->where('id = '.$buylinfo['type_id'])->getField('title') ? :'不限';
			$buylinfo['brand'] =  $Document->where('id = '.$buylinfo['brand_id'])->getField('title') ? :'不限';
			$buylinfo['gearbox'] =  $Document->where('id = '.$buylinfo['gearbox_id'])->getField('title') ? :'不限';
			$buylinfo['carage'] =  $Document->where('id = '.$buylinfo['carage_id'])->getField('title') ? :'不限';
			$buylinfo['driven'] =  $Document->where('id = '.$buylinfo['driven_id'])->getField('title') ? :'不限';
			$buylinfo['price'] =  $Document->where('id = '.$buylinfo['price_id'])->getField('title') ? :'不限';
			$buylinfo['add_time'] = date('Y-m-d  H:i:s',$buylinfo['add_time']);

			if($buylinfo['maintenance'] == 1){
				$buylinfo['maintenance'] = '是';
			}else{
				$buylinfo['maintenance'] = '否';
			}
			//查询同类型求购信息
			$buytypelist = $buytable->where('type_id = '.$buylinfo['type_id'])->order('add_time desc')->limit(10)->select();

			foreach ($buytypelist as $key => $value) {
				$buytypelist[$key]['type'] =  $Document->where('id = '.$value['type_id'])->getField('title') ? :'不限';
				$buytypelist[$key]['brand'] =  $Document->where('id = '.$value['brand_id'])->getField('title') ? :'不限';
				$buytypelist[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title') ? :'不限';
				$buytypelist[$key]['carage'] =  $Document->where('id = '.$value['carage_id'])->getField('title') ? :'不限';
				$buytypelist[$key]['driven'] =  $Document->where('id = '.$value['driven_id'])->getField('title') ? :'不限';
				$buytypelist[$key]['price'] =  $Document->where('id = '.$value['price_id'])->getField('title') ? :'不限';
				$buytypelist[$key]['add_time'] = date('Y-m-d  H:i:s',$value['add_time']);
				if($value['id'] == $get['id']){
					unset($buytypelist[$key]);
				}
			}

			$this->assign('buytypelist',$buytypelist);
      	 $this->assign('buylinfo',$buylinfo);
        $this->display();
    }

    //发布信息添加处理加入数据库
    public function addinfo(){
    	$post = I('post.');
        $Document = M('document');
        $category = M('category');
    	if($post['brand_id'] == 0){
    		$this->error('必须选择车辆品牌');
    	}
    	if($post['contacts'] == ''){
    		$this->error('必须填写联系人');
    	}
    	if($post['contactnumber'] == ''){
    		$this->error('必须填写联系人电话');
    	}
    	$isMob="/^1[3-5,8]{1}[0-9]{9}$/";
 		$isTel="/^([0-9]{3,4}-)?[0-9]{7,8}$/";
    	if(!preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $post['contactnumber']) && !preg_match($isMob,$post['contactnumber']) && !preg_match($isTel,$post['contactnumber'])){
    		$this->error('联系电话不是一个手机号码，也不是一个电话号码，请重新填写');
    	}
        $uid        =   is_login();
        $post['uid'] = $uid;   	
        $business = M('business');
        $business_status = $business->where('user_id = '.$post['uid'])->getField('is_status') ? :' ';
            if($business_status == 2){
                
                $post['danx1'] = 1;
            }else{
                $post['danx1'] = 0;
            }

    	if($post['address'] == ''){
    		$this->error('必须填写车辆所在地址');
    	}
    	 //把有关信息，拼成一个title插入数据库 
            //把相应的信息查询出来
            $type = $Document->where('id = '.$post['type_id'])->getField('title') ? :' ';
            $brand = $category->where('id = '.$post['brand_id'])->getField('title') ? :' ';

            $gearbox = $Document->where('id = '.$post['gearbox_id'])->getField('title') ? :' ';
            $price = $Document->where('id = '.$post['price_id'])->getField('title') ? :' ';
            $driven = $Document->where('id = '.$post['driven_id'])->getField('title') ? :' ';
            $carage = $Document->where('id = '.$post['carage_id'])->getField('title') ? :' ';
           	$post['title'] = $type.' '.$brand.' '.$gearbox.' '.$carage.' '.$driven.' '.$price;
		    $post['add_time'] = time();
		    //插入数据库
		    $m = M("buying");

			if(empty($m->add($post))){
				$this->error('服务器错误，请稍后重试！');
			}


			$this->success('提交成功！！',U('Buy/index'));			
        
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