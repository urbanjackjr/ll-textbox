(function ($) {
	"use strict";

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write $ code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(window).load(function () {
		if (my_ajax_object.API_key) {
			document.querySelector(".textbox-inner").innerHTML = document
				.querySelector(".textbox-inner")
				.innerHTML.replace(
					/([A-Za-zżąłęóśćńŻĄŁĘÓŚĆŃ]+)(\s|\.|\,)/g,
					"<span>$1</span>$2"
				);

			var current_word = "";
			var current_translation = "";

			function textbox() {
				var translations = [];
				var urlArray = [];
				var spanLength = $(".textbox-inner > span").length / 100;

				for (let k = 1; k < spanLength + 1; k++) {
					var url =
						"https://translation.googleapis.com/language/translate/v2?key=" +
						my_ajax_object.API_key;
					url += "&source=" + my_ajax_object.source;
					url += "&target=" + my_ajax_object.target;
					for (
						let l = (k - 1) * 100;
						l < 100 * k && l < $(".textbox-inner > span").length;
						l++
					) {
						url += "&q=" + $(".textbox-inner > span")[l].innerHTML;
					}
					urlArray.push(url);
					$.get(url, function (data, status) {
						translations[k - 1] = data.data.translations;
					});
				}

				$(".textbox-inner > span").on("mouseover", function () {
					current_word = $(this)
						.contents()
						.filter(function () {
							return this.nodeType == 3;
						})[0].nodeValue;
					current_translation =
						translations[Math.floor($(this).index() / 100)][
							$(this).index() -
								100 * Math.floor($(this).index() / 100)
						].translatedText;
					if (!$(this).find(".tooltip").length) {
						$(this).prepend(
							"<div class='tooltip'><span class='word'>" +
								current_word +
								" - " +
								current_translation +
								"</span><span class='save-word'>Save</span></div>"
						);
					}
				});

				$(".textbox-inner > span").on("mouseleave", function () {
					$(this).find(".tooltip").remove();
				});
			}

			textbox();

			$(document).on("click", ".tooltip .save-word", function () {
				$(".tooltip .save-word").html(
					'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; --darkreader-inline-bgcolor: #1f2223; --darkreader-inline-bgimage: none; shape-rendering: auto;" width="16px" height="16px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" data-darkreader-inline-bgcolor="" data-darkreader-inline-bgimage=""><circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" style="--darkreader-inline-stroke: #e8e6e3;" data-darkreader-inline-stroke=""><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"/></circle>'
				);
				$.post(my_ajax_object.ajax_url, {
					action: "save_word",
					ll_value: current_word,
					ll_translation: current_translation,
					is_learned: 0,
				})
					.done(function (data) {
						$(".save-word").text(data.response);
					})
					.fail(function () {
						$(".save-word").text("Reload and try again");
					});
			});
		}
	});
})(jQuery);
