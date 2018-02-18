$(document).ready(function(){

	// c is current number
	// l is last number
	var slide = $('.scroll-slider li');

	var c = 0;
	var l = slide.length - 1;

	function initialize(){

		slide.eq(c).addClass('active');
	}

	function forward(){

		var n = c + 1;
		var p = c - 1;

		slide.eq(c).removeClass('active');
		slide.eq(p).removeClass('left');

		if (c !== l) {

			slide.eq(n).addClass('active');
			slide.eq(c).addClass('left');
			
			c++;
		} else {

			slide.eq(0).addClass('active');
			slide.eq(c).addClass('left');
			c = 0;
		}
	}


	scroll_slider();
	function scroll_slider(){

		// start slider
		setTimeout(initialize, 500);

		// set interval
		setInterval(forward, 8000);
	}

	function tallest_slide(){

		slide.each(function(){

			var tallest = 0;

			if ($(this).height() > tallest) {

				tallest = $(this).height();
			}

			return tallest;
		})
	}
})



$(window).on('load', function(){
	var slideList = $('.scroll-slider ul');
	var slide = $('.scroll-slider .scroll-field');

	var tallest = 0;
	slide.each(function(){

		if ($(this).outerHeight() > tallest) {

			tallest = $(this).outerHeight();
		}

		slideList.height(tallest);
	})
})


