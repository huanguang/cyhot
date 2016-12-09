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
        $Document = M('document');
        $category = M('category');
        $member = M('member');
        $document_attrib = M('document_attrib');
        //查询品牌出来
        $brandlist = $category->where('pid = 41')->select();
        //接收搜索条件
        $post = I('post.');

        //keyword
        $this->assign('brandlist',$brandlist);
        $get = I('get.');//接受筛选条件
        $type_id = 0;
        $brand_id = 0;
        $gearbox_id = 0;
        $carage_id = 0;
        $driven_id = 0;
        $price_id = 0;
        $displacement_id = 0;
        $where = array();
        $where_html = '';
        if(!empty($get['type_id'])){
        	$where['type_id'] = $get['type_id'];
        	$type_id = $get['type_id'];
        	$type_title = $Document->where('id = '.$type_id)->getField('title');

        }
        if(!empty($get['displacement_id'])){

                $displacement_info = $document_attrib->where('id = '.$get['displacement_id'])->find();


            if(!empty($displacement_info)){
                if($displacement_info['min'] == 0 && $displacement_info['max'] > 0){
                    $where['displacement_id'] = array('lt',$displacement_info['max']/10);
                }elseif($displacement_info['max'] == 0 && $displacement_info['min'] > 0){
                    $where['displacement_id'] = array('gt',$displacement_info['min']/10);
                }elseif($displacement_info['min'] > 0 && $displacement_info['max'] > 0){
                    $where['displacement_id'] = array('gt',$displacement_info['min']/10);
                    $where['displacement_id'] = array('lt',$displacement_info['max']/10);
                }
            }
            //print_r($get['displacement_id']);die;
        	$where['displacement_id'] = $get['displacement_id'];
        	$displacement_id = $get['displacement_id'];
        	$displacement_title = $Document->where('id = '.$displacement_id)->getField('title');

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
            $document_attrib_info = $document_attrib->where('id = '.$get['price_id'])->find();

            if(!empty($document_attrib_info)){
                if($document_attrib_info['min'] == 0 && $document_attrib_info['max'] > 0){
                    $where['sfer_price'] = array('lt',$document_attrib_info['max']/10000);
                }elseif($document_attrib_info['max'] == 0 && $document_attrib_info['min'] > 0){
                    $where['sfer_price'] = array('gt',$document_attrib_info['min']/10000);
                }elseif($document_attrib_info['min'] > 0 && $document_attrib_info['max'] > 0){
                    $where['sfer_price'] = array('gt',$document_attrib_info['min']/10000);
                    $where['sfer_price'] = array('lt',$document_attrib_info['max']/10000);
                }
            }
            //print_r($document_attrib_info);die;
        	//$where['price_id'] = $get['price_id'];
        	//$where .= " AND price_id = ".$get['price_id'];
        	$price_id = $get['price_id'];
        	$price_title = $Document->where('id = '.$price_id)->getField('title');


        }

        if(!empty($get['type_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Sell/index',array('type_id'=>0,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$type_title.'</a></dd>';

        if(!empty($get['brand_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Sell/index',array('type_id'=>$type_id,'brand_id'=>0,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$brand_title.'</a></dd>';

        if(!empty($get['gearbox_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Sell/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>0,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$gearbox_title.'</a></dd>';

        if(!empty($get['carage_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Sell/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>0,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$carage_title.'</a></dd>';

        if(!empty($get['driven_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Sell/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>0,'price_id'=>$price_id)).'">'.$driven_title.'</a></dd>';

        if(!empty($get['price_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Sell/index',array('type_id'=>$type_id,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>0)).'">'.$price_title.'</a></dd>';

        if(!empty($get['displacement_id'])) $where_html .= '<dd class="selected" id="selectF"><a href="'.U('Sell/index',array('type_id'=>0,'brand_id'=>$brand_id,'gearbox_id'=>$gearbox_id,'carage_id'=>$carage_id,'driven_id'=>$driven_id,'price_id'=>$price_id)).'">'.$displacement_title.'</a></dd>';


        //把对应的选中的信息查出来
        $this->assign('type_id',$type_id);
        $this->assign('brand_id',$brand_id);
        $this->assign('gearbox_id',$gearbox_id);
        $this->assign('carage_id',$carage_id);
        $this->assign('driven_id',$driven_id);
        $this->assign('price_id',$price_id);
        $this->assign('displacement_id',$displacement_id);
        $this->assign('where_html',$where_html);


        if($keyword = $post['keyword']){
            $where1['colour'] = array('like','%'.$keyword.'%');
            $where1['type'] = array('like','%'.$keyword.'%');
            $where1['brand_model_title'] = array('like','%'.$keyword.'%');
            $where1['driven'] = array('like','%'.$keyword.'%');
            $where1['gearbox'] = array('like','%'.$keyword.'%');
            $where1['level'] = array('like','%'.$keyword.'%');
            //$where1['WERWE'] = array('like','%'.$keyword.'%');
            $where1['_logic'] = 'or';

            $where['_complex'] = $where1;
            $this->assign('keyword',$keyword);
        }




        $this->assign('lists',$lists);//列表
        $User = M('sell'); // 实例化User对象
		$count      = $User->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$selllist = $User->join()->where($where)->order('add_time')->limit($Page->firstRow.','.$Page->listRows)->select();



		//查询信息的一张图片
		$albumtable  = M('album');
		$category  = M('category');
		foreach ($selllist as $key => $value) {
				$selllist[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
				$selllist[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title');
				$selllist[$key]['brand_model'] =  $Document->where('id = '.$value['brand_model'])->getField('title');
				$selllist[$key]['level'] =  $Document->where('id = '.$value['level_id'])->getField('title');
				$selllist[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title');

                //判断用户是商家还是个人，
               $status = $member->where('uid = '.$value['uid'])->getField('is_status');
               if($status == 2){
                  $selllist[$key]['status'] = '认证';  
               }else{
                    $selllist[$key]['status'] = ''; 
               }

		}

		$this->assign('selllist',$selllist);// 赋值数据集
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
		$Category  = M('category');
		$list = $Category->where('pid = 41')->select();
        //print_r($lists);die;
		$this->assign('list',$list);//品牌

        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页

        $this->display();
    }
    //获取品牌下的类型车
    public function brandsubordinate(){
    	$post = I('post.');
    	$document  = M('document');
    	$list = $document->where('category_id = '.$post['id'])->select();
    	if(!empty($list)){
    		$arr = array('list'=>$list,'error'=>0,'msg'=>'获取成功');
    		echo json_encode($list);die;
    	}else{
    		$arr = array('list'=>array(),'error'=>1,'msg'=>'没有获取到数据');
    		echo json_encode($list);die;
    	}
    }

    //信息详情
    public function details(){

       $get = I('get.');
       $albumtable  = M('album');
       $member  = M('member');
       $Document = M('document');
       $category = M('category');
       $imglist = $albumtable->where('sell_id = '.$get['id'])->select();
       $this->assign('imglist',$imglist);//相册
       $selltable  = M('sell');
       $sellinfo = $selltable->where('id = '.$get['id'])->find();
       //print_r($sellinfo);
       $sellinfo['displacement'] = $Document->where('id = '.$sellinfo['displacement_id'])->getField('title') ? :'';
       $sellinfo['gearbox'] = $Document->where('id = '.$sellinfo['gearbox_id'])->getField('title') ? :'';
       $sellinfo['brand_model_title'] = $Document->where('id = '.$sellinfo['brand_model'])->getField('title') ? :'';
       $sellinfo['level'] = $Document->where('id = '.$sellinfo['level_id'])->getField('title') ? :'';
       $sellinfo['brand'] = $category->where('id = '.$sellinfo['brand_id'])->getField('title') ? :'';

<<<<<<< HEAD

 		
=======
>>>>>>> 05bbdae329a344e62880631715e3eab5b20a39cb
       //查询同品牌信息
       $sellbrandlist = $selltable->where('brand_id = '.$sellinfo['brand_id'])->order('add_time desc')->limit(12)->select();
       foreach ($sellbrandlist as $key => $value) {
       			//查询第一张图片
       			$sellbrandlist[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
				$sellbrandlist[$key]['type'] =  $Document->where('id = '.$value['type_id'])->getField('title') ? :'';
				$sellbrandlist[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title') ? :'';
				$sellbrandlist[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title') ? :'';
				$sellbrandlist[$key]['carage'] =  $Document->where('id = '.$value['carage_id'])->getField('title') ? :'';

				$sellbrandlist[$key]['brand_model_title'] =  $Document->where('id = '.$value['brand_model'])->getField('title') ? :'';
				$sellbrandlist[$key]['level'] =  $Document->where('id = '.$value['level_id'])->getField('title') ? :'';
				$sellbrandlist[$key]['add_time'] = date('Y-m-d  H:i:s',$value['add_time']);
                //判断用户是商家还是个人，
               $status = $member->where('uid = '.$value['uid'])->getField('is_status');
               if($status == 2){
                  $sellbrandlist[$key]['status'] = '认证';  
               }else{
                    $sellbrandlist[$key]['status'] = ''; 
               }
				if($value['id'] == $get['id']){
					unset($sellbrandlist[$key]);
				}
			}

			//查询同类型的热门二手车推荐
			$selltypelist = $selltable->where('type_id = '.$sellinfo['type_id'])->order('add_time desc')->limit(6)->select();
			foreach ($sellbrandlist as $key => $value) {
       			//查询第一张图片
       			$selltypelist[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
				$selltypelist[$key]['type'] =  $Document->where('id = '.$value['type_id'])->getField('title') ? :'';
				$selltypelist[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title') ? :'';
				$selltypelist[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title') ? :'';
				$selltypelist[$key]['carage'] =  $Document->where('id = '.$value['carage_id'])->getField('title') ? :'';
				$selltypelist[$key]['brand_model_title'] =  $Document->where('id = '.$value['brand_model'])->getField('title') ? :'';
				$selltypelist[$key]['level'] =  $Document->where('id = '.$value['level_id'])->getField('title') ? :'';


				$selltypelist[$key]['add_time'] = date('Y-m-d  H:i:s',$value['add_time']);
                //判断用户是商家还是个人，
               $status = $member->where('uid = '.$value['uid'])->getField('is_status');
               if($status == 2){
                  $selltypelist[$key]['status'] = '认证';  
               }else{
                    $selltypelist[$key]['status'] = ''; 
               }
				if($value['id'] == $get['id']){
					unset($selltypelist[$key]);
				}
			}

       $this->assign('sellinfo',$sellinfo);
       var_dump($sellinfo);
       $this->assign('selltypelist',$selltypelist);
       $this->assign('sellbrandlist',$sellbrandlist);
        $this->display();
    }

    //发布信息添加处理加入数据库
    public function addinfo(){
    	$post = I('post.');

        $Document = M('document');
    	if(!$post['img']){
    		$this->error('车辆图片最少上传一张');
    	}

    	if(empty($post['brand_id'])){
    		$this->error('车辆品牌必须选择');
    	}
    	if(empty($post['brand_model'])){
    		$this->error('车辆品牌型号必须选择');
    	}
    	if(empty($post['level_id'])){
    		$this->error('车辆级别必须填写');
    	}

    	if(empty($post['year_id'])){
    		$this->error('车辆级别必须填写');
    	}
        if(empty($post['type_id'])){
            $this->error('车辆类型必须填写');
        }

    	if(empty($post['gearbox_id'])){
    		$this->error('车辆变速箱必须填写');
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

    	if(empty($post['displacement_id'])){
    		$this->error('车辆排量必须填写');
    	}
    	if(empty($post['insurance_endtime'])){
    		$this->error('交强险到期时间必须填写');
    	}
    	if(empty($post['inspection_endtime'])){
    		$this->error('年检到期时间必须填写');
    	}
    	if(empty($post['business_endtime'])){
    		$this->error('商业险到期时间必须填写');
    	}

    	if($post['sfer_price'] == ''){
    		$this->error('车辆转让价格必须填写');
    	}
    	if($post['new_price'] == ''){
    		$this->error('新车价格必须填写');
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

        $Document = M('document');
        $category = M('category');
        $post['type'] = $Document->where('id = '.$post['type_id'])->getField('title') ? :'';

        $post['gearbox'] = $Document->where('id = '.$post['gearbox_id'])->getField('title') ? :'';
        $post['level'] = $Document->where('id = '.$post['level_id'])->getField('title') ? :'';
        $post['brand_model_title'] = $Document->where('id = '.$post['brand_model'])->getField('title') ? :'';
<<<<<<< HEAD
        $uid        =   is_login();
        $post['uid'] = $uid;
        //把有关信息，拼成一个title插入数据库 
            //把相应的信息查询出来
            $brand = $category->where('id = '.$post['brand_id'])->getField('title') ? :' ';
            
            $post['title'] = $brand.' '.$post['brand_model_title'].' '.$post['year_id'].' '.$post['displacement_id'].' '.$post['gearbox'].' '.$post['level'];
        
=======

>>>>>>> 05bbdae329a344e62880631715e3eab5b20a39cb
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
		    	$post['license'] = $lu.'/'.$up->getFileName();
		    }

		    if($up -> upload("frame")) {
		    	$post['frame'] = $lu.'/'.$up->getFileName();
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

			$this->success('提交成功！！',U('Sell/index'));




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
		        $arr = array("imgname"=>$lu.'/'.$imgname,'error'=>'0','msg'=>'上传成功！');
		        echo json_encode($arr);die;
		        //echo '</pre>';
		    } else {

		        //获取上传失败以后的错误提示

		        $arr = array("imgname"=>$imgname,'error'=>1,'msg'=>$up->getErrorMsg());
		        echo json_encode($arr);die;
		    }

    }

}