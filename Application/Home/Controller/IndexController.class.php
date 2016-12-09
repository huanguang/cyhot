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
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){

        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);
        $Document = M('document');
        $member = M('member');
        $sell  = M('sell');
        $this->assign('category',$category);//栏目
        //print_r($lists);die;
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页
        $getlist = I('get.');
        $where = '';
        if($getlist['brand_k']) $where = " and name LIKE '%".$getlist['brand_k']."%'";
        //查询所有的品牌
        $category = M('category');
        //查询品牌出来
        $brandlist = $category->where('pid = 41'.$where)->select();
        
        $this->assign('brandlist',$brandlist);
        //查询首页推荐车源
        $selllist = $sell->where(' is_recommend = 1')->order('add_time')->limit(12)->select();

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
		//print_r($selllist);die;
		$this->assign('selllist',$selllist);// 热门推荐品牌


		//查询最新车源
			$selllist_new = $sell->where(' is_new = 1')->order('add_time')->limit(16)->select();

			//查询信息的一张图片

			foreach ($selllist_new as $key => $value) {
					$selllist_new[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
					$selllist_new[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title');
					//$selllist_new[$key]['brand_model'] =  $Document->where('id = '.$value['brand_model'])->getField('title');
					$selllist_new[$key]['level'] =  $Document->where('id = '.$value['level_id'])->getField('title');
					$selllist_new[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title');
					//判断用户是商家还是个人，
	               $status = $member->where('uid = '.$value['uid'])->getField('is_status');
	               if($status == 2){
	                  $selllist_new[$key]['status'] = '认证';  
	               }else{
	                    $selllist_new[$key]['status'] = ''; 
	               }

			}
			//print_r($selllist_new);die;
			$this->assign('selllist_new',$selllist_new);// 热门推荐品牌


			//查询最热车源
			$selllist_hot = $sell->where(' is_hot = 1')->order('add_time')->limit(16)->select();

			//查询信息的一张图片

			foreach ($selllist_new as $key => $value) {
					$selllist_hot[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
					$selllist_hot[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title');
					$selllist_hot[$key]['brand_model'] =  $Document->where('id = '.$value['brand_model'])->getField('title');
					$selllist_hot[$key]['level'] =  $Document->where('id = '.$value['level_id'])->getField('title');
					$selllist_hot[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title');
					//判断用户是商家还是个人，
	               $status = $member->where('uid = '.$value['uid'])->getField('is_status');
	               if($status == 2){
	                  $selllist_hot[$key]['status'] = '认证';  
	               }else{
	                    $selllist_hot[$key]['status'] = ''; 
	               }

			}
			//print_r($selllist);die;
			$this->assign('selllist_hot',$selllist_hot);// 热门推荐品牌
                 
        $this->display();
    }

}