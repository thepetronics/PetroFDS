jQuery(window).load(function() {
	/* demo */
	
	jQuery('body').append("<div class='demo_navigation'>	<div class='demo_options'>		<!-- SKIN -->		<div class='nav_skin'>			<div class='demo-title'>Sexy Food</div>		</div>		<!--  Theme Layout -->		<div class='gnrl_color pt_touch clearfix'>			</div>		<!--  Skins Colors -->		<div class='gnrl_color pt_touch clearfix'>			<div class='demo-title'>Skins Colors</div>			<div class='demo-content demo- demo-color'>				<div data-radio='skin' style='background-color: #71a866;'></div>				<input type='radio' name='gnrl_color' value='skins'>							<div data-radio='skin' style='background-color: #d02e37;'></div>				<input type='radio' name='gnrl_color' value='red'>							<div data-radio='skin' style='background-color: #8e74b2;'></div>				<input type='radio' name='gnrl_color' value='purple'>							<div data-radio='skin' style='background-color: #fa7642;'></div>				<input type='radio' name='gnrl_color' value='orange'>							<div data-radio='skin' style='background-color: #16a085;'></div>				<input type='radio' name='gnrl_color' value='green'>							<div data-radio='skin' style='background-color: #3498db;'></div>				<input type='radio' name='gnrl_color' value='blue'>	</div></div>	<div class='clear'></div><div class='push_options'><a class='show_hide'><i class='icon-cog'></i></a></div></div>");
	
	jQuery('head').append("<style type='text/css'>.demo_navigation{position:fixed;z-index:99999;left:-255px;top:5%;width:255px;padding:0px;border-left:none;background:#363636;padding-bottom:15px;}.demo_options .demo-title{color:white;width:255px;margin-right: 0;font-size:13px;}.demo_options .nav_skin .demo-title:first-child{background:#313131;padding:16px;}.demo_options .demo-title{padding:10px 0 25px 17px;}.demo_options .nav_skin .demo-content{padding:10px 0 10px 17px;}.demo_options .demo-content{color:white;width:225px;font-size:13px;}.nav_skin .demo-contentlabel{display:block;}.schemasa{display:block;height:42px;margin-bottom:5px;outline:medium none;overflow:hidden;text-indent:-999px;width:64px;background:transparent;}.demo_navigation img{border:1px solid #9f9f9f;margin:2px;}.demo_navigation img.imgSelected{border-color:red;}.show_hide{cursor:pointer;width:100%;height:100%;display:block;}.push_options{width:55px;height:55px;position:absolute;top:0px;right:-55px;background: #313131;display:block;line-height:55px;font-size:27px;text-align:center;margin:0;padding:0}.push_options a{color:#FFF;}.demo_options{float:right;}.demo_options input[type='radio']{display:none;}.pt_touch div{width:22px;height:22px;float:left;margin:3px;overflow:hidden;cursor:pointer;}.bg_image div {width:50px;height:30px}.pt_touch.bg_image > div.demo-content {height:35px;}.pt_touch > div{margin-left:12px;width:200px;}.pt_touch > div.demo-title{margin-left:0;}.pt_touch > div.demo-content.demo-color{height:30px;}.pt_touch > div.demo-content{height:53px;}.demo-content_2 {height:25px !important;}.bd-span{	float: left;	background-color: #FFF;	color: #AAA !important;	border: #DDD 2px solid;	padding: 4px 5px 5px;	border-radius: 2px;	overflow: hidden;	display: inline-block;	text-align: center;	font-size: 14px;}.bd-span:hover{	border-color: #7ab317;	background-color: #7ab317;	box-shadow: inset 0 0 0 1px #FFFFFF;	color: #FFF !important;}@media only screen and (max-width: 479px) {.demo_navigation {display:none}}</style>");
		
	var emerald_gnrl_color=false;

	jQuery('.show_hide').click(function(){
		if(jQuery(".demo_navigation").css('left') == '0px'){
			left = -255;
		} else{
			left = 0;
		}
		jQuery(".demo_navigation").animate({
			left: left
		});
	 
	});
	jQuery('.demo_options img').click(function() {
		group = jQuery(this).attr('data-radio');
		jQuery('.'+group+' img').each(function(){
			jQuery(this).removeClass('imgSelected');
		});        
		jQuery(this).addClass('imgSelected');
		jQuery(this).next().attr('checked', 'checked');
		jQuery(this).next().change();
	});
	jQuery('.demo_options>.pt_touch .demo-content>div').click(function() {
		jQuery(this).siblings('div').removeClass('imgSelected'); 
		jQuery(this).addClass('imgSelected');
		jQuery(this).next().attr('checked', 'checked');
		jQuery(this).next().change();
	});
	

	jQuery('[data-radio="skin"][class="imgSelected"]').click();
	// ttgnrlcolors
	jQuery('input[name=gnrl_color]').change(function() {
		emerald_gnrl_color = jQuery(this).val();
		if(emerald_gnrl_color!=false){
			pointer_recolor(emerald_gnrl_color);
		}
	});
	jQuery('[data-radio="gnrl_color"][class="imgSelected"]').click();
	// General Color Picker
	function pointer_recolor(color_style){
		if (color_style == "skins") {
			jQuery(".logo a img").attr("src","images/logo.png");
			if (jQuery(".logo").hasClass("logo-2")) {
				jQuery(".logo a img").attr("src","images/logo-2.png");
			}else if (jQuery("#header").hasClass("header-4")) {
				jQuery(".logo a img").attr("src","images/logo-3.png");
			}else {
				jQuery(".logo a img").attr("src","images/logo.png");
			}
		}else if (color_style != "skins") {
			if (jQuery(".logo").hasClass("logo-2")) {
				jQuery(".logo a img").attr("src","images/"+color_style+"/logo-2.png");
			}else if (jQuery("#header").hasClass("header-4")) {
				jQuery(".logo a img").attr("src","images/"+color_style+"/logo-3.png");
			}else {
				jQuery(".logo a img").attr("src","images/"+color_style+"/logo.png");
			}
		}
		jQuery('head').append('<link rel="stylesheet" href="css/skins/'+color_style+'.css">');
	}
	
});