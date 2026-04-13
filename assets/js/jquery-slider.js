/*  
	Project: jQuery slider - 2016
	Description: Basic but powerfull jQuery slider
	Author: Mario Iliev
	GitHub: https://github.com/mario-iliev
	---------------------------
	Full specification: https://github.com/mario-iliev/jquery-slider
*/
;(function ($) {
	'use strict';
	var isMob = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0) ? true : false;
	var id = 0;
	var toDestroy = 0;
	var screen = $(document);
	var mouseup = isMob && $.mobile ? 'vmouseup.slider' : 'mouseup.slider';
	var mousedown = isMob && $.mobile ? 'vmousedown.slider' : 'mousedown.slider';
	var mousemove = isMob && $.mobile ? 'vmousemove.slider' : 'mousemove.slider';

	// Remove generated html and clear events
	var destroyPlugin = function(id) {
		$('.container._'+id).off(mouseup+id).off(mousedown+id).remove();
	};

	// Main plugin logic
	var slider = function (el, opts) {
		var el = $(el);
		var lastValue = 0;
		var lastPosistion = 0;
		var maxValue = opts.maxvalue ? opts.maxvalue : 100;
		var boxWidth = typeof opts.width == 'number' ? opts.width : el.outerWidth();
		var countTrough = opts.interval && maxValue % opts.interval == 0 ? opts.interval : false;
		var progress = opts.progress ? '<div class="progress" style="position: absolute; top: 0; left: 0;"></div>' : '';

		// If 'destroy' parameter is called
		if (opts.destroy) {
			destroyPlugin(id);
			return false;
		}

		// Append HTML and CSS needed for the plugin
		el.each(function() {
			id = ++id;
			$(this)
				.addClass('container _'+id)
				.css({'width' : boxWidth, 'min-height' : '1px', 'position' : 'relative', 'cursor' : 'pointer'})
				.html('<div class="dragger" style="position: absolute; min-width: 10px; min-height: 10px; outline: none; cursor: pointer; text-align: center; z-index: 1;"></div>'+progress);
		});

		var box = $('.container._'+id);
		var drag = $('.container._'+id+' .dragger');
		var progressBar = opts.progress ? $('.container._'+id+' .progress') : '';
		var boxHeight = box.outerHeight();
		var output = opts.output ? $(opts.output) : drag;
		var firstVal = opts.firstvalue ? opts.firstvalue : 0;

		// Show the initial value
		output.text(firstVal);

		var dragWidth = drag.outerWidth();
		var dragHeight = drag.outerHeight();
		var dragCentered = Math.ceil((dragHeight - boxHeight) / 2);

		// Center vertically the dragger
		drag.css({'top': -dragCentered + 'px'});
		// Adjust the progress div height 
		if (progress) 
			progressBar.css({'height' : boxHeight + 'px'});

		var moveSlider = function(evt, dragOffset, boxOffset) {
			var posX = evt.pageX - (boxOffset + dragOffset);
			var value = Math.round( (posX / (boxWidth - dragWidth)) * maxValue);

			// Stop calculations if the mouse is outside of the box horizontally
			if (value > (maxValue + 20) || value < -20) return;

			var txtValue = Math.min(Math.max(parseInt(value), 0), maxValue);
			var cssVal = Math.min(Math.max(parseInt(posX), 0), (boxWidth - dragWidth));
			var diff = Math.abs(lastPosistion - txtValue);

			// Update the Value only when needed
			if (diff > 0) {
				lastPosistion = txtValue;

				if (countTrough) {
					if (txtValue % countTrough == 0) {
						lastValue = txtValue;
					} else {
						txtValue = lastValue;
						return false;
					}
				}

				output.text(txtValue);

				if (!txtValue) output.text(firstVal);
			}

			// Move the dragger
			drag.css({'left': cssVal + 'px'});

			if (progress) {
				progressBar.css({'width': (cssVal + (dragWidth / 2) ) + 'px'});
			}
		}

		// When mouse button is down on the slider
		box.on(mousedown+id, function(e) {
			var boxOffset = box.offset().left;

			if (isMob) {
				var dragOffset = dragWidth / 2;
			} else {
				var dragOffset = drag.is(e.target) ? e.offsetX + 1 : dragWidth / 2;
			}

			drag.addClass('dragging');

			moveSlider(e, dragOffset, boxOffset);

			screen.delegate(box, mousemove+id, function(e) {

				moveSlider(e, dragOffset, boxOffset);

				// Desktop: Stop page scrolling while using the slider
				screen.on('mousewheel.slider'+id, function(e) {
					e.preventDefault();
				});

				// Mobile: Stop page scrolling while using the slider
				return false; 
			})
			.on(mouseup+id, function() {
				if (drag.hasClass('dragging')) {
					screen.off(mousemove+id);
					drag.removeClass('dragging');
				}

				screen.unbind('mousewheel.slider'+id);
			});
		})
		.on(mouseup+id, function() {
			screen.off(mousemove+id);
			drag.removeClass('dragging');
		});
	};

	$.fn.createSlide = function (options, callback) {
		var opts = $.extend({}, $.fn.createSlide.defaults, options, callback);

		return this.each(function () {
			new slider($(this), opts);
		});
	}
	// Define plugin options
	$.fn.createSlide.defaults = { width: false, output: false, firstvalue: false, maxvalue: false, interval: false, progress: false, destroy: false };

	// Search for data attribute and auto run the plugin
	$(function(){
		$('div[data-slider-box]').createSlide();
	});
})(jQuery);
