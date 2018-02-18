$(document).ready(function(){

	/**
	 * toggle parent/child
	 * @author Matt
	 * @since 2017-12-12
	 */
	toggle();
	function toggle(){
		if ($('.toggle-parent').length){

			var parent = $('.toggle-parent');
			var child = $('.toggle-child');

			parent.click(function(){
				child.slideToggle('slow');
			})
		}
	}


	/**
	 * full-width sections
	 * @author Matt
	 * @since 2017-12-12
	 */
	full_width();
	function full_width(){
		if ($('.wj-full').length){

			var container = $('.wj-full');
			var screenWidth = $(window).width();
			var containerWidth = container.width();
			var leftPos = container.offset().left;
			var difference = (screenWidth - containerWidth) / 2;
			var margin = -difference;
			var padding = difference;

			console.log(leftPos + ',' + margin);

			container.css({
				'width': screenWidth,
				'margin-left': margin,
				'margin-right': margin,
				'padding-left': padding,
				'padding-right': padding
			})
		}
	}


	/**
	 * modal_set
	 * @author Matt
	 * @since 2017-12-12
	 */
	modal_set();
	function modal_set(){
		if ($('.modal-action').length){

			var action = $('.modal-action');

			action.each(function(){

				var $this = $(this);
				var dataTarget = $this.data('modalTarget');
				var target = $('#' + dataTarget);
				var html = target.html();

				target.html('<div class="modal-inner"><div class="modal-content"><span class="modal-close"></span>' + html + '</div></div>');
			})
		}
	}


	/**
	 * modal_open
	 * @author Matt
	 * @since 2017-12-12
	 */
	modal_open();
	function modal_open(){

		var action = $('.modal-action');

		action.each(function(){

			var $this = $(this);
			var dataTarget = $this.data('modalTarget');
			var target = $('#' + dataTarget);

			$this.click(function(event){

				event.preventDefault();

				target.fadeIn('fast');
			})
		})
	} 

	/**
	 * modal_close
	 * @author Matt
	 * @since 2017-12-12
	 */
	modal_close();
	function modal_close(){

		var target = $('.modal-target');

		target.click(function(event){
			var $this = $(this);
			var etarget = $(event.target);
			var content = $this.find('.modal-content, .modal-content *:not(.modal-close)');

			if (!etarget.is(content)){
				$this.fadeOut('fast');
			}
		})
	}
})


