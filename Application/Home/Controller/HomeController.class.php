<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}


    protected function _initialize(){
        //检查是否登录

        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
        $user = session('user_auth');




        //查询热门品牌
        $category  = M('category');
        $hot_brand_list =  $category->where('pid = 41 and index_hot = 1')->limit(10)->select();
        $this->assign('hot_brand_list',$hot_brand_list);// 热门推荐品牌

        //关于我们
        $channel = M('Channel');
        $channel_info = $channel->where('pid=5')->select();
        $this->assign('channel_info',$channel_info); // 关于我们

          //新闻资讯
        $news = M('Channel');
        $news_info = $news->where('pid=4')->select();
        $this->assign('news_info',$news_info); // 新闻资讯

        //联系电话
        $phone = M('Channel');
        $phone_info = $news->where('pid=6')->select();
        $this->assign('phone_info',$phone_info); // 联系电话


        //电话信息
        $document = M('Document');
        $phones = $document->alias('a')->field('a.title,b.miansh,b.time')->join('LEFT JOIN onethink_document_phone b ON a.id=b.id')->where('a.category_id=58')->find();
        $this->assign('phones',$phones); // 电话信息

        //首页轮播
        $img = $document->where('category_id=61')->select();
        foreach ($img as $key => $value) {
            $img[$key]['links'] = M('document_newslun')->where('id='.$value['id'])->getField('links');
        }
         $this->assign('img',$img); // 首页轮播

         //友情链接
         $links = $document->where('category_id=62')->select();
         foreach ($links as $key => $value) {
             $links[$key]['links'] = M('document_links')->where('id='.$value['id'])->getField('links');
         }
         $this->assign('links', $links);//友情链接

         //分站信息
        $fenzhan = $document->where('category_id=63')->select();
         foreach ($fenzhan as $key => $value) {
             $fenzhan[$key]['links'] = M('document_links')->where('id='.$value['id'])->getField('links');
         }
              $this->assign('fenzhan', $fenzhan);//分站信息

        $erimg = $docuement->where('category_id=60')->select();
        $this->assign('erimg',$erimg);

        //网站logo
        $logo = $document->where('category_id=64')->find();
        $this->assign('logo',$logo);

    }

	/* 用户登录检测 */
	protected function login(){
		/* 用户登录检测 */
		is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
	}

}
