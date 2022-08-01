(function($, window, document, undefined) {

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
        init: function() {
            if (this.settings.onlyWithWindowMaxWidth > 0) {
                this.bindResize();
                this.responsive();                
            } else {
                this.showmore();
            }
        },
        bindResize: function() {
            var self = this;
            var resizeTimer;
            $(window).on('resize', function() {
                if (resizeTimer) {
                    clearTimeout(resizeTimer);
                }
                resizeTimer = setTimeout(function() {
                    self.responsive();
                }, 250);
            });
        },
        responsive: function() {
            if ($(window).innerWidth() <= this.settings.onlyWithWindowMaxWidth) {
                this.showmore();
            } else {
                this.remove();
            }
        },
        showmore: function() {

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
            $(window).on('resize', function() {
                if (!element.hasClass('closed')) {
                    if (resizeTimer) {
                        clearTimeout(resizeTimer);
                    }
                    resizeTimer = setTimeout(function() {
                        // resizing has "stopped"
                        self.setOpenHeight(true);
                    }, 150); // this must be less than bindResize timeout!
                }
            });

            var showMoreButton = $('<div />', {
                'class': settings.buttonCssClass,
                html: showMoreInner
            });

            showMoreButton.on('click', function(event) {
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

        setOpenHeight: function(noAnimation) {
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

        getOpenHeight: function() {
            $(this.element).css({'height': 'auto', 'transition': 'none'});
            var targetHeight = $(this.element).innerHeight();
            $(this.element).css({'height': this.settings.closedHeight});
            // we must call innerHeight() otherwhise there will be no css animation
            $(this.element).innerHeight();
            return targetHeight;
        },

        remove: function() {
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

    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);
