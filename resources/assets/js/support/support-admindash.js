(function($) {
    "use strict";

	//________ Data Table
	$('#supportticket-dash').DataTable({
		"order": [[ 0, "desc" ]],
		order: [],
		columnDefs: [
			
			{ orderable: false, targets: [0] }
		],
		language: {
			searchPlaceholder: 'Search...',
			sSearch: '',

		}
	});

	//________ Select2
	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width:'100%'
	});

})(jQuery);

