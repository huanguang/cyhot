<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class NewsController extends HomeController {

    /* 文档模型频道页 */
	public function index(){
		/* 分类信息 */
		$category = $this->category();

		//频道页只显示模板，默认不读取任何内容
		//内容可以通过模板标签自行定制

		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->display($category['template_index']);
	}

	/* 文档模型列表页 */
	public function lists($p = 1){
		/* 分类信息 */
		$category = $this->category();
		/* 获取当前分类列表 */
		$Document = D('Document');
		$list = $Document->page($p, $category['list_row'])->lists($category['id']);
		if(false === $list){
			$this->error('获取列表数据失败！');
		}
		foreach ($list as $key => $value) {
			$list[$key]['title_new'] = M('document_article')->where('id='.$value['id'])->getField('title_new');
			$list[$key]['new_description'] = M('document_article')->where('id='.$value['id'])->getField('new_description');
		}

		$news_lun  = $Document->where('category_id=47')->select();
		/* 模板赋值并渲染模板 */
		$this->assign('news_lun', $news_lun);
		$this->assign('category', $category);
		$this->assign('list', $list);
		$this->display($category['template_lists']);
	}

	/* 文档模型详情页 */
	public function detail($id = 0, $p = 1){
		/* 标识正确性检测 */
		if(!($id && is_numeric($id))){
			$this->error('文档ID错误！');
		}

		/* 页码检测 */
		$p = intval($p);
		$p = empty($p) ? 1 : $p;

		/* 获取详细信息 */
		$Document = D('Document');
		$info = $Document->detail($id);
		if(!$info){
			$this->error($Document->getError());
		}

		/* 分类信息 */
		$category = $this->category($info['category_id']);

		/* 获取模板 */
		if(!empty($info['template'])){//已定制模板
			$tmpl = $info['template'];
		} elseif (!empty($category['template_detail'])){ //分类已定制模板
			$tmpl = $category['template_detail'];
		} else { //使用默认模板
			$tmpl = 'Article/'. get_document_model($info['model_id'],'name') .'/detail';
		}

		$sell = M('sell');
		//查询首页推荐车源
        $selllist = $sell->where(' is_recommend = 1 and is_status = 1')->order('add_time')->limit(12)->select();

		//查询信息的一张图片
		$albumtable  = M('album');
		$category  = M('category');
		$business  = M('business');
		foreach ($selllist as $key => $value) {
				$selllist[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
				$selllist[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title');
				$selllist[$key]['brand_model'] =  $Document->where('id = '.$value['brand_model'])->getField('title');
				$selllist[$key]['level'] =  $Document->where('id = '.$value['level_id'])->getField('title');
				$selllist[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title');
				//判断用户是商家还是个人，
               $status = $business->where('user_id = '.$value['uid'])->getField('is_status');
               if($status == 2){
                  $selllist[$key]['status'] = '认证';  
               }else{
                    $selllist[$key]['status'] = ''; 
               }

		}
		//print_r($selllist);die;
		$this->assign('selllist',$selllist);// 热门推荐品牌
		/* 更新浏览数 */
		$map = array('id' => $id);
		$Document->where($map)->setInc('view');

		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->assign('info', $info);
		$this->assign('page', $p); //页码

		$this->display($tmpl);
	}

	/* 文档分类检测 */
	private function category($id = 0){
		/* 标识正确性检测 */
		$id = $id ? $id : I('get.category', 0);
		if(empty($id)){
			$this->error('没有指定文档分类！');
		}

		/* 获取分类信息 */
		$category = D('Category')->info($id);
		if($category && 1 == $category['status']){
			switch ($category['display']) {
				case 0:
					$this->error('该分类禁止显示！');
					break;
				//TODO: 更多分类显示状态判断
				default:
					return $category;
			}
		} else {
			$this->error('分类不存在或被禁用！');
		}
	}

}
