<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="Generator" content="EditPlus®">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta name="renderer" content="webkit">
	<title>立即登录</title>
    <link rel="stylesheet" href="/shop/Public/home/css/base.css">
    <link rel="stylesheet" type="text/css" href="/shop/Public/home/css/login.css">
    <script src="/shop/Public/home/js/jquery-3.1.1.min.js"></script>
    <script src="/shop/Public/home/js/checkcode.js"></script>
</head>
<body>
<div class="w">
	<div id="logo">
		<a href="index.html">
			<img src="/shop/Public/home/icon/logo.png" alt="">
		</a>
		<b></b>
	</div>

	<a href="#" class="q_link fr">
		<b class="fl"></b>
		登录页面，改进意见
	</a>
</div>
<div id="content">
  <div class="login-wrap">
  	<div class="w">
  		<div class="login-form">
  			<div class="login-tab login-tab-l">
  				<a href="javascript:;">扫码登录</a>
  			</div>
  			<div class="login-tab login-tab-r">
  				<a href="javascript:;">账号登录</a>
  			</div>
  			<div class="login-box" style="visibility: visible; display:block">
  			  <div class="mt tab-h"></div>
  			  <div class="msg-wrap"></div>
  			  <div class="mc">
  			  	<div class="form">
  			  		<form action="" id="formlogin" method="post" onSubmit="return false;">
  			  			<div class="item item-fore1 item-error">
  			  				<label for="loginname" class="login-label name-label"></label>
  			  				<input type="text" name="loginname" id="loginname" class="itxt" tabindex="1" autocomplete="off" placeholder="邮箱/用户名/已验证手机">
  			  				<span class="clear-btn" style="display:inline;"></span>
  			  			</div>
  			  			<!-- 密码输入框fore2 -->
  			  			<div id="entry" class="item item-fore2" style="visibility: visible">
  			  				<label class="login-label pwd-label" for="nloginpwd"></label>
  			  				<input type="password" name="" id="nloginpwd" name="nloginpwd" class="itxt itxt-error" tabindex="2" autocomplete="off" placeholder="密码">
  			  				<span class="clear-btn" style="display: inline;"></span>
  			  				<span class="capslock" style="display: none;">
  			  					<b></b>
  			  					大小写锁定已打开
  			  				</span>
  			  			</div>
  			  			<!-- 图片验证码开始 fore3-->
                        <div id="o-authcode" class="item item-vcode item-fore3 hide ">
                        	<input type="text" name="" id="authcode" class="itxt itxt02" name="authcode" tabindex="3">
                        	<input type = "button" id="code"  class="verify-code">
                        	<a href="javascript:;" onclick='createCode();'>看不清换一张</a>
                        </div>
                        <!-- 自动登录开始fore4 -->
                        <div class="item item-fore4">
                        	<div class="safe">
                        		<span>
                        			<input type="checkbox" name="chkRememberMe" id="autologin" tabindex="3">
                        			<label for>自动登录</label>
                        		</span>
                        		<span class="forget-pw-safe">
                        			<a href="">忘记密码</a>
                        		</span>
                        	</div>
                        </div>
                        <!-- 登录按钮开始 -->
                        <div class="item item-fore5">
                        	<div class="login-btn">
                        		<a href="javascript:;" class="btn-img btn-entry" id="loginsubmit" tabindex="6" onClick="validate()">登&nbsp;&nbsp;&nbsp;&nbsp;录</a>
                        	</div>
                        </div>
  			  		</form>
  			  	</div>
  			  </div>
  			</div>
  			<div class="qrcode-login">
  				<div class="mc">
  					<div class="qrcode-error-2016">
  						<div class="qrcode-error-mask"></div>
  						<p class="err-cont">服务器出错</p>
  						<a href="javascript:void(0)" class="refresh-btn">刷新</a>
  					</div>
  					<div class="qrcode-main">

  						<div class="qrcode-img" style="">
  							<img src="/shop/Public/home/login/code.png" alt="">
  							<div class="qrcode-error-02 hide" id="J-qrcodeerror" style="display: none;">
  								<a href="#none">
  									<span class="error-icon"></span>
  									<div class="txt">
  									   网络开小差咯
  									   <span class="ml10">刷新二维码</span>
  									 </div>
  								</a>
  							</div>
  						</div>

  						<div class="qrcode-help" style="display: none;"></div>
  					</div>

  					<div class="qrcode-panel">
  						<ul>
  							<li class="fore1">
  								<span>打开</span>
  								<a href="">
  									<span class="red">手机歪秀购物 </span>
  								</a>
  							</li>
  							<li>扫一扫登录</li>
  						</ul>
  					</div>
  				</div>
  			</div>

  			<div class="coagent" id="kbCoagent">
  				<ul>
  					<li class="extra-r">
  					   <div class="regist-link">
  						<a href="<?php echo U('Login/register');?>" class="">
  							<b></b>立即注册
  						</a>
  					   </div>
  					</li>
  				</ul>
  			</div>
  		</div>
  	</div>
  	<div class="login-banner" style="background-color: #ea4949">
  		<div class="w">
  			<div id="banner-bg" class="i-inner" style="background: url(/shop/Public/home/login/a1.jpg);"></div>
  		</div>
  	</div>
  </div>
</div>
<div class="w">
	<div id="footer-2013">
		<div class="links">
			<a href="">关于我们</a>
			|
			<a href="">联系我们</a>
			|
			<a href="">人才招聘</a>
			|
			<a href="">商家入驻</a>
			|
			<a href="">广告服务</a>
			|
			<a href="">手机京东</a>
			|
			<a href="">友情链接</a>
			|
			<a href="">销售联盟</a>
			|
			<a href="">English site</a>
		</div>
		<div style="padding-left:10px">
			<p style="padding-top:10px; padding-bottom:10px; color:#999">网络文化经营许可证：浙网文[2013]0268-027号| 增值电信业务经营许可证：浙B2-20080224-1</p>
			<p style="padding-bottom:10px; color:#999">信息网络传播视听节目许可证：1109364号 | 互联网违法和不良信息举报电话:0571-81683755</p>
		</div>
	</div>
</div>

</body>

<script type="text/javascript">
	//alert($)
	$(".login-tab-r").click(function(){
		$(".login-box").css({"display":"block","visibility":"visible"});
		$(".qrcode-login").css({"display":"none"})
	});
	$(".login-tab-l").click(function(){
		$(".login-box").css({"display":"none"});
		$(".qrcode-login").css({"display":"block","visibility":"visible"})
	});
	//点击微信图片显示帮助
	$(".qrcode-img").hover(function(){
		$(".qrcode-img").css({"left": "0"});
		$(".qrcode-help").css({"display":"block"});
	},function(){
		$(".qrcode-img").css({"left": "64px"});
		$(".qrcode-help").css({"display":"none"});
	});
	//确认输入用户名密码后，显示验证码
	$("#nloginpwd").blur(function(){
		if(($("#loginname").val() !="" )&&($("#nloginpwd").val() !="")){
		$("#o-authcode").css({"display":"block"});
	}
	})
	createCode();

</script>
</html>