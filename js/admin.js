(function ($) {
	"use strict";
	$(function () {
		var image_source = $('.twitter-image > option:selected').val();
		update_image()
		function update_image() {
			image_source = $('.twitter-image > option:selected').val();
			$('.twitter-image-box').attr('src', image_source);
		}
		$('.twitter-image').change(function() {
			update_image()
		});
		$('.' + $('input[name=type]:checked').val() + '-settings').show();
		$('input[name=type]').change(function() {
			var selected = $('input[name=type]:checked').val();
			$('.set').hide();
			$('.' + selected + '-settings').show();
		});
	});
}(jQuery));