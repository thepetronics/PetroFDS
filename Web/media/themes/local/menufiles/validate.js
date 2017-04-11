/* <![CDATA[ */
/// Jquery validate newsletter
jQuery(document).ready(function(){

	$('#newsletter_2').submit(function(){

		var action = $(this).attr('action');

		$("#message-newsletter_2").slideUp(750,function() {
		$('#message-newsletter_2').hide();
		
		$('#submit-newsletter_2')
			.after('<i class="icon-spin4 animate-spin loader"></i>')
			.attr('disabled','disabled');

		$.post(action, {
			email_newsletter_2: $('#email_newsletter_2').val()
		},
			function(data){
				document.getElementById('message-newsletter_2').innerHTML = data;
				$('#message-newsletter_2').slideDown('slow');
				$('#newsletter_2 .loader').fadeOut('slow',function(){$(this).remove()});
				$('#submit-newsletter_2').removeAttr('disabled');
				if(data.match('success') != null) $('#newsletter_2').slideUp('slow');

			}
		);

		});

		return false;

	});

});
		
/// Jquery validate review tour
jQuery(document).ready(function(){

	$('#review').submit(function(){

		var action = $(this).attr('action');

		$("#message-review").slideUp(750,function() {
		$('#message-review').hide();
		
		$('#submit-review')
			.after('<i class="icon-spin4 animate-spin loader"></i>')
			.attr('disabled','disabled');

		$.post(action, {
			name_review: $('#name_review').val(),
			email_review: $('#email_review').val(),
			food_review: $('#food_review').val(),
			price_review: $('#price_review').val(),
			punctuality_review: $('#punctuality_review').val(),
			courtesy_review: $('#courtesy_review').val(),
			review_text: $('#review_text').val(),
			verify_review: $('#verify_review').val()
		},
		
			function(data){
				document.getElementById('message-review').innerHTML = data;
				$('#message-review').slideDown('slow');
				$('#review .loader').fadeOut('slow',function(){$(this).remove()});
				$('#submit-review').removeAttr('disabled');
				if(data.match('success') != null) $('#review').slideUp('slow');

			}
		);

		});

		return false;

	});

});

  /* ]]> */