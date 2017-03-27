jQuery(document).ready(function($){
	//$('#wysiwyg').wysiwyg();

	$('#content').on('input', '.number-only', function(){
		var out = "";
		var str = this.value;
		for (var i = 0; i < str.length; i++) {
			if (/[0-9 .\/]/.test(str.charAt(i))) {
				out = out.concat(str.charAt(i));    
			}
		}
		this.value = out;
	});

	$('.close').click(function(){
		$(this).parent().addClass('hidden');
		return false;
	});

	$('#ad-upload').on('click', '.remove-photo', function(){
		console.log('remove photo');
		$(this).closest('li').remove();
	});

	// $('.bxslider').bxSlider({
	// 	pagerCustom: '#ad-thumb'
	// });
		$('.carousel').carousel()

	$('.products #condition, .products #size_from, .products #size_to, .products #price_from, .products #price_to').on('change', function(){
		
		var data = get_search_data();

		var id = $(this).attr('id');
		if(id == 'condition' || id == 'size_to' || id == 'price_to'){
			window.location.href = get_base_url()+'products/q/?'+$.param(data);
		}
	});

	$('#search-product').click(function(){
		
		var data = get_search_data();

		window.location.href = get_base_url()+'products/q/?'+$.param(data);
	});

	$('#product-search').submit(function(){ 
		var data = get_search_data();

		window.location.href = get_base_url()+'products/q/?'+$.param(data);
		return false;
	});

	function get_search_data(){
		var data = {};
		if($('#condition').val()){
			data['condition'] = $('#condition').val();
		}

		if($('#size_from').val()){
			data['size_from'] = $('#size_from').val();
		}

		if($('#size_to').val()){
			data['size_to'] = $('#size_to').val();
		}

		if($('#price_from').val()){
			data['price_from'] = $('#price_from').val();
		}

		if($('#price_to').val()){
			data['price_to'] = $('#price_to').val();
		}

		if($('#search-text').val()){
			data['search'] = $('#search-text').val();
		}

		return data;
	}


	if($('#member-sorting').length > 0){
		$('#member-sorting').change(function(){
			$('#form-sorting').submit();
		});
	}

	if($('#feedback-type').length > 0){
		$('#feedback-type').change(function(){
			$('#feedback-filter-form').submit();
		});
	}

	if($('#edit-feedback').length >0){
		$('#edit-feedback').click(function(){
			$('#form-feedback').removeClass('hide');
		});
	}

	var callback;
	if($('#mark-sold').length >0){
		$('#mark-sold').click(function(){
			var id = $(this).attr('data-id');

			callback = function(){
				$.post( get_base_url()+"products/sold", {id:id}, function( data ) {
					window.location.href = get_base_url();
				});
				//alert('test'); 
				return false;
			};
			confirmM("Mark as Sold Confirmation", "Are you sure you want to mark this ad as sold?", "confirm-sold");

			return false;
		});
	}	
	
	$('body').on('click', '#confirm-sold #okButton', function(event) {
		      callback();
		      $(html).modal('hide');
		      return false;
		    });
		
	
	if($( "#city-select" ).length > 0){
		$.post( get_base_url()+"ajax/get_cities", {pid:0}, function( data ) {
			//console.log(data);
			tags = $.parseJSON(data);
			$( "#city-select" ).autocomplete({
		      source: tags
		    });
		});
	}

	jQuery(function($) {
	  function fixDiv() {
	    var $cache = $('#search-bar');
	    if ($(window).scrollTop() > 122)
	      $cache.addClass("fix-search");
	    else
	      $cache.removeClass("fix-search");
	  }
	  $(window).scroll(fixDiv);
	  fixDiv();
	});
	
	jQuery(function($) {
	  function fixSeller() {
	    var $cache = $('#seller-info');
	    if ($(window).scrollTop() > 180)
	      $cache.addClass("fix-seller");
	    else
	      $cache.removeClass("fix-seller");
	  }
	  $(window).scroll(fixSeller);
	  fixSeller();
	});
});