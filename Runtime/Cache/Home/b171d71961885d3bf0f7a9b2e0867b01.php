<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	
      <meta charset="utf-8">
      <title>一哥车业</title>
      <meta name="keywords" content="wsg,hth">
      <meta name="description" content="ASW">
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="keywords" content="一哥车业">
      <Meta name="description" Content="一哥车业">
      <link href="/ot/Public/Home/css/css.css" rel="stylesheet" type="text/css">
      <link href="/ot/Public/Home/css/selectpick/cui.css" rel="stylesheet" type="text/css"><!--美化下拉框插件-->
      <script src="/ot/Public/Home/js/jquery.js"></script><!-- 统一调用js -->
      <link href="/ot/Public/Home/css/banner-switch/lrtk.css" rel="stylesheet"><!-- banner切换 -->
      <script src="/ot/Public/Home/js/banner-switch/jquery.superslide.2.1.1.js"></script><!-- banner切换 -->
      <link href="/ot/Public/Home/css/SuperSlide/style.css" rel="stylesheet"><!--标签切换，滚动 -->
      <link rel="stylesheet" href="/ot/Public/Home/css/Validform/style.css" type="text/css" media="all" /><!-- 13.0 表单提交验证 -->
      <link href="/ot/Public/Home/css/Validform/demo.css" type="text/css" rel="stylesheet" /><!-- 13.0 表单提交验证 -->
     <!--  <script type="text/javascript" src="css/Validform/js/Validform_v5.3.2_min.js"></script> --><!-- 13.0 表单提交验证 -->
      <script type="text/javascript" src="/ot/Public/Home/css/Validform/plugin/passwordStrength/passwordStrength-min.js"></script><!-- 13.0 表单提交验证 -->
      <link href="/ot/Public/Home/css/fxk.css" rel="stylesheet" type="text/css"><!-- 表单美化 -->



</head>
<body>
	<!-- 头部 -->
	
      <div class="sign_top w1200">
        <ul class="fl">
          <li class="li1"><a href="index.php"><img src="/ot/Public/Home/images/logo.png" alt=""></a></li>
          <!-- <li class="li2"><a href="forget.php">忘记密码</a></li> -->
        </ul>
        <div class="fr">
          <div class="div1 fr">0755-36631111</div>
          <div class="div2 fr"><a href="index.php">返回首页</a></div>
          <div class="clear"></div>
        </div>
        <div class="clear"></div>
      </div>


	<!-- /头部 -->
	
	<!-- 主体 -->
	
      <div class="sign_center">
    <div class="slide_box sign_div">
      <div class="hd">
        <ul>
          <li class="li1 fl">手机登录</li>
          <li class="li2 fr">邮箱登录</li>
        </ul>
        <div class="clear"></div>
      </div>
      <div class="bd">
        <div>
          <form action="/ot/index.php?s=/Home/User/login.html" method="post"  class="login-form">
            <table width="500" border="0" cellspacing="0" cellpadding="0" class="sign_table">
                <tr>
                  <td class="td1">手机号</td>
                  <td class="td2">
                    <div class="div1">
                          <input type="text" value="" class="sign_inp inp_s1" name="phone" datatype="n6-18" placeholder="请输入手机号码" errormsg="手机号码有误！" />
                        </div>
                        <div class="Validform_checktip"></div>
                      </td>
                </tr>
                <tr>
                  <td class="td1">密码</td>
                  <td class="td2">
                    <div class="div1">
                      <input type="password" value="" class="sign_inp inp_s1" name="password" datatype="n6-18" placeholder="请输入密码" errormsg="密码有误！" />
                    </div>
                    <div class="Validform_checktip"></div>
                  </td>
                </tr>
                <tr>
                  <td class="td1">验证码</td>
                  <td class="td2">
                    <div class="div1">
                      <input type="password" value="" class="sign_inp inp_s1" name="verify" datatype="n6-18" placeholder="请输入验证码" errormsg="验证码有误！"
                      style="width:40%" />
                     <a href="javascript:void(0)"><span  class="agy14_1"><img class="verifyimgs" src="<?php echo U('verify');?>" alt=""></span>看不清？</a>
                    </div>
                    <div class="Validform_checktip"></div>
                  </td>
                </tr>

                <tr>
                  <td class="td1">&nbsp;</td>
                  <td class="td2"><input class="inp_anv1" name="" type="submit" value="登录"></td>
                </tr>
                <tr>
                  <td class="td1">&nbsp;</td>
                  <td class="td2 td_xy">
                  <a class="a2 fl" href="wjmm.php">忘记密码</a>
                    <a class="a3 fr" href="register.php">还没有账号,马上注册！</a>

                  </td>
                </tr>
            </table>
          </form>
        </div>
        <div>
          <form action="/ot/index.php?s=/Home/User/login.html" method="post" class="registerform">
            <table width="500" border="0" cellspacing="0" cellpadding="0" class="sign_table">
                <tr>
                  <td class="td1">电子邮箱</td>
                  <td class="td2">
                    <div class="div1">
                          <input type="text" value="" class="sign_inp inp_s1" name="email" datatype="n6-18" placeholder="请输入邮箱地址" errormsg="邮箱有误！" />
                        </div>
                        <div class="Validform_checktip"></div>
                      </td>
                </tr>
                <tr>
                  <td class="td1">密码</td>
                  <td class="td2">
                    <div class="div1">
                      <input type="password" value="" class="sign_inp inp_s1" name="password" datatype="n6-18" placeholder="请输入密码" errormsg="密码有误！" />
                    </div>
                    <div class="Validform_checktip"></div>
                  </td>
                </tr>
                <tr>
                  <td class="td1">验证码</td>
                  <td class="td2">
                    <div class="div1">
                      <input type="password" value="" class="sign_inp inp_s1" name="verify" datatype="n6-18" placeholder="请输入验证码" errormsg="验证码有误！"
                      style="width:40%" />
                     <a href="javascript:void(0)"><span  class="agy14_1"><img class="verifyimgs" src="<?php echo U('verify');?>" alt=""></span>看不清？</a>
                    </div>
                    <div class="Validform_checktip"></div>
                  </td>
                </tr>
                <tr>
                  <td class="td1">&nbsp;</td>
                  <td class="td2"><input class="inp_anv1" name="" type="submit" value="登录"></td>
                </tr>
                <tr>
                  <td class="td1">&nbsp;</td>
                  <td class="td2 td_xy">
                  <a class="a2 fl" href="wjmm.php">忘记密码</a>
                    <a class="a3 fr" href="register.php">还没有账号,马上注册！</a>
                  </td>
                </tr>
            </table>
          </form>

        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">jQuery(".slide_box").slide({trigger:"click"});</script>
<script type="text/javascript">
$(function(){
  //$(".registerform").Validform();  //就这一行代码！;

  $(".registerform").Validform({
    tiptype:2,
    datatype:{
      oldpassword:function(gets){
        if(gets==$("#passwordold").val()){
          return "新密码不能与旧密码一致！";
        }
      }
    },
    ajaxPost:true
  });
})

  $(document)
        .ajaxStart(function(){
          $("button:submit").addClass("log-in").attr("disabled", true);
        })
        .ajaxStop(function(){
          $("button:submit").removeClass("log-in").attr("disabled", false);
        });


      $("form").submit(function(){
        var self = $(this);
        $.post(self.attr("action"), self.serialize(), success, "json");
        return false;

        function success(data){
          if(data.status){
            window.location.href = data.url;
          } else {
            //self.find(".Validform_checktip").text(data.info);
            alert(data.info);
            //刷新验证码
            $(".agy14_1").click();
          }
        }
      });




                    $(".agy14_1").click(function(){
                      var verifyimg = $(".verifyimgs").attr("src");
                       $(".verifyimgs").attr("src", verifyimg+'&random='+Math.random());

                    });
</script>


	<!-- /主体 -->

	<!-- 底部 -->
	
<div class="bottom">
    <div class="w1200">
        <div class="bot_1">
            <ul>
                <li class="li_1">关于我们</li>
                <li><a href="">公司介绍</a></li>
                <li><a href="">公司荣誉</a></li>
                <li><a href="">加入我们</a></li>
            </ul>
            <ul>
                <li class="li_1">联系我们</li>
                <li><a href="">联系电话</a></li>
            </ul>
            <ul>
                <li class="li_1">新闻资讯</li>
                <li><a href="">公司新闻</a></li>
                <li><a href="">行业新闻</a></li>
            </ul>

            <div class="clear"></div>
        </div>
        <div class="bot_2">
            <div class="div1 fl">
                <img src="/ot/Public/Home/images/ewm.jpg" alt="">
                <p>关注微信公众号</p>
            </div>
            <div class="div1 fr">
                <img src="/ot/Public/Home/images/ewm.jpg" alt="">
                <p>关注一哥车业手机版</p>
            </div>
            <div class="clear"></div>
        </div>
        <div class="bot_3">
            <h2>0755-36631111</h2>
            <p>免费咨询(咨询、建议、投诉)</p>
            <p>周一至周六 9:00-19:00</p>
        </div>
        <div class="clear"></div>
        <div class="yqlj_div">
            <div class="div1 fl">友情链接 :</div>
            <div class="div2 fl">
                <a href="">深圳二手车</a>
                <a href="">深圳人才网</a>
                <a href="">深圳二手车</a>
                <a href="">深圳写字楼</a>
                <a href="">深圳二手车估价</a>
                <a href="">西游车展</a>
                <a href="">深圳二手车</a>
                <a href="">跟谁学深圳站</a>
                <a href="">深圳汽车网</a>
                <a href="">深圳家政</a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="bottom1">
    <div class="w1200">
        <p class="fl"><?php echo C('WEB_SITE_ICP');?></p>
        <p class="fr"><a href="">二手车出售</a><em>|</em><a href="">二手车求购</a></p>
    </div>
</div>

	<!-- /底部 -->
</body>
</html>