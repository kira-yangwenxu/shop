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
	<title>会员系统退货申请</title>
    <link rel="shortcut icon" type="image/x-icon" href="/shop/Public/home/icon/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/shop/Public/home/css/base.css">
	<link rel="stylesheet" type="text/css" href="/shop/Public/home/css/member.css">
    <script type="text/javascript" src="/shop/Public/home/js/jquery.js"></script>
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
                    <dd class="cur"><a href="#">我的订单</a></dd>
                    <dd><a href="#">我的收藏</a></dd>
                    <dd><a href="#">账户安全</a></dd>
                    <dd><a href="#">我的评价</a></dd>
                    <dd><a href="#">地址管理</a></dd>
                </dl>
                <dl>
                    <dt>客户服务</dt>
                    <dd><a href="#">退货申请</a></dd>
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
                <div class="member-heels fl"><h2>我的订单</h2></div>
                <div class="member-backs member-icons fr"><a href="#">搜索</a></div>
                <div class="member-about fr"><input type="text" placeholder="商品名称/商品编号/订单编号"></div>
            </div>
            <div class="member-whole clearfix">
                <ul id="H-table" class="H-table">
                    <li class="cur"><a href="#">我的订单</a></li>
                    <li><a href="#">待付款<em>(44)</em></a></li>
                    <li><a href="#">待发货</a></li>
                    <li><a href="#">待收货</a></li>
                    <li><a href="#">交易完成</a></li>
                    <li><a href="#">订单信息</a></li>
                </ul>
            </div>
            <div class="member-border">
               <div class="member-return H-over">
                   <div class="member-cancel clearfix">
                       <span class="be1">订单信息</span>
                       <span class="be2">收货人</span>
                       <span class="be2">订单金额</span>
                       <span class="be2">订单时间</span>
                       <span class="be2">订单状态</span>
                       <span class="be2">订单操作</span>
                   </div>
                   <div class="member-sheet clearfix">
                       <ul>
                           <li>
                               <div class="member-minute clearfix">
                                   <span>2015-09-22 18:22:33</span>
                                   <span>订单号：<em>98653056821</em></span>
                                   <span><a href="#">以纯甲醇旗舰店</a></span>
                                   <span class="member-custom">客服电话：<em>010-6544-0986</em></span>
                               </div>
                               <div class="member-circle clearfix">
                                   <div class="ci1">
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m1.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">红米Note2 标准版 白色 移动4G手机 双卡双待</a></span>
                                           <span class="gr3">X1</span>
                                       </div>
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m2.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">AXON天机mini NBA限量版</a></span>
                                           <span class="gr3">X9</span>
                                       </div>
                                   </div>
                                   <div class="ci2" >张子琪</div>
                                   <div class="ci3"><b>￥120.00</b><p>货到付款</p><p class="iphone">手机订单</p></div>
                                   <div class="ci4"><p>2015-09-22</p></div>
                                   <div class="ci5"><p>等待付款</p> <p><a href="#">物流跟踪</a></p> <p><a href="#">订单详情</a></p></div>
                                   <div class="ci5 ci8"><p>剩余15时20分</p> <p><a href="#" class="member-touch">立即支付</a> </p> <p><a href="#">取消订单</a> </p></div>
                               </div>
                           </li>
                           <li>
                               <div class="member-minute clearfix">
                                   <span>2015-09-22 18:22:33</span>
                                   <span>订单号：<em>98653056821</em></span>
                                   <span><a href="#">以纯甲醇旗舰店</a></span>
                                   <span class="member-custom">客服电话：<em>010-6544-0986</em></span>
                               </div>
                               <div class="member-circle clearfix">
                                   <div class="ci1">
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m1.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">红米Note2 标准版 白色 移动4G手机 双卡双待</a></span>
                                           <span class="gr3">X1</span>
                                       </div>
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m2.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">AXON天机mini NBA限量版</a></span>
                                           <span class="gr3">X9</span>
                                       </div>
                                   </div>
                                   <div class="ci2" >张子琪</div>
                                   <div class="ci3"><b>￥120.00</b><p>货到付款</p><p class="iphone">手机订单</p></div>
                                   <div class="ci4"><p>2015-09-22</p></div>
                                   <div class="ci5"><p>等待卖家发货 </p> <p><a href="#">订单详情</a></p></div>
                                   <div class="ci5 ci8"><p><a href="#" class="member-touch">提醒发货</a> </p> <p><a href="#">取消订单</a> </p></div>
                               </div>
                           </li>
                           <li>
                               <div class="member-minute clearfix">
                                   <span>2015-09-22 18:22:33</span>
                                   <span>订单号：<em>98653056821</em></span>
                                   <span><a href="#">以纯甲醇旗舰店</a></span>
                                   <span class="member-custom">客服电话：<em>010-6544-0986</em></span>
                               </div>
                               <div class="member-circle clearfix">
                                   <div class="ci1">
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m1.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">红米Note2 标准版 白色 移动4G手机 双卡双待</a></span>
                                           <span class="gr3">X1</span>
                                       </div>
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m2.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">AXON天机mini NBA限量版</a></span>
                                           <span class="gr3">X9</span>
                                       </div>
                                   </div>
                                   <div class="ci2" >张子琪</div>
                                   <div class="ci3"><b>￥120.00</b><p>货到付款</p><p class="iphone">手机订单</p></div>
                                   <div class="ci4"><p>2015-09-22</p></div>
                                   <div class="ci5"><p>已完成</p> <p><a href="#">订单详情</a></p></div>
                                   <div class="ci5 ci8"><p><a href="#">查看</a></p> </p><p><a href="#" class="member-touch">确认收货</a></p></div>
                               </div>
                           </li>
                           <li>
                               <div class="member-minute clearfix">
                                   <span>2015-09-22 18:22:33</span>
                                   <span>订单号：<em>98653056821</em></span>
                                   <span><a href="#">以纯甲醇旗舰店</a></span>
                                   <span class="member-custom">客服电话：<em>010-6544-0986</em></span>
                               </div>
                               <div class="member-circle clearfix">
                                   <div class="ci1">
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m1.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">红米Note2 标准版 白色 移动4G手机 双卡双待</a></span>
                                           <span class="gr3">X1</span>
                                       </div>
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m2.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">AXON天机mini NBA限量版</a></span>
                                           <span class="gr3">X9</span>
                                       </div>
                                   </div>
                                   <div class="ci2" >张子琪</div>
                                   <div class="ci3"><b>￥120.00</b><p>货到付款</p><p class="iphone">手机订单</p></div>
                                   <div class="ci4"><p>2015-09-22</p></div>
                                   <div class="ci5"><p>已完成</p> <p><a href="#">订单详情</a></p></div>
                                   <div class="ci5 ci8"><p><a href="#">查看</a> | <a href="#">删除</a></p> </p><p><a href="#" class="member-touch">确认收货</a></p></div>
                               </div>
                           </li>
                       </ul>
                   </div>
               </div>
               <div class="member-return H-over" style="display:none;">
                   <div class="member-cancel clearfix">
                       <span class="be1">订单信息</span>
                       <span class="be2">收货人</span>
                       <span class="be2">订单金额</span>
                       <span class="be2">订单时间</span>
                       <span class="be2">订单状态</span>
                       <span class="be2">订单操作</span>
                   </div>
                   <div class="member-sheet clearfix">
                       <ul>
                           <li>
                               <div class="member-minute clearfix">
                                   <span>2015-09-22 18:22:33</span>
                                   <span>订单号：<em>98653056821</em></span>
                                   <span><a href="#">以纯甲醇旗舰店</a></span>
                                   <span class="member-custom">客服电话：<em>010-6544-0986</em></span>
                               </div>
                               <div class="member-circle clearfix">
                                   <div class="ci1">
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m1.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">红米Note2 标准版 白色 移动4G手机 双卡双待</a></span>
                                           <span class="gr3">X1</span>
                                       </div>
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m2.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">AXON天机mini NBA限量版</a></span>
                                           <span class="gr3">X9</span>
                                       </div>
                                   </div>
                                   <div class="ci2" >张子琪</div>
                                   <div class="ci3"><b>￥120.00</b><p>货到付款</p><p class="iphone">手机订单</p></div>
                                   <div class="ci4"><p>2015-09-22</p></div>
                                   <div class="ci5"><p>已申请退货</p> <p><a href="#">退货日志</a></p></div>
                                   <div class="ci6"><p><a href="#">取消退货</a> </p></div>
                               </div>
                           </li>
                           <li>
                               <div class="member-minute clearfix">
                                   <span>2015-09-22 18:22:33</span>
                                   <span>订单号：<em>98653056821</em></span>
                                   <span><a href="#">以纯甲醇旗舰店</a></span>
                                   <span class="member-custom">客服电话：<em>010-6544-0986</em></span>
                               </div>
                               <div class="member-circle clearfix">
                                   <div class="ci1">
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m1.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">红米Note2 标准版 白色 移动4G手机 双卡双待</a></span>
                                           <span class="gr3">X1</span>
                                       </div>
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m2.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">AXON天机mini NBA限量版</a></span>
                                           <span class="gr3">X9</span>
                                       </div>
                                   </div>
                                   <div class="ci2" >张子琪</div>
                                   <div class="ci3"><b>￥120.00</b><p>货到付款</p><p class="iphone">手机订单</p></div>
                                   <div class="ci4"><p>2015-09-22</p></div>
                                   <div class="ci5"><p>已完成</p> <p><a href="#">订单详情</a></p></div>
                                   <div class="ci6"><p><a href="#">取消退货</a> </p></div>
                               </div>
                           </li>
                           <li>
                               <div class="member-minute clearfix">
                                   <span>2015-09-22 18:22:33</span>
                                   <span>订单号：<em>98653056821</em></span>
                                   <span><a href="#">以纯甲醇旗舰店</a></span>
                                   <span class="member-custom">客服电话：<em>010-6544-0986</em></span>
                               </div>
                               <div class="member-circle clearfix">
                                   <div class="ci1">
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m1.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">红米Note2 标准版 白色 移动4G手机 双卡双待</a></span>
                                           <span class="gr3">X1</span>
                                       </div>
                                       <div class="ci7 clearfix">
                                           <span class="gr1"><a href="#"><img src="/shop/Public/home/img/pd/m2.png" width="60" height="60" title="" about=""></a></span>
                                           <span class="gr2"><a href="#">AXON天机mini NBA限量版</a></span>
                                           <span class="gr3">X9</span>
                                       </div>
                                   </div>
                                   <div class="ci2" >张子琪</div>
                                   <div class="ci3"><b>￥120.00</b><p>货到付款</p><p class="iphone">手机订单</p></div>
                                   <div class="ci4"><p>2015-09-22</p></div>
                                   <div class="ci5"><p>已完成</p> <p><a href="#">订单详情</a></p></div>
                                   <div class="ci6"><p><a href="#">取消退货</a> </p></div>
                               </div>
                           </li>
                       </ul>
                   </div>
               </div>
               <div class="H-over member-over" style="display:none;"><h2>待发货</h2></div>
               <div class="H-over member-over" style="display:none;"><h2>待收货</h2></div>
               <div class="H-over member-over" style="display:none;"><h2>交易完成</h2></div>
               <div class="H-over member-over" style="display:none;"><h2>订单信息</h2></div>

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