(function($) {
    "use strict";

	//________ Data Table
	$('#support-articlelist').DataTable({
		"order": [
			[ 0, "desc"]
		],
		order: [],
		columnDefs: [ 
			{ orderable: false, targets: [0, 3, 4] } ,
		],
		language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
			
		}
	});

	//________ Select2
	$('.select2').select2({
		minimumResultsForSearch: Infinity
	});

	//______summernote
	$('.summernote').summernote({
		placeholder: '',
		tabsize: 1,
		height: 120,
		
		
	});
	
})(jQuery);

 