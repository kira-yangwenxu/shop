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
	<title>会员系统我的订单</title>
    <link rel="shortcut icon" type="image/x-icon" href="/shop/Public/home/icon/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/shop/Public/home/css/base.css">
	<link rel="stylesheet" type="text/css" href="/shop/Public/home/css/member.css">
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
                <div class="member-heels fl"><h2>订单号：1234567890</h2></div>
                <div class="member-backs fr"><a href="#">返回订单首页</a></div>
            </div>
            <div class="member-border">
               <div class="member-order">
                   <dl>
                       <dt>发货信息</dt>
                       <dd class="member-seller">卖家已发货 <a href="#">（物流查询）</a> </dd>
                   </dl>
                   <dl class="member-custom clearfix ">
                       <dt>订单信息</dt>
                       <dd>订单编号：98654091436</dd>
                       <dd>订单金额：￥10000000</dd>
                       <dd>付款时间：2015-09-22 08：22</dd>
                       <dd>发货时间：2015-09-22 08：22</dd>
                   </dl>
                   <dl>
                       <dt>配送信息</dt>
                       <dd class="member-seller"><span>收货地址：<em>张子琪</em></span> <span>18801066117</span> <span>北京市海淀区中关村南街99号，幸福小区3号楼4门401</span></dd>
                   </dl>
                   <dl class="member-custom clearfix ">
                       <dt>发票信息</dt>
                       <dd>发票类型：电子发票 发票下载</dd>
                       <dd>发票抬头：公司</dd>
                       <dd>发票内容：化妆品</dd>
                   </dl>
                   <dl>
                       <dt>商品信息</dt>
                       <dd class="member-seller">本订单是由 “以纯甲醇旗舰店” 发货并且提高售后服务，商品在下单后会尽快给您发货。 </dd>
                   </dl>
               </div>
               <div class="member-serial">
                   <ul>
                       <li class="clearfix">
                           <div class="No1">商品编号</div>
                           <div class="No2">商品详情</div>
                           <div class="No3">数量</div>
                           <div class="No4">单价</div>
                           <div class="No5">小计</div>
                       </li>
                       <li class="clearfix">
                           <div class="No1">987645</div>
                           <div class="No2"><a href="#">BWXD日系复古男士松紧腰小脚九分裤简约休闲收口运动潮裤垮裤百搭</a> </div>
                           <div class="No3">1</div>
                           <div class="No4">￥78.00</div>
                           <div class="No5">￥99.00</div>
                       </li>
                       <li class="clearfix">
                           <div class="No1">908756</div>
                           <div class="No2"><a href="#">现货包邮小米手环充电线 小米手环充电器 小米手环数据线 有腕带</a> </div>
                           <div class="No3">2</div>
                           <div class="No4">￥78.00</div>
                           <div class="No5">￥99.00</div>
                       </li>
                   </ul>
               </div>
            </div>
            <div class="member-settle clearfix">
                <div class="fr">
                    <div><span>商品金额：</span><em>￥270.00</em></div>
                    <div><span>运费：</span><em>￥270.00</em></div>
                    <div class="member-line"></div>
                    <div><span>共需支付：</span><em>￥280.00</em></div>
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