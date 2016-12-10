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

    //审核
 public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        //(C('USER_ADMINISTRATOR'), 1;
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Business', $map );
                break;
            case 'resumeuser':
                $this->resume('Business', $map );
                break;
            case 'deleteuser':
                $this->delete('Business', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }
/****************申请店铺信息查看**********************/
public function edit(){
   $shop_id = I('get.id');
    $shop = M('Business');
        if($shop_id){
            $shop_info = $shop->where('id='.$shop_id)->find();
        }else{
              $this->error('参数专递错误',U('Business/index'));
        }
        $this->assign('shop_info',$shop_info);
         $this->display();


}


    /****************申请店铺信息删除**********************/
public function del_shop(){
    $shop_id      =   I('id');
        if(is_array($shop_id)){
            foreach ($shop_id as $k => $v){
            M('Business')->where('id='.$v)->delete();
            }
            $msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
            $this->success($msg['success'],$msg['url'],$msg['ajax']);
        }else{
            M('Business')->where('id='.$shop_id)->delete();
            $msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
            $this->success($msg['success'],$msg['url'],$msg['ajax']);
        }
            die();
}

}