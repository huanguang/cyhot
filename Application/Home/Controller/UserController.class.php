<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {

	/* 用户中心首页 */
	public function index(){

	}

	/* 注册页面 */
	public function register($phone = '', $password = '', $repassword = '', $email = '', $verify = ''){
        if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        }
		if(IS_POST){ //注册用户
			/* 检测验证码 */
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}

			/* 检测密码 */
			if($password != $repassword){
				$this->error('密码和重复密码不一致！');
			}

			/* 调用注册接口注册用户 */
            $User = new UserApi;
			$uid = $User->register($phone, $password, $email);
			if(0 < $uid){ //注册成功
				//TODO: 发送验证邮件
				$this->success('注册成功！',U('login'));
			} else { //注册失败，显示错误信息
				$this->error($this->showRegError($uid));
			}

		} else { //显示注册表单
			$this->display();
		}
	}

	/* 登录页面 */
	public function login($phone = '', $password = '', $verify = ''){
		if(IS_POST){ //登录验证
			/* 检测验证码 */
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}
                                /*判断是手机号登录 还是邮箱登录*/

                                if($_POST['phone']){
                                        /* 调用UC登录接口登录 */
                                        $user = new UserApi;
                                        $uid = $user->login($phone, $password);

                                }elseif($_POST['email']){

                                     /* 调用UC登录接口登录 */
                                        $user = new UserApi;
                                        $type = 2;
                                        $uid = $user->login($username, $password,$type);
                                }
			if(0 < $uid){ //UC登录成功
				/* 登录用户 */
				$Member = D('Member');
				if($Member->login($uid)){ //登录用户
					//TODO:跳转到登录前页面
					$this->success('登录成功！',U('Home/User/news'));
				} else {
					$this->error($Member->getError());
				}

			} else { //登录失败
				switch($uid) {
					case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
					case -2: $error = '密码错误！'; break;
					default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error);
			}

		} else { //显示登录表单
			$this->display();
		}
	}

	/* 退出登录 */
	public function logout(){
		if(is_login()){
			D('Member')->logout();
			$this->success('退出成功！', U('User/login'));
		} else {
			$this->redirect('User/login');
		}
	}

	/* 验证码，用于登录和注册 */
	public function verify(){
		$verify = new \Think\Verify();
		$verify->entry(1);
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0){
		switch ($code) {
			case -1:  $error = '手机号码长度必须在16个字符！'; break;
			case -2:  $error = '手机号码被禁止注册！'; break;
			case -3:  $error = '手机号码被占用！'; break;
			case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
			case -5:  $error = '邮箱格式不正确！'; break;
			case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
			case -7:  $error = '邮箱被禁止注册！'; break;
			case -8:  $error = '邮箱被占用！'; break;
//			case -9:  $error = '手机格式不正确！'; break;
//			case -10: $error = '手机被禁止注册！'; break;
//			case -11: $error = '手机号被占用！'; break;
			default:  $error = '未知错误';
		}
		return $error;
	}


    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function profile(){
		if ( !is_login() ) {
			$this->error( '您还没有登陆',U('User/login') );
		}
        if ( IS_POST ) {
            //获取参数
            $uid        =   is_login();
            $password   =   I('post.old');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->error('请输入原密码');
            empty($data['password']) && $this->error('请输入新密码');
            empty($repassword) && $this->error('请输入确认密码');

            if($data['password'] !== $repassword){
                $this->error('您输入的新密码与确认密码不一致');
            }

            $Api = new UserApi();
            $res = $Api->updateInfo($uid, $password, $data);
            if($res['status']){
                $this->success('修改密码成功！');
            }else{
                $this->error($res['info']);
            }
        }else{
            $this->display();
        }
    }

    //个人信息
    public function personal(){
//检查是否登陆
         if ( !is_login() ) {
            $this->error( '您还没有登陆',U('User/login') );
        }
    $user = M('Ucenter_member');

        if(IS_POST){
              $uid        =   is_login();
            $post = I('post.');
            $data = array(
                'name'  =>$post['name'],
                'certificate_type'  =>$post['certificate_type'],
                'card_num'  =>$post['card_num'],
                'sex'  =>$post['sex'],
                'username'  =>$post['username'],
                'phone'  =>$post['phone'],
                'email'  =>$post['email'],
                'the_city'  =>$post['the_city'],
                'address'  =>$post['address'],
                );
            $usr_info = $user->where('id='.$uid)->save($data);
            if($usr_info){
                 $this->success('修改个人信息成功!',U('User/personal'));
            }else{
                $this->error( '修改失败',U('User/personal') );
            }
        }else{
            $uid        =   is_login();
            $user_info = $user->where('id='.$uid)->find();
            $this->assign('user_info',$user_info);
             $this->display('User/user_personal');
        }

    }

// 商家认证
public function business(){
     $uid        =   is_login();
    $path = M('Picture');
    $shop = M('Business');
    if(IS_POST){
        $data = array(
            'path'  => I('post.img_id'),//路径
            'status'=>1,    //状态
             'create_time'=>time(),  //时间
            );
        $path_id = $path->add($data);

        if($path_id > 0){
            $data = array(
                'user_id'  => $uid,
                'shop_name'  => I('post.shop_name'),
                'img_id'  =>  $path_id,
                'status'  => 1,
                );
            if( $shop->add($data)){
                 $this->success('提交成功，正在审核中!',U('User/business'));
            }
        }else{
            $this->error( '图片上失败',U('User/business') );
        }
    }else{

        $shop_info = $shop->where('user_id='.$uid)->find();

        if($shop_info['is_status'] == 2){
             $shop_s = $shop->where('id='.$shop_info['id'])->find();
             $this->assign('shop_s',$shop_s);
        }

        $this->assign('shop_info',$shop_info);
         $this->display('User/user_business');
    }
}


//  我的消息
public function news(){
         $uid = I('get.uid');
         if(!$uid){
                $this->error( '用户id丢失',U('User/loing') );
         }else{
            //出售信息
                  $sell = M('sell');
                  $sell_info = $sell->where('uid='.$uid)->select();
                  //var_dump($sell_info);
                 foreach ($sell_info as $key => $value) {
                      $sell_info[$key]['displacement'] =  M('Document')->where('id='.$value['displacement_id'])->getField('title') ? : '';
                      $sell_info[$key]['gearbox'] = M('Document')->where('id='.$value['gearbox_id'])->getField('title') ? : '';
                      $sell_info[$key]['brand_model_title'] =  M('Document')->where('id='.$value['brand_model'])->getField('title') ? : '';
                      $sell_info[$key]['level'] =  M('Document')->where('id='.$value['level_id'])->getField('title') ? : '';
                      $sell_info[$key]['brand'] =  M('Category')->where('id='.$value['brand_id'])->getField('title') ? : '';
                       $sell_info[$key]['title'] = ' '.$sell_info[$key]['brand'] .' ' . $sell_info[$key]['brand_model_title'] .' '.$sell_info[$key]['displacement'].' '.$sell_info[$key]['gearbox'].' '. $sell_info[$key]['level'] ? : '';
                  }
                 //var_dump($sell_info);

            //求购
            $buying = M('buying');
            $buying_info = $buying->where('uid='.$uid)->select();

           foreach ($buying_info as $k => $v) {
               $buying_info[$k]['type'] = M('Document')->where('id='.$v['type_id'])->getField('title') ? : '';
               $buying_info[$k]['brand'] = M('Category')->where('id='.$v['brand_id'])->getField('title') ? : '';
               $buying_info[$k]['gearbox'] = M('Document')->where('id='.$v['gearbox_id'])->getField('title') ? : '';
               $buying_info[$k]['carage'] = M('Document')->where('id='.$v['carage_id'])->getField('title') ? : '';
               $buying_info[$k]['driven'] = M('Document')->where('id='.$v['driven_id'])->getField('title') ? : '';
              $buying_info[$k]['price'] = M('Document')->where('id='.$v['price_id'])->getField('title') ? : '';

              $buying_info[$k]["title"] = ' '.$buying_info[$k]['type'].' '.$buying_info[$k]['brand'].' ' .$buying_info[$k]['gearbox'].' ' .$buying_info[$k]['price']? : '';
            }
           $data = array_merge_recursive($sell_info,$buying_info);

           // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用
           $count      = count($data);// 查询满足要求的总记录数
           $Page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(25)
           $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性

           $list = array_slice($data, $Page->firstRow, $Page->listRows);

           $this->assign('data',$list);
           $this->assign('show',$show);// 赋值分页输出

             $this->display('User/user_news');
         }

}

//系统消息
public function system(){
           if ( !is_login() ) {
            $this->error( '您还没有登陆',U('User/login') );
        }
         $uid        =   is_login();
         $xin = M('xinxi');
         $xin_info = $xin->where('uid='.$uid)->select();
         $this->assign('xin_info',$xin_info);

    $this->display('User/user_system');
}

//求购信息
public function buyign(){
        if ( !is_login() ) {
            $this->error( '您还没有登陆',U('User/login') );
        }
        $get = I('get.id');
        $member  = M('member');
       $buytable  = M('buying');
       $buylinfo = $buytable->where('id = '.$get)->find();
       //格式化数据
      $Document = M('document');
      $buylinfo['type'] =  $Document->where('id = '.$buylinfo['type_id'])->getField('title') ? :'不限';
      $buylinfo['brand'] =  M('Category')->where('id = '.$buylinfo['brand_id'])->getField('title') ? :'不限';
      $buylinfo['gearbox'] =  $Document->where('id = '.$buylinfo['gearbox_id'])->getField('title') ? :'不限';
      $buylinfo['carage'] =  $Document->where('id = '.$buylinfo['carage_id'])->getField('title') ? :'不限';
      $buylinfo['driven'] =  $Document->where('id = '.$buylinfo['driven_id'])->getField('title') ? :'不限';
      $buylinfo['price'] =  $Document->where('id = '.$buylinfo['price_id'])->getField('title') ? :'不限';

      $buylinfo['title'] = ' '.$buylinfo['brand'].' '.$buylinfo['carage'].' '.$buylinfo['price'] ? : '';

      if($buylinfo['maintenance'] == 1){
          $buylinfo['maintenance'] = '是';
      }else{
        $buylinfo['maintenance'] = '否';
      }

      if($buylinfo['colour'] == 'black'){
          $buylinfo['colour']  = '黑色';
      }elseif ($buylinfo['colour'] == 'white') {
        $buylinfo['colour']  = '白色';
      }elseif($buylinfo['colour'] == 'red'){
         $buylinfo['colour']  = '红色';
      }elseif($buylinfo['colour'] == 'blue'){
          $buylinfo['colour']  = '蓝色';
      }elseif ($buylinfo['colour']  = 'Pink') {
         $buylinfo['colour']  = '灰白';
      }elseif ($buylinfo['colour']  = 'Space_dust') {
        $buylinfo['colour']  = '太空灰';
      }elseif ($buylinfo['colour']  = 'Other') {
       $buylinfo['colour']  = '其他';
      }

      $status = $member->where('uid = '.$buylinfo['uid'])->getField('is_status');
      if($status == 2){
          $buylinfo['laiy'] = '商家';
      }else{
        $buylinfo['laiy'] = '个人';
      }

      $this->assign('buylinfo',$buylinfo);
      $this->display('User/user_newsxx');
}


//出售信息
public function sell(){
        if ( !is_login() ) {
            $this->error( '您还没有登陆',U('User/login') );
        }
      $get = I('get.id');
       $albumtable  = M('album');
       $imglist = $albumtable->where('sell_id = '.$get)->find();
       $this->assign('imglist',$imglist);//相册
       $Document = M('document');
       $category = M('category');
         $member  = M('member');
       $selltable  = M('sell');
       $sellinfo = $selltable->where('id = '.$get['id'])->find();
       //print_r($sellinfo);
       $sellinfo['displacement'] = $Document->where('id = '.$sellinfo['displacement_id'])->getField('title') ? :'';
       $sellinfo['gearbox'] = $Document->where('id = '.$sellinfo['gearbox_id'])->getField('title') ? :'';
       $sellinfo['brand_model_title'] = $Document->where('id = '.$sellinfo['brand_model'])->getField('title') ? :'';
       $sellinfo['level'] = $Document->where('id = '.$sellinfo['level_id'])->getField('title') ? :'';
       $sellinfo['brand'] = $category->where('id = '.$sellinfo['brand_id'])->getField('title') ? :'';
       $sellinfo['title'] = ' '.$sellinfo['brand_model_title'].' '.$sellinfo['years'].'年'.' '.$sellinfo['sfer_price'].'万' ? : '';

       if($buylinfo['colour'] == 'black'){
          $buylinfo['colour']  = '黑色';
      }elseif ($buylinfo['colour'] == 'white') {
        $buylinfo['colour']  = '白色';
      }elseif($buylinfo['colour'] == 'red'){
         $buylinfo['colour']  = '红色';
      }elseif($buylinfo['colour'] == 'blue'){
          $buylinfo['colour']  = '蓝色';
      }elseif ($buylinfo['colour']  = 'Pink') {
         $buylinfo['colour']  = '灰白';
      }elseif ($buylinfo['colour']  = 'Space_dust') {
        $buylinfo['colour']  = '太空灰';
      }elseif ($buylinfo['colour']  = 'Other') {
       $buylinfo['colour']  = '其他';
      }
      $status = $member->where('uid = '.$sellinfo['uid'])->getField('is_status');
      if($status == 2){
          $sellinfo['laiy'] = '商家';
      }else{
        $sellinfo['laiy'] = '个人';
      }
$this->assign('sellinfo',$sellinfo);
  $this->display('User/user_newsxx_chus');
}

//邮箱找回密码
public function mails($verify = ''){
  if(IS_POST){
   $email = I('post.email');
          if(!check_verify($verify)){
        $this->error('验证码输入错误！');
      }
      $user = M('Ucenter_member');
      $user_info = $user->where('email = "'.$email.'" ')->find();
      if($user_info >0){
        $toke = getRandChar();
        $toke_time = time();
        $data = array(
            'toke'  => $toke,
            'toke_time'  => $toke_time,
          );
        if($user->where('email = "'.$email.'" ')->save($data)){
                $title = '一哥车业';
                $to = $email;
                $url = 'http://localhost'.U('User/wjmms?toke='.$toke);
                $mail = newsendMail($to,$title,$url);
                if($mail == false){
                     $this->error('邮箱发送失败');
                }else{
                  $this->success('验证信息已经发送到您的邮箱');
                }
        }else{
           $this->error('服务器错误！！');
        }
        $this->display('User/wjmm');
    }else{
               $this->error('邮箱错误，请重新输出正确的邮箱');
      }

  }else{

     $this->display('User/wjmm');
  }

}

public function wjmms(){
  $toke = I('get.toke');
        $member = M('Ucenter_member');
        $member_info = $member->where('toke = "'.$toke.'" ')->find();
        if($member_info > 0){
          if(IS_POST){
            //获取参数
            $data['password'] = I('post.password');
            $passwordds = I('post.passwordds');
            $email = $member_info['id'];
            empty($data['password']) && $this->error('请输入新密码');
            empty($passwordds) && $this->error('请输入确认密码');

            if($data['password'] !== $passwordds){
                $this->error('您输入的新密码与确认密码不一致');
            }
            $data['password'] = think_ucenter_encrypts($data['password'], UC_AUTH_KEY);
            $members = $member->where('email='.$email)->save($data);
            if($members > 0){
              $this->success('修改成功',U('User/login'));
            }else{
              $this->error('修改失败');
            }

          }else{
            $this->display('User/wjmms');
          }
       }else{
          $this->error('验证码已过期，请重新发送');
       }

}


 //文件上传
    public function fileupload(){
        vendor("FileUpload.FileUpload");

            $up = new \FileUpload;

            //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)

            $lu = date('Ymd');
            $mode = '0777';
            $dir = './Uploads/business/'.$lu.'/';
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
                $arr = array("imgname"=>$dir.$imgname,'error'=>'0','msg'=>'上传成功！');
                echo json_encode($arr);die;
                //echo '</pre>';
            } else {

                //获取上传失败以后的错误提示

                $arr = array("imgname"=>$dir.$imgname,'error'=>1,'msg'=>$up->getErrorMsg());
                echo json_encode($arr);die;
            }

    }

}
