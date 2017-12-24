/**
 * Created by shrestha on 2/3/16.
 */
!function ($) {
    $.fn.clients = function (method) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function (options) {
                settings = $.extend(true, {}, $.fn.clients.defaults, options);

                return this.each(function () {
                    var $this = $(this);

                    table = $("table.table", $this).dataTable($.extend(true, {}, settings.datatables, {

                    }));
                });
            }
        };

        var helpers = {};

        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments);
        }
        else {
            $.error("Method " + method + " does not exist in $.clients.");
        }
    };

    $.fn.clients.defaults = {
        datatables: {
            autoWidth: false,
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "gender"},
                {data: "phone"},
                {data: "email"},
                {data: "education"},
                {data: "address"},
                {data: "nationality"},
                {data: "dob"},
                {data: "preffered"},
                {data: "actions"}
            ],
            columnDefs: [
                {visible: false, targets: [0]},
                {className: "number", targets: [6, 7, 8]},
                {className: "actions", targets: [9]}
            ],
            destroy: true,
            orderable: false,
            orderCellsTop: true,
            paging: true,
            processing: true,
            searching: true,
            serverSide: true,
            stateSave: false,
            stripeClasses: []
        }
    };
}(window.jQuery);

// Make sure that a parent element has the class ''.clients'' set so that this plugin can be triggered properly when the page is loaded.
$(document).ready(function () {
    $(".clients").clients(pila.clients);
});

