<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class BusinessController extends AdminController {

    /**
     * 配置管理
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
         $shop_name       =   I('shop_name');
        $map['status']  =   array('egt',0);
        if(is_numeric($shop_name)){
            $map['id|shop_name']=   array(intval($shop_name),array('like','%'.$shop_name.'%'),'_multi'=>true);
        }else{
            $map['shop_name']    =   array('like', '%'.(string)$shop_name.'%');
        }
         $list   = $this->lists('Business', $map);

        $this->assign('list', $list);
        $this->meta_title = '店铺信息';
        $this->display();
    }

}