/**
 * Created by shrestha on 2/3/16.
 */
!function ($) {
    $.fn.client = function (method) {

        var settings;

        // Public methods
        var methods = {
            init: function (options) {
                settings = $.extend(true, {}, $.fn.client.defaults, options);

                return this.each(function () {
                    var $this = $(this);
                    helpers.initInputMask($this);
                    helpers.initFormValidation($this);
                });
            }
        };

        var helpers = {
            initInputMask: function ($this) {
                $("[data-mask]", $this).inputmask();
            },
            initFormValidation: function ($this) {
                $('#clientForm', $this).validate({
                    errorPlacement: function (error, element) {
                        $(element).parent('div').addClass('has-error');
                        $(element).parent('div').children('label').html('<i class="fa fa-times-circle-o"></i>' + error.text());
                    }
                });
            }
        };

        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments);
        }
        else {
            $.error("Method " + method + " does not exist in $.client.");
        }
    };

    $.fn.client.defaults = {};
}(window.jQuery);

// Make sure that a parent element has the class ''.client'' set so that this plugin can be triggered properly when the page is loaded.
$(document).ready(function () {
    $(".client").client();
});

