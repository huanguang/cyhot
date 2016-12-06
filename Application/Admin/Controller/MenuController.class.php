<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author yangweijie <yangweijiester@gmail.com>
 */
class MenuController extends AdminController {

    /**
     * 后台菜单首页
     * @return none
     */
    public function index(){
        $pid  = I('get.pid',0);
        if($pid){
            $data = M('Menu')->where("id={$pid}")->field(true)->find();
            $this->assign('data',$data);
        }
        $title      =   trim(I('get.title'));
        $type       =   C('CONFIG_GROUP_LIST');
        $all_menu   =   M('Menu')->getField('id,title');
        $map['pid'] =   $pid;
        if($title)
            $map['title'] = array('like',"%{$title}%");
        $list       =   M("Menu")->where($map)->field(true)->order('sort asc,id asc')->select();
        int_to_string($list,array('hide'=>array(1=>'是',0=>'否'),'is_dev'=>array(1=>'是',0=>'否')));
        if($list) {
            foreach($list as &$key){
                if($key['pid']){
                    $key['up_title'] = $all_menu[$key['pid']];
                }
            }
            $this->assign('list',$list);
        }
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->meta_title = '菜单列表';
        $this->display();
    }

    /**
     * 新增菜单
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function add(){
        if(IS_POST){
            $Menu = D('Menu');
            $data = $Menu->create();

            if($data['controller']){
                $root = C('CONTROLLES_ROOTPATH'); //控制器保存的目录
                $file_name = $root.'/'. $data['controller'].'Controller.class.php';
                ob_start(); //开启缓冲区
                include('./Public/Template/Controller.php');
                $str = ob_get_clean();
                if(!file_exists($file_name)){
                    //fopen($file_name,'a+');
                    file_put_contents($file_name,"<?php\r\n".$str);
                }
            }elseif($data['view']){
                $vdir = C('VIEW_ROOTPATH');
                $datas = split('/', $data['view']);
                $file_vdir =  $vdir.'/'.$datas['0'];
                if(!is_dir($file_vdir)){
                     mkdir($file_vdir,755,TRUE);
                }

                if($datas['1'] == 'index'){
                    ob_start(); //开启缓冲区
                    include('./Public/Template/index.html');
                    $indexs = ob_get_clean();
                    //创建一个默认的index
                    $file_index = $file_vdir.'/'.$datas['1'].'.html';
                    if(!is_file($file_index)){
                        file_put_contents($file_index, $indexs);
                    }
                }
                $file_view = $file_vdir.'/'.$datas['1'].'.html';
                if(!file_exists($file_view)){
                    fopen($file_view,'a+');
                }
            }

            if($data){
                $id = $Menu->add();
                if($id){
                    session('ADMIN_MENU_LIST',null);
                    //记录行为
                    action_log('update_menu', 'Menu', $id, UID);
                    $this->success('新增成功', Cookie('__forward__'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Menu->getError());
            }
        } else {
            $this->assign('info',array('pid'=>I('pid')));
            $menus = M('Menu')->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus);
            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
            $this->assign('Menus', $menus);
            $this->meta_title = '新增菜单';
            $this->display('edit');
        }
    }

    /**
     * 编辑配置
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function edit($id = 0){
        if(IS_POST){
            $Menu = D('Menu');
            $data = $Menu->create();
            if($data){
                if($Menu->save()!== false){
                    session('ADMIN_MENU_LIST',null);
                    //记录行为
                    action_log('update_menu', 'Menu', $data['id'], UID);
                    $this->success('更新成功', Cookie('__forward__'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($Menu->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Menu')->field(true)->find($id);
            $menus = M('Menu')->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus);

            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
            $this->assign('Menus', $menus);
            if(false === $info){
                $this->error('获取后台菜单信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑后台菜单';
            $this->display();
        }
    }

    /**
     * 删除后台菜单
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function del(){
        $id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        //判断下面是否还有子类
        $menu = M('Menu');
        if($id){
            $menu_info = $menu->where('pid='.$id['0'])->select();
            if(count($menu_info) > 0){
                $this->error('请先删除下面的子类!');
            }
            $vdir = C('VIEW_ROOTPATH');
            $menu_del = $menu->where('id='.$id['0'])->find();
            if($menu_del['pid'] == 0){
                $root = C('CONTROLLES_ROOTPATH');
                $file_name = $root.'/'. $menu_del['controller'].'Controller.class.php';
                $view_folder = $vdir.'/'.$menu_del['controller'];

                if(file_exists($file_name)){
                     @unlink($file_name);
                }

                if(is_dir($view_folder)){
                    var_dump($view_folder);
                    rmdir($view_folder);
                }
            }
            if($menu_del['pid'] !== 0){
                $view = split('/',$menu_del['view']);
                $view_file = $vdir.'/'.$view['0'].'/'.$view['1'].'.html';
                if(file_exists($view_file)){
                    @unlink($view_file);
                }
            }
        }
        $map = array('id' => array('in', $id) );

        if(M('Menu')->where($map)->delete()){
            session('ADMIN_MENU_LIST',null);
            //记录行为
            action_log('update_menu', 'Menu', $id, UID);

            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    public function toogleHide($id,$value = 1){
        session('ADMIN_MENU_LIST',null);
        $this->editRow('Menu', array('hide'=>$value), array('id'=>$id));
    }

    public function toogleDev($id,$value = 1){
        session('ADMIN_MENU_LIST',null);
        $this->editRow('Menu', array('is_dev'=>$value), array('id'=>$id));
    }

    public function importFile($tree = null, $pid=0){
        if($tree == null){
            $file = APP_PATH."Admin/Conf/Menu.php";
            $tree = require_once($file);
        }
        $menuModel = D('Menu');
        foreach ($tree as $value) {
            $add_pid = $menuModel->add(
                array(
                    'title'=>$value['title'],
                    'url'=>$value['url'],
                    'pid'=>$pid,
                    'hide'=>isset($value['hide'])? (int)$value['hide'] : 0,
                    'tip'=>isset($value['tip'])? $value['tip'] : '',
                    'group'=>$value['group'],
                )
            );
            if($value['operator']){
                $this->import($value['operator'], $add_pid);
            }
        }
    }

    public function import(){
        if(IS_POST){
            $tree = I('post.tree');
            $lists = explode(PHP_EOL, $tree);
            $menuModel = M('Menu');
            if($lists == array()){
                $this->error('请按格式填写批量导入的菜单，至少一个菜单');
            }else{
                $pid = I('post.pid');
                foreach ($lists as $key => $value) {
                    $record = explode('|', $value);
                    if(count($record) == 2){
                        $menuModel->add(array(
                            'title'=>$record[0],
                            'url'=>$record[1],
                            'pid'=>$pid,
                            'sort'=>0,
                            'hide'=>0,
                            'tip'=>'',
                            'is_dev'=>0,
                            'group'=>'',
                        ));
                    }
                }
                session('ADMIN_MENU_LIST',null);
                $this->success('导入成功',U('index?pid='.$pid));
            }
        }else{
            $this->meta_title = '批量导入后台菜单';
            $pid = (int)I('get.pid');
            $this->assign('pid', $pid);
            $data = M('Menu')->where("id={$pid}")->field(true)->find();
            $this->assign('data', $data);
            $this->display();
        }
    }

    /**
     * 菜单排序
     * @author huajie <banhuajie@163.com>
     */
    public function sort(){
        if(IS_GET){
            $ids = I('get.ids');
            $pid = I('get.pid');

            //获取排序的数据
            $map = array('status'=>array('gt',-1));
            if(!empty($ids)){
                $map['id'] = array('in',$ids);
            }else{
                if($pid !== ''){
                    $map['pid'] = $pid;
                }
            }
            $list = M('Menu')->where($map)->field('id,title')->order('sort asc,id asc')->select();

            $this->assign('list', $list);
            $this->meta_title = '菜单排序';
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = explode(',', $ids);
            foreach ($ids as $key=>$value){
                $res = M('Menu')->where(array('id'=>$value))->setField('sort', $key+1);
            }
            if($res !== false){
                session('ADMIN_MENU_LIST',null);
                $this->success('排序成功！');
            }else{
                $this->error('排序失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }
}