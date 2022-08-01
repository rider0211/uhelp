/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/jquery.showmore.js":
/*!************************************************!*\
  !*** ./resources/assets/js/jquery.showmore.js ***!
  \************************************************/
/***/ (() => {

(function ($, window, document, undefined) {
  'use strict';

  var pluginName = 'showmore',
      defaults = {
    closedHeight: 100,
    buttonTextMore: 'show more',
    buttonTextLess: 'show less',
    buttonCssClass: 'showmore-button',
    animationSpeed: 0.5,
    openHeightOffset: 0,
    onlyWithWindowMaxWidth: 0
  };

  function Plugin(element, options) {
    this.element = element;
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.btn;
    this.init();
  }

  $.extend(Plugin.prototype, {
    init: function init() {
      if (this.settings.onlyWithWindowMaxWidth > 0) {
        this.bindResize();
        this.responsive();
      } else {
        this.showmore();
      }
    },
    bindResize: function bindResize() {
      var self = this;
      var resizeTimer;
      $(window).on('resize', function () {
        if (resizeTimer) {
          clearTimeout(resizeTimer);
        }

        resizeTimer = setTimeout(function () {
          self.responsive();
        }, 250);
      });
    },
    responsive: function responsive() {
      if ($(window).innerWidth() <= this.settings.onlyWithWindowMaxWidth) {
        this.showmore();
      } else {
        this.remove();
      }
    },
    showmore: function showmore() {
      if (this.btn) {
        return;
      }

      var self = this;
      var element = $(this.element);
      var settings = this.settings;

      if (settings.animationSpeed > 10) {
        settings.animationSpeed = settings.animationSpeed / 1000;
      }

      var showMoreInner = $('<div />', {
        'class': settings.buttonCssClass + '-inner more',
        text: settings.buttonTextMore
      });
      var showLessInner = $('<div />', {
        'class': settings.buttonCssClass + '-inner less',
        text: settings.buttonTextLess
      });
      element.addClass('closed').css({
        'height': settings.closedHeight,
        'overflow': 'hidden'
      });
      var resizeTimer;
      $(window).on('resize', function () {
        if (!element.hasClass('closed')) {
          if (resizeTimer) {
            clearTimeout(resizeTimer);
          }

          resizeTimer = setTimeout(function () {
            // resizing has "stopped"
            self.setOpenHeight(true);
          }, 150); // this must be less than bindResize timeout!
        }
      });
      var showMoreButton = $('<div />', {
        'class': settings.buttonCssClass,
        html: showMoreInner
      });
      showMoreButton.on('click', function (event) {
        event.preventDefault();

        if (element.hasClass('closed')) {
          self.setOpenHeight();
          element.removeClass('closed');
          showMoreButton.html(showLessInner);
        } else {
          element.css({
            'height': settings.closedHeight,
            'transition': 'all ' + settings.animationSpeed + 's ease'
          }).addClass('closed');
          showMoreButton.html(showMoreInner);
        }
      });
      element.after(showMoreButton);
      this.btn = showMoreButton;
    },
    setOpenHeight: function setOpenHeight(noAnimation) {
      $(this.element).css({
        'height': this.getOpenHeight()
      });

      if (noAnimation) {
        $(this.element).css({
          'transition': 'none'
        });
      } else {
        $(this.element).css({
          'transition': 'all ' + this.settings.animationSpeed + 's ease'
        });
      }
    },
    getOpenHeight: function getOpenHeight() {
      $(this.element).css({
        'height': 'auto',
        'transition': 'none'
      });
      var targetHeight = $(this.element).innerHeight();
      $(this.element).css({
        'height': this.settings.closedHeight
      }); // we must call innerHeight() otherwhise there will be no css animation

      $(this.element).innerHeight();
      return targetHeight;
    },
    remove: function remove() {
      // var element = $(this.element);
      if ($(this.element).hasClass('closed')) {
        this.setOpenHeight();
      }

      if (this.btn) {
        this.btn.off('click').empty().remove();
        this.btn = undefined;
      }
    }
  });

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      if (!$.data(this, 'plugin_' + pluginName)) {
        $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
      }
    });
  };
})(jQuery, window, document);

/***/ }),

/***/ "./resources/assets/updatestyle/updatestyles.scss":
/*!********************************************************!*\
  !*** ./resources/assets/updatestyle/updatestyles.scss ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/style.scss":
/*!******************************************!*\
  !*** ./resources/assets/scss/style.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/custom-theme/dark.scss":
/*!*************************************************!*\
  !*** ./resources/assets/custom-theme/dark.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/custom-theme/skin-modes.scss":
/*!*******************************************************!*\
  !*** ./resources/assets/custom-theme/skin-modes.scss ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/custom-theme/sidemenu.scss":
/*!*****************************************************!*\
  !*** ./resources/assets/custom-theme/sidemenu.scss ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/jquery.showmore": 0,
/******/ 			"assets/css/sidemenu": 0,
/******/ 			"assets/css/skin-modes": 0,
/******/ 			"assets/css/dark": 0,
/******/ 			"assets/css/style": 0,
/******/ 			"assets/css/updatestyles": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/sidemenu","assets/css/skin-modes","assets/css/dark","assets/css/style","assets/css/updatestyles"], () => (__webpack_require__("./resources/assets/js/jquery.showmore.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/sidemenu","assets/css/skin-modes","assets/css/dark","assets/css/style","assets/css/updatestyles"], () => (__webpack_require__("./resources/assets/updatestyle/updatestyles.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/sidemenu","assets/css/skin-modes","assets/css/dark","assets/css/style","assets/css/updatestyles"], () => (__webpack_require__("./resources/assets/scss/style.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/sidemenu","assets/css/skin-modes","assets/css/dark","assets/css/style","assets/css/updatestyles"], () => (__webpack_require__("./resources/assets/custom-theme/dark.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/sidemenu","assets/css/skin-modes","assets/css/dark","assets/css/style","assets/css/updatestyles"], () => (__webpack_require__("./resources/assets/custom-theme/skin-modes.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/sidemenu","assets/css/skin-modes","assets/css/dark","assets/css/style","assets/css/updatestyles"], () => (__webpack_require__("./resources/assets/custom-theme/sidemenu.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;