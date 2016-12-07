<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	
<meta charset="utf-8">
<title><?php echo C('WEB_SITE_TITLE');?></title>
<meta name="keywords" content="wsg,hth">
<meta name="description" content="ASW">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="keywords" content="一哥车业">
<Meta name="description" Content="一哥车业">
<link href="/ot/Public/Home/css/css.css" rel="stylesheet" type="text/css">
<link href="/ot/Public/Home/css/selectpick/cui.css" rel="stylesheet" type="text/css"><!--美化下拉框插件-->

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/ot/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/ot/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script src="/ot/Public/Home/js/jquery.js"></script><!-- 统一调用js -->
<link href="/ot/Public/Home/css/banner-switch/lrtk.css" rel="stylesheet"><!-- banner切换 -->
<script src="/ot/Public/Home/js/banner-switch/jquery.superslide.2.1.1.js"></script><!-- banner切换 -->
<link href="/ot/Public/Home/css/SuperSlide/style.css" rel="stylesheet"><!--标签切换，滚动 -->
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>



</head>
<body>
	<!-- 头部 -->
	
<div class="head w1200">
        <ul>
            <li class="li1"><a href="index.php"><img src="/ot/Public/Home/images/logo.png" alt=""></a></li>
            <li class="li2">
                <div class="nice-select" name="nice-select">
                    <input type="text" value="深圳" readonly>
                    <ul>
                        <li data-value="1">深圳</li>
                        <li data-value="2">广州</li>
                        <li data-value="3">上海</li>
                        <li data-value="4">北京</li>
                    </ul>
                </div>
                <script>
                    $('[name="nice-select"]').click(function(e){
                        $('[name="nice-select"]').find('ul').hide();
                        $(this).find('ul').show();
                        e.stopPropagation();
                    });
                    $('[name="nice-select"] li').hover(function(e){
                        $(this).toggleClass('on');
                        e.stopPropagation();
                    });
                    $('[name="nice-select"] li').click(function(e){
                        var val = $(this).text();
                        $(this).parents('[name="nice-select"]').find('input').val(val);
                        $('[name="nice-select"] ul').hide();
                        e.stopPropagation();
                    });
                    $(document).click(function(){
                        $('[name="nice-select"] ul').hide();
                    });
                </script>
            </li>
            <li class="li3">
                <div class="inp_div">
                    <form action="" method="post">
                        <input type="text" name="" class="inp_1 fl" placeholder="请输入您想要的车">
                        <input type="submit" name="" class="inp_anv fr" value="">
                    </form>
                    <div class="clear"></div>
                </div>
                <p class="p1">
                    <a href="">大众</a>
                    <a href="">丰田</a>
                    <a href="">本田</a>
                    <a href="">奔驰</a>
                    <a href="">奥迪</a>
                    <a href="">宝马</a>
                </p>
            </li>
            <li class="li4">
                <a href="">手机版
                    <div class="div_poa">
                        <img src="/ot/Public/Home/images/head_ewm.png" alt="">
                    </div>
                </a>
            </li>
            <li class="li5">0755-36631111</li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="navigation">
        <div class="w1200">
            <div class="daoh_1 fl">
                <ul>
                <?php $__NAV__ = M('Channel')->field(true)->where("status=1")->order("sort")->select();$__NAV__ = list_to_tree($__NAV__, "id", "pid", "_"); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; $daoh = split('/',$nav['url']); ?>
                    <?php if(($nav["pid"]) == "0"): ?><li><a  href="<?php echo (get_nav_url($nav["url"])); ?>" <?php if($daoh[0] == CONTROLLER_NAME): ?>class="a1"<?php endif; ?>><?php echo ($nav["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                </ul>
                <div class="clear"></div>
            </div>
            <div class="daoh_2 fr">
                <ul>
                    <li><a class="a1" href="<?php echo U('User/login');?>">登录</a></li>
                    <li><a href="<?php echo U('User/register');?>">注册</a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    

	<!-- /头部 -->
	
	<!-- 主体 -->
	
  <div class="bannerbox1">
    <ul class="bannerpic1"><!--1920*425-->
        <li style="background: url(/ot/Public/Home/images/banner.jpg) 50% 50% no-repeat; position: absolute; width: 100%; left: 0px; top: 0px; display: list-item;"><a href="#"></a></li>
        <li style="background: url(/ot/Public/Home/images/01.jpg) 50% 50% no-repeat; position: absolute; width: 100%; left: 0px; top: 0px; display: list-item;"><a href="#"></a></li>
        <li style="background: url(/ot/Public/Home/images/banner.jpg) 50% 50% no-repeat; position: absolute; width: 100%; left: 0px; top: 0px; display: list-item;"><a href="#"></a></li>
        <li style="background: url(/ot/Public/Home/images/03.jpg) 50% 50% no-repeat; position: absolute; width: 100%; left: 0px; top: 0px; display: list-item;"><a href="#"></a></li>
    </ul>
    <a class="prev" href="javascript:void(0)"></a>
    <a class="next" href="javascript:void(0)"></a>
    <div class="num" style="display:none">
        <ul></ul>
    </div>
    <div class="ksmc">
        <h2>快速卖车<span>已有<em>293460</em>人成功卖车</span></h2>
        <form action="" method="post">
            <input class="inp_2" type="text" name="" placeholder="请输入您的手机号">
            <input class="inp_mc" name="" type="submit" value="我要卖车">
        </form>
    </div>
</div>
<script>
    $(".bannerbox1").hover(function(){
        $(this).find(".prev,.next").fadeTo("show",0.1);
    },function(){
        $(this).find(".prev,.next").hide();
    })
    $(".prev,.next").hover(function(){
        $(this).fadeTo("show",0.7);
    },function(){
        $(this).fadeTo("show",0.1);
    })
    $(".bannerbox1").slide({titCell:".num ul",mainCell:".bannerpic1",effect:"fold",autoPlay:true,delayTime:700,autoPage:true,trigger:"click"});
</script>
<!--banner end-->
<div class="brand">
    <div class="w1200 brand_div">
        <h2 class="h2_title">热门品牌</h2>
        <div class="div_sx">
            <a href="">A</a>
            <a href="">B</a>
            <a href="">C</a>
            <a href="">D</a>
            <a href="">E</a>
            <a href="">F</a>
            <a href="">G</a>
            <a href="">H</a>
            <a href="">I</a>
            <a href="">J</a>
            <a href="">K</a>
            <a href="">L</a>
            <a href="">M</a>
            <a href="">N</a>
            <a href="">O</a>
            <a href="">P</a>
            <a href="">Q</a>
            <a href="">R</a>
            <a href="">S</a>
            <a href="">T</a>
            <a href="">U</a>
            <a href="">V</a>
            <a href="">W</a>
            <a href="">X</a>
            <a href="">Y</a>
            <a href="">Z</a>
        </div>
    </div>
</div>
<div class="brand1">
    <div class="w1200">
        <div class="bra_cx1">
            <ul>
                <li><a href=""><img src="/ot/Public/Home/images/ico_1.png" alt=""><p>大众</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_2.png" alt=""><p>沃尔沃</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_3.png" alt=""><p>日产</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_4.png" alt=""><p>本田</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_5.png" alt=""><p>丰田</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_6.png" alt=""><p>奥迪</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_7.png" alt=""><p>别克</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_8.png" alt=""><p>福特</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_9.png" alt=""><p>宝马</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_10.png" alt=""><p>奔驰</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_11.png" alt=""><p>马自达</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_12.png" alt=""><p>现代</p></a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="bra_cx2">
            <ul>
                <li><a href="">低首付</a></li>
                <li><a href="">零月供</a></li>
                <li><a href="">5万以内</a></li>
                <li><a href="">5-10万</a></li>
                <li><a href="">10-15万</a></li>
                <li><a href="">15-20万</a></li>
                <li><a href="">20-30万</a></li>
                <li><a href="">30-50万</a></li>
                <li><a href="">50万以上</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="bra_cx3">
            <ul>
                <li><a href=""><img src="/ot/Public/Home/images/ico_a1.png" alt=""><p>SUV</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_a2.png" alt=""><p>面包车</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_a3.png" alt=""><p>跑车</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_a4.png" alt=""><p>MPV</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_a5.png" alt=""><p>皮卡</p></a></li>
                <li><a href=""><img src="/ot/Public/Home/images/ico_a6.png" alt=""><p>商务</p></a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="recommend">
    <div class="w1200">
        <h2 class="h2_title">热门推荐</h2>
        <div class="blank20"></div>
            <!--切换-->
            <div class="scrollBox" style="margin:0 auto">
            <div class="ohbox">
                    <ul class="piclist hot_ul">
                        <li>
                        <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/1.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                        </a>
                        </li>
                        <li>
                        <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/2.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                        </a>
                        </li>
                        <li>
                        <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/3.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                        </a>
                        </li>
                        <li>
                        <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/4.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                        </a>
                        </li>
                        <li>
                            <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/5.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/6.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/7.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="sell_xx.php" target="_blank">
                                <img src="/ot/Public/Home/images/8.jpg" />
                                <span class="span_poa">新</span>
                                <div class="li_product">
                                    <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                                    <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                                    <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                                </div>
                            </a>
                        </li>
                    </ul>
            </div>
            <div class="pageBtn">
                <span class="prev">&lt;</span>
                <span class="next">&gt;</span>
                <ul class="list" style="display:none"><li>0</li><li>1</li></ul>
            </div>
    </div>
    <script type="text/javascript">
        jQuery(".scrollBox").slide({ titCell:".list li", mainCell:".piclist", effect:"left",vis:4,scroll:4,delayTime:800,trigger:"click",easing:"easeOutCirc"});
    </script>

    </div>
</div>

<div class="slide_box hot_div w1200">
    <div class="hd hot_sx">
        <h2 class="h2_title">热门好车</h2>
        <ul class="ul_1"><li>最新车源</li><li>最热车源</li></ul>
    </div>
    <div class="blank30"></div>
    <div class="bd">
        <div>
            <ul class="hot_ul product_ul">
                <?php for($i=0;$i<4;$i++){?>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/1.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/2.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/3.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/4.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <?php }?>
            </ul>
            <div class="clear"></div>
            <div class="div_anv"><a href="">查看更多</a></div>
        </div>
        <div>
            <ul class="hot_ul product_ul">
                <?php for($i=0;$i<4;$i++){?>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/8.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/7.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/6.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="sell_xx.php">
                        <img src="/ot/Public/Home/images/5.jpg" />
                        <span class="span_poa">新</span>
                        <div class="li_product">
                            <h2>大众宝来 2013款 宝来 1.6 自动 舒适版</h2>
                            <p class="p1">2013年7月上牌 | 行驶11.7万公里</p>
                            <p class="p2"><b>7.00万</b> <em>13.90万</em><i>认证</i></p>
                        </div>
                    </a>
                </li>
                <?php }?>
            </ul>
            <div class="clear"></div>
            <div class="div_anv"><a href="">查看更多</a></div>
        </div>
    </div>
</div>
<script type="text/javascript">jQuery(".slide_box").slide({trigger:"click"});</script>
<div class="blank45"></div>
<div class="w1200 article">
    <div class="article_fl">
        <div class="redian_article">
            <span class="span_poa"><img src="/ot/Public/Home/images/biaot_1.jpg" alt=""></span>
            <div class="div1"><img src="/ot/Public/Home/images/t1.jpg" alt=""></div>
            <div class="div2">
                <ul>
                    <li><a href="">QuestMobile二手车电商数据解读</a></li>
                    <li><a href="">完成D轮1.5亿美元融资 王思聪参投</a></li>
                    <li><a href="">用户自述两次购车经历：人人车，靠谱！</a></li>
                    <li><a href="">没什么比善良更重要，产品也是</a></li>
                    <li><a href="">二手车电商大战，，凭什么？</a></li>
                    <li><a href="">完成D轮1.5亿美元融资 王思聪参投</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="article_fr">
        <a href=""><div class="selected_div">
            <span class="span_poa"><img src="/ot/Public/Home/images/biaot_2.jpg" alt=""></span>
            <div class="div1 fl"><img src="/ot/Public/Home/images/t2.jpg" alt=""></div>
            <div class="div2 fr">
                <h2>帅到飞起，用十年二手老车漂出绝尘弧线</h2>
                <p>帅气有型的头部，硬朗不失动感的身姿，少见的原装尾翼，大鹏眼中永远的驾驶者之车。高智商学霸仅花3天购车，他的经验是？老李，对风险和不可靠因素有着灵敏的嗅觉。2016年8月他在得一辆大众迈腾。</p>
            </div>
            <div class="clear"></div>
        </div></a>
        <div class="blank45"></div>
        <a href=""><div class="selected_div">
            <span class="span_poa"><img src="/ot/Public/Home/images/biaot_3.jpg" alt=""></span>
            <div class="div1 fl"><img src="/ot/Public/Home/images/t3.jpg" alt=""></div>
            <div class="div2 fr">
                <h2>帅到飞起，用十年二手老车漂出绝尘弧线</h2>
                <p>帅气有型的头部，硬朗不失动感的身姿，少见的原装尾翼，大鹏眼中永远的驾驶者之车。高智商学霸仅花3天购车，他的经验是？老李，对风险和不可靠因素有着灵敏的嗅觉。2016年8月他在得一辆大众迈腾。</p>
            </div>
            <div class="clear"></div>
        </div></a>
    </div>
    <div class="clear"></div>
</div>
<div class="blank40"></div>


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