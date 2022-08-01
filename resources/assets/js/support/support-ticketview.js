(function($) {
    "use strict";

	//______summernote
	$('.summernote').summernote({
		placeholder: '',
		tabsize: 1,
		height: 200,
	});

	//______summernote
	$('.editsummernote').summernote({
		
		tabsize: 1,
		height: 200,
	});

	
	// ______________ Attach Remove
	$(document).on('click', '[data-toggle="remove"]', function(e) {
		let $a = $(this).closest(".attach-supportfiles");
		$a.remove();
		e.preventDefault();
		return false;
	});


})(jQuery);
 