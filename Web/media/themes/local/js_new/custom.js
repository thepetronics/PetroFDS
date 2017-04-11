(function($) { "use strict";

	

	/* Menu */

	

	jQuery(".navigation ul a").removeAttr("title");

	jQuery(".navigation ul ul").css({display: "none"});

	jQuery(".navigation ul li").each(function() {	

		var sub_menu = jQuery(this).find("ul:first");

		jQuery(this).hover(function() {	

			sub_menu.stop().css({overflow:"hidden", height:"auto", display:"none", paddingTop:0}).slideDown(250, function() {

				jQuery(this).css({overflow:"visible", height:"auto"});

			});	

		},function() {	

			sub_menu.stop().slideUp(250, function() {	

				jQuery(this).css({overflow:"hidden", display:"none"});

			});

		});	

	});

	

	jQuery(".mega-menu").click(function () {

		jQuery(this).toggleClass("active-mega");

		jQuery(".mega-menu-warp").slideToggle(300);

		return false;

	});

	

	/* Header mobile */

	

	jQuery(window).bind("resize", function () {

		if (jQuery(this).width() > 980) {

			if (jQuery("#header").find(".navigation-2").length > 0) {

				jQuery(".navigation-2 .nav-2").removeClass("nav-2");

				jQuery("#header .nav-2").remove();

				jQuery(".navigation.navigation-1 > ul,.navigation-2").show();

				jQuery(".navigation_mobile > ul").hide();

				

				jQuery(".navigation_mobile_main").addClass("navigation");

				jQuery(".navigation-1").removeClass("navigation_mobile");

				jQuery(".navigation-1").find(".navigation_mobile_click").remove();

			}else {

				jQuery(".navigation_mobile_main").addClass("navigation");

				jQuery(".navigation").removeClass("navigation_mobile");

				jQuery(".navigation").find(".navigation_mobile_click").remove();

			}

		}else {

			if (jQuery("#header").find(".navigation-2").length > 0) {

				jQuery(".navigation-2").hide();

				jQuery(".navigation-2 > ul > li").addClass("nav-2");

				var navigation_2 = jQuery(".navigation-2 > ul").html();

				jQuery(".navigation-1 > ul").append(navigation_2);

				

				jQuery(".navigation-1").addClass("navigation_mobile");

				jQuery(".navigation-1").addClass("navigation_mobile_main");

				jQuery(".navigation_mobile").removeClass("navigation");

				jQuery(".navigation_mobile").each(function () {

					if (!jQuery(this).find(".navigation_mobile_click").length) {

						jQuery(this).prepend("<div class='navigation_mobile_click'>Go to...</div>");

					}

				});
				
				jQuery("#mobstickyfooter").show();
				jQuery("#nav_mob_display").show();

			}else {

				jQuery(".navigation").addClass("navigation_mobile");

				jQuery(".navigation").addClass("navigation_mobile_main");

				jQuery(".navigation_mobile").removeClass("navigation");

				jQuery(".navigation_mobile").each(function () {

					if (!jQuery(this).find(".navigation_mobile_click").length) {

						jQuery(this).prepend("<div class='navigation_mobile_click'>Go to...</div>");

					}

				});
				
				jQuery("#mobstickyfooter").show();		
				jQuery("#nav_mob_display").show();
			}
			
		}

	});

	

	if (jQuery(window).width() > 980) {

		if (jQuery("#header").find(".navigation-2").length > 0) {

			jQuery(".navigation-2 .nav-2").removeClass("nav-2");

			jQuery("#header .nav-2").remove();

			jQuery(".navigation.navigation-1 > ul,.navigation-2").show();

			jQuery(".navigation_mobile > ul").hide();

			

			jQuery(".navigation_mobile_main").addClass("navigation");

			jQuery(".navigation-1").removeClass("navigation_mobile");

			jQuery(".navigation-1").find(".navigation_mobile_click").remove();

		}else {

			jQuery(".navigation_mobile_main").addClass("navigation");

			jQuery(".navigation").removeClass("navigation_mobile");

			jQuery(".navigation").find(".navigation_mobile_click").remove();

		}

	}else {

		if (jQuery("#header").find(".navigation-2").length > 0) {

			jQuery(".navigation-2").hide();

			jQuery(".navigation-2 > ul > li").addClass("nav-2");

			var navigation_2 = jQuery(".navigation-2 > ul").html();

			jQuery(".navigation-1 > ul").append(navigation_2);

			

			jQuery(".navigation-1").addClass("navigation_mobile");

			jQuery(".navigation-1").addClass("navigation_mobile_main");

			jQuery(".navigation_mobile").removeClass("navigation");

			jQuery(".navigation_mobile").each(function () {

				if (!jQuery(this).find(".navigation_mobile_click").length) {

					jQuery(this).prepend("<div class='navigation_mobile_click'>Go to...</div>");

				}

			});
			
			jQuery("#mobstickyfooter").show();
			jQuery("#nav_mob_display").show();

		}else {

			jQuery(".navigation").addClass("navigation_mobile");

			jQuery(".navigation").addClass("navigation_mobile_main");

			jQuery(".navigation_mobile").removeClass("navigation");

			jQuery(".navigation_mobile").each(function () {

				if (!jQuery(this).find(".navigation_mobile_click").length) {

					jQuery(this).prepend("<div class='navigation_mobile_click'>Go to...</div>");

				}

			});
			
			jQuery("#mobstickyfooter").show();
			jQuery("#nav_mob_display").show();

		}

	}

	

	if (jQuery(".navigation_mobile_click").length) {

		jQuery(".navigation_mobile_click").click(function() {

			if (jQuery(this).hasClass("navigation_mobile_click_close")) {

				jQuery(this).next().slideUp(500);

				jQuery(this).removeClass("navigation_mobile_click_close");

			}else {

				jQuery(this).next().slideDown(500);

				jQuery(this).addClass("navigation_mobile_click_close");

			}

		});

	}

	

	/* slideshow */

	

	if (jQuery(".tp-banner").length) {

		jQuery('.tp-banner').revolution({

			delay:5000,

			startwidth:1170,

			startheight:600,

			hideThumbs:10,

			fullWidth:"on",

			forceFullWidth:"on"

		});

	}

	if (jQuery(".tp-banner-2").length) {

		jQuery('.tp-banner-2').revolution({

			delay:5000,

			startwidth:1140,

			startheight:444,

			hideThumbs:10,

		});

	}

	if (jQuery(".tp-banner-3").length) {

		jQuery('.tp-banner-3').revolution({

			delay:5000,

			startwidth:1140,

			startheight:771,

			hideThumbs:10,

		});

	}

	

	/* dishes-slider */

	

	jQuery(".dishes-slider ul").bxSlider({slideWidth: 1170,moveSlides: 1,maxSlides: 1,auto: true});

	

	/* single-event-slider */

	

	jQuery(".single-event-slider ul").bxSlider({slideWidth: 1170,moveSlides: 1,maxSlides: 1,auto: true});

	

	/* customers-slider */

	

	jQuery(".customers-slider ul").bxSlider({slideWidth: 1170,moveSlides: 1,maxSlides: 1,auto: true});

	

	/* about-slider,single-slider */

	

	jQuery(".about-slider ul,.single-slider ul").bxSlider({slideWidth: 1170,moveSlides: 1,maxSlides: 1,auto: true});

	

	/* clients */

	

	jQuery(".clients ul").bxSlider({slideWidth: 1170,moveSlides: 1,maxSlides: 1,auto: true});

	

	/* Go up */

	

	jQuery(".go-up").click(function(){

		jQuery("html,body").animate({scrollTop:0},500);

		return false;

	});

	

	/* Accordion & Toggle */

	

	jQuery(".accordion .accordion-title").each(function(){

		jQuery(this).click(function() {

			if (jQuery(this).parent().parent().hasClass("toggle-accordion")) {

				jQuery(this).parent().find("li:first .accordion-title").addClass("active");

				jQuery(this).parent().find("li:first .accordion-title").next(".accordion-inner").addClass("active");

				jQuery(this).toggleClass("active");

				jQuery(this).next(".accordion-inner").slideToggle().toggleClass("active");

			}else {

				if (jQuery(this).next().is(":hidden")) {

					jQuery(this).parent().parent().find(".accordion-title").removeClass("active").next().slideUp(200);

					jQuery(this).parent().parent().find(".accordion-title").next().removeClass("active").slideUp(200);

					jQuery(this).toggleClass("active").next().slideDown(200);

					jQuery(this).next(".accordion-inner").toggleClass("active");

				}

			}

			return false;

		});

	});

	

	/* Progressbar */

	

	if (jQuery(".progressbar-percent").length) {

		jQuery(".progressbar-percent").each(function(){

			var $this = jQuery(this);

			var percent = $this.attr("attr-percent");

			$this.bind("inview", function(event, isInView, visiblePartX, visiblePartY) {

				if (isInView) {

					$this.animate({ "width" : percent + "%"}, percent*20);

				}

			});

		});

	}

	

	/* Contact us */

	

	jQuery(".form-js").submit(function () {

		var thisform = jQuery(this);

		jQuery('.required-error',thisform).remove();

		var name	= jQuery("#name").val();

		var mail	= jQuery("#mail").val();

		var subject	= jQuery("#subject").val();

		var phone		= jQuery("#phone").val();

		var message	= jQuery("#message").val();

		var data = {'name':name,'mail':mail,'subject':subject,'phone':phone,'message':message};

		if (name == "") {

			jQuery("#name").after('<span class="form-description required-error">Please fill the required field.</span>');

		}else {

			jQuery("#name").parent().find('.required-error').remove();

		}

		if (mail == "") {

			jQuery("#mail").after('<span class="form-description required-error">Please fill the required field.</span>');

		}else {

			jQuery("#mail").parent().find('.required-error').remove();

		}

		if (subject == "") {

			jQuery("#subject").after('<span class="form-description required-error">Please fill the required field.</span>');

		}else {

			jQuery("#subject").parent().find('.required-error').remove();

		}

		if (message == "") {

			jQuery("#message").after('<span class="form-description required-error">Please fill the required field.</span>');

		}else {

			jQuery("#message").parent().find('.required-error').remove();

		}

		

		if (name != "" && mail != "" && subject != "" && message != "") {

			jQuery.post("contact_us.php",data,function (result) {

				if (result == "done") {

					thisform.prepend("<div class='alert-message success'><i class='icon-ok'></i><p><span>Thank you "+name+"!</span><br> We'll be in touch real soon .</p></div>");

					jQuery("#name").val("");

					jQuery("#mail").val("");

					jQuery("#subject").val("");

					jQuery("#phone").val("");

					jQuery("#message").val("");

				}

			});

		}

		return false;

	});

	

	/* Lightbox */

	

	var lightboxArgs = {			

		animation_speed: "fast",

		overlay_gallery: true,

		autoplay_slideshow: false,

		slideshow: 5000, // light_rounded / dark_rounded / light_square / dark_square / facebook

		theme: "pp_default", 

		opacity: 0.8,

		show_title: false,

		social_tools: "",

		deeplinking: false,

		allow_resize: true, // Resize the photos bigger than viewport. true/false

		counter_separator_label: "/", // The separator for the gallery counter 1 "of" 2

		default_width: 940,

		default_height: 529

	};

		

	jQuery("a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=gif], a[href$=bmp]:has(img)").prettyPhoto(lightboxArgs);

			

	jQuery("a[class^='prettyPhoto'], a[rel^='prettyPhoto']").prettyPhoto(lightboxArgs);

	

})(jQuery);