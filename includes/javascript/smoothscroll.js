$(document).ready(function(){

	var anchors = $('a[href^="#"]');
	var head = $('.main-header').height();

	anchors.on('click', function(event){

		if (this.hash !== ''){
			event.preventDefault();

			var hash = this.hash;

			$('html, body').animate({
				scrollTop: $(hash).offset().top - head
			}, 1200, function(){
				window.location.hash = hash;
			});
		}
	})
})