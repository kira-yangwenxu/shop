<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
 <head>
	<meta charset="UTF-8">
	<meta name="Generator" content="EditPlus®">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"> 
	<meta name="renderer" content="webkit">
    <meta content="歪秀购物, 购物, 大家电, 手机" name="keywords">
    <meta content="歪秀购物，购物商城。" name="description">
	<title>会员系统我的收藏</title>
    <link rel="shortcut icon" type="image/x-icon" href="/shop/Public/home/icon/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/shop/Public/home/css/base.css">
	<link rel="stylesheet" type="text/css" href="/shop/Public/home/css/member.css">
    <script type="text/javascript" src="/shop/Public/home/js/jquery.js"></script>
    <script type="text/javascript">
         (function(a){
             a.fn.hoverClass=function(b){
                 var a=this;
                 a.each(function(c){
                     a.eq(c).hover(function(){
                         $(this).addClass(b)
                     },function(){
                         $(this).removeClass(b)
                     })
                 });
                 return a
             };
         })(jQuery);

         $(function(){
             $("#pc-nav").hoverClass("current");
         });
     </script>

     <script>
         $(function(){

             $("#H-table li").each(function(i){
                 $(this).click((function(k){
                     var _index = k;
                     return function(){
                         $(this).addClass("cur").siblings().removeClass("cur");
                         $(".H-over").hide();
                         $(".H-over:eq(" + _index + ")").show();
                     }
                 })(i));
             });
             $("#H-table1 li").each(function(i){
                 $(this).click((function(k){
                     var _index = k;
                     return function(){
                         $(this).addClass("cur").siblings().removeClass("cur");
                         $(".H-over1").hide();
                         $(".H-over1:eq(" + _index + ")").show();
                     }
                 })(i));
             });
         });
     </script>


 </head>
 <body>

<!--- header begin-->
<header id="pc-header">
    <div class="BHeader">
        <div class="yNavIndex">
            <ul class="BHeaderl">
                <li><a href="#">登录</a> </li>
                <li class="headerul">|</li>
                <li><a href="#">订单查询</a> </li>
                <li class="headerul">|</li>
                <li><a href="#">我的收藏</a> </li>
                <li class="headerul">|</li>
                <li id="pc-nav" class="menu"><a href="#" class="tit">我的商城</a>
                    <div class="subnav">
                        <a href="#">我的山城</a>
                        <a href="#">我的山城</a>
                        <a href="#">我的山城</a>
                    </div>
                </li>
                <li class="headerul">|</li>
                <li><a href="#" class="M-iphone">手机悦商城</a> </li>
            </ul>
        </div>
    </div>
    <div class="container clearfix">
        <div class="header-logo fl"><h1><a href="#"><img src="/shop/Public/home/icon/logo.png"></a> </h1></div>
        <div class="member-title fl"><h2></h2></div>
        <div class="head-form fl">
            <form class="clearfix">
                <input type="text" class="search-text" accesskey="" id="key" autocomplete="off"  placeholder="洗衣机">
                <button class="button" onClick="search('key');return false;">搜索</button>
            </form>
            <div class="words-text clearfix">
                <a href="#" class="red">1元秒爆</a>
                <a href="#">低至五折</a>
                <a href="#">农用物资</a>
                <a href="#">买一赠一</a>
                <a href="#">佳能相机</a>
                <a href="#">稻香村月饼</a>
                <a href="#">服装城</a>
            </div>
        </div>
        <div class="header-cart fr"><a href="#"><img src="/shop/Public/home/icon/car.png"></a> <i class="head-amount">99</i></div>
    </div>
</header>
<!-- header End -->

<div class="containers"><div class="pc-nav-item"><a href="#">首页</a> &gt; <a href="#">会员中心 </a> &gt; <a href="#">商城快讯</a></div></div>

<!-- 商城快讯 begin -->
<section id="member">
    <div class="member-center clearfix">
        <div class="member-left fl">
            <div class="member-apart clearfix">
                <div class="fl"><a href="#"><img src="/shop/Public/home/img/bg/mem.png"></a></div>
                <div class="fl">
                    <p>用户名：</p>
                    <p><a href="#">亚里士多德</a></p>
                    <p>搜悦号：</p>
                    <p>389323080</p>
                </div>
            </div>
            <div class="member-lists">
                <dl>
                    <dt>我的商城</dt>
                    <dd><a href="#">我的订单</a></dd>
                    <dd><a href="#">我的收藏</a></dd>
                    <dd><a href="#">账户安全</a></dd>
                    <dd><a href="#">我的评价</a></dd>
                    <dd><a href="#">地址管理</a></dd>
                </dl>
                <dl>
                    <dt>客户服务</dt>
                    <dd class="cur"><a href="#">退货申请</a></dd>
                    <dd><a href="#">退货/退款记录</a></dd>
                </dl>
                <dl>
                    <dt>我的消息</dt>
                    <dd><a href="#">商城快讯</a></dd>
                    <dd><a href="#">帮助中心</a></dd>
                </dl>
            </div>
        </div>
        <div class="member-right fr">
            <div class="member-head">
                <div class="member-heels fl"><h2>我的收藏</h2></div>
                <div class="member-backs member-icons fr"><a href="#">搜索</a></div>
                <div class="member-about fr"><input type="text" placeholder="商品名称/商品编号/订单编号"></div>
            </div>
            <div class="member-switch clearfix">
                <ul id="H-table" class="H-table">
                    <li><a href="#">我的收藏的商品</a></li>
                    <li class="cur"><a href="#">我收藏的店铺</a></li>
                </ul>
            </div>
            <div class="member-border">
               <div class="member-return H-over"  style="display:none;">
                   <div class="member-troll clearfix">
                       <div class="member-all fl"><b class="on"></b>全选</div>
                       <div class="member-check clearfix fl"> <a href="#">加入购物车</a> <a href="#" class="member-delete">删除商品</a> </div>
                   </div>
                   <div class="time-border-list pc-search-list member-all1 clearfix">
                       <ul class="clearfix">
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><b class="on"></b><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><b></b><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><b></b><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><b class="on"></b><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><b></b><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>
                           <li>
                               <a href="#"> <img src="/shop/Public/home/img/pd/hot2.png"></a>
                               <p class="head-name"><b></b><a href="#">小米 4 2GB内存版 白色 移动4G手机不锈钢金属边框、 5英寸屏窄边，工艺和手感</a> </p>
                               <p><span class="price">￥138.00</span></p>
                           </li>

                       </ul>
                   </div>
               </div>
               <div class="member-return H-over">
                   <div class="member-troll clearfix">
                       <div class="member-all fl"><b class="on"></b>全选</div>
                       <div class="member-check clearfix fl"> <a href="#" class="member-delete">删除商品</a> </div>
                   </div>
                   <div class="member-vessel">
                       <ul>
                           <li class="clearfix">
                               <div class="member-tenant fl clearfix">
                                   <div class="fl member-all1 member-all2"><b class="on"></b></div>
                                   <div class="fr">
                                       <a href="#"><img src="/shop/Public/home/icon/shop-ll.png" width="114" height="114" title=""></a>
                                       <p>秋水伊人官方旗舰店</p>
                                       <p><a href="#" class="member-shops">进入店铺</a> </p>
                                       <p>关注人气：1000+</p>
                                       <p>收藏时间：2014-11-21</p>
                                   </div>
                               </div>

                               <div class="member-volume fl">
                                   <a href="#" class="fl member-btn-fl"></a>
                                   <div class="member-cakes fl">
                                       <ul>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m3.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m4.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m5.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m3.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                       </ul>
                                   </div>
                                   <a href="#" class="fr member-btn-fr"></a>
                               </div>
                           </li>
                           <li class="clearfix">
                               <div class="member-tenant fl clearfix">
                                   <div class="fl member-all1 member-all2"><b class="on"></b></div>
                                   <div class="fr">
                                       <a href="#"><img src="/shop/Public/home/icon/shop-ll.png" width="114" height="114" title=""></a>
                                       <p>秋水伊人官方旗舰店</p>
                                       <p><a href="#" class="member-shops">进入店铺</a> </p>
                                       <p>关注人气：1000+</p>
                                       <p>收藏时间：2014-11-21</p>
                                   </div>
                               </div>

                               <div class="member-volume fl">
                                   <a href="#" class="fl member-btn-fl"></a>
                                   <div class="member-cakes fl">
                                       <ul>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m3.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m4.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m5.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                           <li>
                                               <a href="#"><img src="/shop/Public/home/img/pd/m3.png" width="125" height="125" title=""></a>
                                               <p>￥78.00</p>
                                           </li>
                                       </ul>
                                   </div>
                                   <a href="#" class="fr member-btn-fr"></a>
                               </div>
                           </li>
                       </ul>
                   </div>
               </div>



                <div class="clearfix" style="padding:30px 20px;">
                    <div class="fr pc-search-g pc-search-gs">
                        <a style="display:none" class="fl " href="#">上一页</a>
                        <a href="#" class="current">1</a>
                        <a href="javascript:;">2</a>
                        <a href="javascript:;">3</a>
                        <a href="javascript:;">4</a>
                        <a href="javascript:;">5</a>
                        <a href="javascript:;">6</a>
                        <a href="javascript:;">7</a>
                        <span class="pc-search-di">…</span>
                        <a href="javascript:;">1088</a>
                        <a title="使用方向键右键也可翻到下一页哦！" class="" href="javascript:;">下一页</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- 商城快讯 End -->

<!--- footer begin-->
<div class="aui-footer-bot">
    <div class="time-lists aui-footer-pd clearfix">
        <div class="aui-footer-list clearfix">
            <h4>
                <span><img src="/shop/Public/home/icon/icon-d1.png"></span>
                <em>消费者权益</em>
            </h4>
            <ul>
                <li><a href="#">保障范围 </a> </li>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">服务中心 </a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
            </ul>
        </div>
        <div class="aui-footer-list clearfix">
            <h4>
                <span><img src="/shop/Public/home/icon/icon-d2.png"></span>
                <em>新手上路</em>
            </h4>
            <ul>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">服务中心 </a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
            </ul>
        </div>
        <div class="aui-footer-list clearfix">
            <h4>
                <span><img src="/shop/Public/home/icon/icon-d3.png"></span>
                <em>保障正品</em>
            </h4>
            <ul>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">服务中心 </a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
            </ul>
        </div>
        <div class="aui-footer-list clearfix">
            <h4>
                <span><img src="/shop/Public/home/icon/icon-d1.png"></span>
                <em>消费者权益</em>
            </h4>
            <ul>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">服务中心 </a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
            </ul>
        </div>
    </div>
    <div style="border-bottom:1px solid #dedede"></div>
    <div class="time-lists aui-footer-pd time-lists-ls clearfix">
        <div class="aui-footer-list clearfix">
            <h4>购物指南</h4>
            <ul>
                <li><a href="#">保障范围 </a> </li>
                <li><a href="#">购物流程</a> </li>
                <li><a href="#">会员介绍 </a> </li>
                <li><a href="#">生活旅行</a> </li>
                <li><a href="#"> 常见问题 </a> </li>
                <li><a href="#"> 联系客服购物指南 </a> </li>
            </ul>
        </div>
        <div class="aui-footer-list clearfix">
            <h4>特色服务</h4>
            <ul>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">服务中心 </a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
            </ul>
        </div>
        <div class="aui-footer-list clearfix">
            <h4>帮助中心</h4>
            <ul>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">服务中心 </a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
            </ul>
        </div>
        <div class="aui-footer-list clearfix">
            <h4>新手指导</h4>
            <ul>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">退货退款流程</a> </li>
                <li><a href="#">服务中心 </a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#">服务中心</a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
                <li><a href="#"> 更多特色服务 </a> </li>
            </ul>
        </div>
    </div>
</div>
<!-- footer End -->
</body>
</html>