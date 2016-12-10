<?php
namespace Admin\Controller;

 class SellController extends AdminController
{

    public function index(){
        //echo 12342;
        $Document = M('document');
        $category = M('category');

        $post = I('post.');
        $keyword = $post['k'];
        $where = array();
        if($keyword){
            $where['title'] = array('like','%'.$keyword.'%');
            $this->assign('k',$keyword);// 赋值数据集
        }
        $User = M('sell'); // 实例化User对象
        $member = M('member'); // 实例化User对象
        $count      = $User->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $selllist = $User->join()->where($where)->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $albumtable  = M('album');
        $category  = M('category');
        foreach ($selllist as $key => $value) {
                $selllist[$key]['imgurl'] =  $albumtable->where('sell_id = '.$value['id'])->getField('imgurl');
                $selllist[$key]['gearbox'] =  $Document->where('id = '.$value['gearbox_id'])->getField('title');
                $selllist[$key]['brand_model'] =  $Document->where('id = '.$value['brand_model'])->getField('title');
                $selllist[$key]['level'] =  $Document->where('id = '.$value['level_id'])->getField('title');
                $selllist[$key]['brand'] =  $category->where('id = '.$value['brand_id'])->getField('title');
                $selllist[$key]['add_time'] =  date('Y-m-d',$value['add_time']);
                $selllist[$key]['name'] =  $member->where('uid = '.$value['uid'])->getField('nickname');

        }
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('selllist',$selllist);// 赋值数据集
     $this->display();
    }
    // 添加
    public function add()
    {


        $this->display();
    }


    // 修改信息
    public function updata()
    {

        $post = I('post.');

        //判断当前有没有新的图片上传

        if($_FILES['license']['error'] == 0 || $_FILES['license']['error'] == 0){
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
        }

        if($post['img']){
             $img = $post['img'];

            unset($post['img']);   
        }
        $Document = M('document');
        //$category = M('category');
        $post['type'] = $Document->where('id = '.$post['type_id'])->getField('title') ? :'';

        $post['gearbox'] = $Document->where('id = '.$post['gearbox_id'])->getField('title') ? :'';
        $post['level'] = $Document->where('id = '.$post['level_id'])->getField('title') ? :'';
        $post['brand_model_title'] = $Document->where('id = '.$post['brand_model'])->getField('title') ? :'';
            

            $a = M("album");
            
 

            $sell = M("sell"); // 实例化User对象
            // 要修改的数据对象属性赋值
            $id = $post['id'];
            unset($post['id']);

            $sell->where('id='.$id)->save($post); // 根据条件更新记录
            //增加用户信息，让用户知道自己发布的信息是否审核通过
            if($post['is_status'] == 1){
                $xinxi = M('xinxi');
                $title = "您发布的出售二手车信息已经审核通过，信息已经显示";
            }elseif($post['is_status'] == 2){
                $xinxi = M('xinxi');
                $title = "您发布的出售二手车信息审核不通过，请重新发布信息";
            }
            if($title){
                $xinxi_array = array('uid'=>$post['uid'],'from'=>'管理员','content'=>$title,'release_time'=>time(),'guoqi_id'=>0);
                $xinxi->add($xinxi_array);
            }
            unset($post['uid']);
            
            //加入相册信息
            if(!empty($img)){
                for ($i=0; $i < count($img); $i++) { 
                $arr = array(
                        'imgurl'=>$img[$i],
                        'sell_id'=>$id
                    );
                $a->add($arr);
                }
            }
            $this->success('修改成功！！',U('Sell/index'));

                    
                }

    public function edit()
    {
        $get = I('get.');
        $category = D('Category')->getTree();
        //$lists    = D('Document')->lists(null);
        $Category  = M('category');
        $Document  = M('document');

        $albumtable  = M('album');
        $list = $Category->where('pid = 41')->select();
        $lists = $Document->select();
        $this->assign('list',$list);//品牌
        //查询信息的相信信息
        $selltable  = M('sell');
       $sellinfo = $selltable->where('id = '.$get['id'])->find();
       $sellinfo['displacement'] = $Document->where('id = '.$sellinfo['displacement_id'])->getField('title') ? :'';
       $sellinfo['gearbox'] = $Document->where('id = '.$sellinfo['gearbox_id'])->getField('title') ? :'';
       $sellinfo['brand_model_title'] = $Document->where('id = '.$sellinfo['brand_model'])->getField('title') ? :'';
       $sellinfo['level'] = $Document->where('id = '.$sellinfo['level_id'])->getField('title') ? :'';
       $sellinfo['type'] = $Document->where('id = '.$sellinfo['type_id'])->getField('title') ? :'';
       $sellinfo['brand'] = $Category->where('id = '.$sellinfo['brand_id'])->getField('title') ? :'';

       $imglist = $albumtable->where('sell_id = '.$get['id'])->select();
       //print_r($imglist);die;
       $this->assign('imglist',$imglist);//相册

        $this->assign('sellinfo',$sellinfo);//栏目
        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表

        $this->display();

    }

    // 删除图片
    public function del_img()
    {
        $post = I('post.');
        $id = $post['id'];
        $User = M("album"); // 实例化User对象
        $User->where('id='.$id)->delete(); // 删除id为5的用户数据

        //删除图片在本地的文件

        $file = $post['imgurl'];
        if (unlink($file))
          {
          echo '1';
          }
        else
          {
            echo '0';
          }
        die;
        //$this->display();
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

    public function del_all()
    {
        $sell = M("sell");
        $post = I('post.');
        $where = implode(',',$post);
        $sell->delete($where); // 删除主键为1,2和5的用户数据
        $this->success('删除成功',U('Sell/index'));
    }

    public function del_one()
    {
        $get = I('get.');
        $sell = M("sell");

        $where = implode(',',$get);
        $sell->delete($where); // 删除主键为1,2和5的用户数据
        $this->success('删除成功',U('Sell/index'));

    }


    public function edit_index()
    {
        $get = I('get.');

        //修改当前条件下的状态
        $sell = M("sell"); // 实例化User对象
        // 要修改的数据对象属性赋值
        $id = $get['id'];
        $type = $get['type'];
        $status = $get['status'];
        $sell->$type = $status;
        $sell->where('id='.$id)->save(); // 根据条件更新记录

        $this->success('提交成功！！',U('Sell/index'));

    }
}