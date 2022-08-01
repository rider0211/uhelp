(function($) {
    "use strict";

	// __________ Select2
	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width: '100%'
	});
	
	
	//__________ Select2 by showing the search
	$('.select2-show-search').select2({
        minimumResultsForSearch: '',
        placeholder: "Search",
        width: '100%'
    });

	//__________ Modal Select2 by showing the search
	$('.select1-show-search').select2({
		dropdownParent: ".sprukosearch",
		minimumResultsForSearch: '',
		placeholder: "Search",
		width: '100%'
	  });

	$('.select2').on('click', () => {
		let selectField = document.querySelectorAll('.select2-search__field')
		selectField.forEach((element,index)=>{
			element?.focus();
		})
	});

	
	
})(jQuery);