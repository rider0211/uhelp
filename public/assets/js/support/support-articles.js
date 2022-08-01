/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************************!*\
  !*** ./resources/assets/js/support/support-articles.js ***!
  \*********************************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

(function ($) {
  "use strict"; //________ Data Table

  var _$$DataTable;

  $('#support-articlelist').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [0, 3, 4]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); //________ Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  }); //______summernote

  $('.summernote').summernote({
    placeholder: '',
    tabsize: 1,
    height: 120
  });
})(jQuery);
/******/ })()
;