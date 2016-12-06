<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------
namespace Admin\Model;
use Think\Model;

/**
 * 插件模型
 * @author yangweijie <yangweijiester@gmail.com>
 */

class MenuModel extends Model {

    protected $_validate = array(
        array('title','require','标题必须填写'), 
        array('url','require','链接必须填写'), 
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('title', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('status', '1', self::MODEL_INSERT),
    );

    //修改后的操作
    public function _before_update (&$data,$option){
        if($data['controller']){
            $contr = C('CONTROLLES_ROOTPATH');
            $new_file = $contr.'/'.$data['controller'].'Controller.class.php'; //新文件名

            //从数据库查出旧文件名
            $menu = M('Menu');
            $menu_info = $menu->where('id='.$option['where']['id'])->find();
            $old_file = $contr.'/'.$menu_info['controller'].'Controller.class.php'; //拼接旧文件名

            //检测旧文件名是否存在 存在就更改
            if(file_exists($old_file)){
                $rod =  rename($old_file,$new_file);
            }
            //判断是否更改成功 更改成功就开启缓冲区
            if($rod == true){
                ob_start(); //开启缓冲区
                include('./Public/Template/Controller.php');
                $str = ob_get_clean();

                if(file_exists($new_file)){//文件存在就更新缓存区的内容
                    //fopen($file_name,'a+');
                    file_put_contents($new_file,"<?php\r\n".$str);
                }
            }
        }elseif($data['view']){
            $vdir = C('VIEW_ROOTPATH');
            $menu = M('Menu');
            $menu_info = $menu->where('id='.$option['where']['id'])->find();

            //获取新的文件夹名称
            $new = split('/',$data['view']);
            $new_view = $vdir.'/'.$new['0'];//文件夹
            $new_file = $new_view.'/'.$new['1'].'.html';//文件

            //获取旧文件夹名称
            $old = split('/',$menu_info['view']);
            $old_view = $vdir.'/'.$old['0'];

            //检测旧文件夹是否存在
            if(file_exists($old_view)){
             $new_folder = rename($old_view,$new_view);
            }
            if($new_folder == true){
                $old_file = $new_view.'/'.$old['1'].'.html';
                if(file_exists($old_file)){
                    rename($old_file,$new_file);
                }
            }
        }

    }
}