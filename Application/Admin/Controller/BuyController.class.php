<?php
namespace Admin\Controller;

 class BuyController extends AdminController
{

    public function index(){
        $post = I('post.');
        $keyword = $post['k'];
        $where = array();
        if($keyword){
            $where['title'] = array('like','%'.$keyword.'%');
            $this->assign('k',$keyword);// 赋值数据集
        }
        //print_r($where);
        $Document = M('document');
        $category = M('category');
        //查询用户的列表
         $Buy = M('buying'); // 实例化buying对象
        $count      = $Buy->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $buylist = $Buy->where($where)->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

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
        //print_r($buylist);die;
     $this->display();
    }
    // 添加
    public function add()
    {

        $this->display();
    }

    // 修改
    public function updata()
    {
        $post = I('post.');

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
        

        if($post['address'] == ''){
            $this->error('必须填写车辆所在地址');
        }

        $buy = M("buying"); // 实例化User对象
            // 要修改的数据对象属性赋值
            $id = $post['id'];
            unset($post['id']);
            
            $buy->where('id='.$id)->save($post); // 根据条件更新记录


        $this->success('提交成功！！',U('Buy/index'));
    }
    public function edit()
    {
        $get = I('get.');

        $lists    = M('document')->select();
        $this->assign('lists',$lists);//列表
        $Category  = M('category');
        $list = $Category->where('pid = 41')->select();
       $buytable  = M('buying');
       $buylinfo = $buytable->where('id = '.$get['id'])->find();
       $Document = M('document');
            $buylinfo['type'] =  $Document->where('id = '.$buylinfo['type_id'])->getField('title') ? :'不限';
            $buylinfo['brand'] =  $Document->where('id = '.$buylinfo['brand_id'])->getField('title') ? :'不限';
            $buylinfo['gearbox'] =  $Document->where('id = '.$buylinfo['gearbox_id'])->getField('title') ? :'不限';
            $buylinfo['carage'] =  $Document->where('id = '.$buylinfo['carage_id'])->getField('title') ? :'不限';
            $buylinfo['driven'] =  $Document->where('id = '.$buylinfo['driven_id'])->getField('title') ? :'不限';
            $buylinfo['price'] =  $Document->where('id = '.$buylinfo['price_id'])->getField('title') ? :'不限';
            $buylinfo['add_time'] = date('Y-m-d  H:i:s',$buylinfo['add_time']);

            $this->assign('list',$list);// 赋值数据集

            $this->assign('buylinfo',$buylinfo);// 赋值数据集
       //print_r($buylinfo);die;
        $this->display();
    }

    public function del_all()
    {
        $sell = M("buying");
        $post = I('post.');
        $where = implode(',',$post);
        $sell->delete($where); // 删除主键为1,2和5的用户数据
        $this->success('删除成功',U('Buy/index'));
    }

    public function del_one()
    {
        $get = I('get.');
        $sell = M("buying");

        $where = implode(',',$get);
        $sell->delete($where); // 删除主键为1,2和5的用户数据
        $this->success('删除成功',U('Buy/index'));

    }
}