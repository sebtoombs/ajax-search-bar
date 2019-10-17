(function( $ ) {
	'use strict';

	$('.kdasb-form').each(function() {
		var $form = $(this);
		var xhr;
		var haveResults = false;

		var $resultsContainer = $form.find('.kdasb-search-form-results-ajax');
		var $resultsSpinner = $('<div class="kdasb-result-item kdasb-result-item--spinner"><i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i></div>');
		var $input = $form.find('input[name=s]');

		//Events
		$form.on('submit', formSubmitHandler);
		$input.on('keyup', inputChangeHandler);
		$input.on('search', inputClickHandler);
		$input.on('focus', inputFocusHandler);

		$form.on('click', function(e) {
			e.stopPropagation();
		});
		$('body').on('click', function(e) {
			hideResultsContainer();
		});

		function doSearchAjax(query) {
			if(xhr) xhr.abort();
			xhr = $.ajax({
				type : 'post',
				url : kd_ajax_search.ajaxurl,
				data : {
					action : 'load_search_results',
					query : query
				}
			});
			return xhr;
		}

		function showResults(res) {
			//console.log(res);
			$resultsContainer.html('');
			var posts = res.posts;
			posts.map(function(result) {
				var $newResult = $('<a class="kdasb-result-item"></a>');

				//result.post_title = 'TYPE: '+result.post_type+", "+result.post_title;

				var resultTitle = result.post_title;

				if(result.post_type == 'product_variation') {
					resultTitle = result.variation_name;
				}

				/*if(result.post_type == 'product' || result.post_type == 'product_variation') {
					//resultTitle = '<strong>Product: </strong>' + resultTitle;
					resultTitle =
				}*/

				$newResult.html(resultTitle);

				$newResult.attr('href', result.permalink);

				//if(result.thumbnail) {
				var $resultThumb = $('<span class="kdasb-result-thumbnail">');
				$resultThumb.css({
					backgroundColor: '#f90f9f9',
					backgroundSize: 'cover',
					display: 'block',
					width: '50px',
					height: '50px',
					overflow: 'hidden',
					margin: '-0.75rem 1rem -0.75rem -1.25rem'
				});
				if(result.thumbnail) {
					$resultThumb.css({backgroundImage: 'url('+result.thumbnail+')'});
				}
				$resultThumb.prependTo($newResult);
				//}

				$newResult.appendTo($resultsContainer);
			});
			if(res.has_more) {
				var $viewAll = $('<div class="kdasb-result-item kdasb-result-item--view-all"><a href="'+res.view_all+'"><strong>View all</strong></a></div>');
				$viewAll.appendTo($resultsContainer);
			}
			if(!posts.length) {
				var $newResult = $('<div class="kdasb-result-item kdasb-result-item--no-results"></div>');
				$newResult.html('<strong>No results</strong>');
				$newResult.appendTo($resultsContainer);
			}
		}

		function doSearch() {
			showResultsSpinner();
			showResultsContainer();

			doSearchAjax($input.val()).then(function(res) {
				hideResultsSpinner();
				showResults(res);
				if(res.length) { haveResults = true; }
			});
		}

		function afterInputHandler() {
			if(!$input.val() || $input.val().length < 3) {
				if(xhr) xhr.abort();
				hideResultsContainer(true);
				return;
			}

			doSearch();
		}

		function formSubmitHandler(e) {
			e.preventDefault();

			afterInputHandler();
		}

		function inputChangeHandler(e) {
			e.preventDefault();

			afterInputHandler();
		}

		function inputClickHandler(e) {
			afterInputHandler();
		}

		function inputFocusHandler(e) {
			if($input.val() && $input.val().length >= 3 && haveResults) {
				showResultsContainer();
			}
		}


		function showResultsContainer() {
			$resultsContainer.find('.kdasb-result-item--no-results').remove();
			$resultsContainer.fadeIn();
		}

		function hideResultsContainer(clearHtml) {
			$resultsContainer.fadeOut({onComplete: function() {
					hideResultsSpinner();
					if(clearHtml===true) {
						$resultsContainer.html('');
					}
				}});
		}

		function showResultsSpinner() {
			if(!$resultsSpinner.hasClass('show')) {
				$resultsSpinner.prependTo($resultsContainer);
				$resultsSpinner.addClass('show');
			}
		}

		function hideResultsSpinner() {
			$resultsSpinner.removeClass('show');
			$resultsSpinner.detach();
		}
	});



})( jQuery );
