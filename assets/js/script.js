function exportToExcel(tableClass) {
    var lastSegment = window.location.pathname.split("/").pop();
    var dformat = '';
    Number.prototype.padLeft = function (base, chr) {
        var len = (String(base || 10).length - String(this).length) + 1;
        return len > 0 ? new Array(len).join(chr || '0') + this : this;
    }
    var d = new Date,
            dformat = [(d.getMonth() + 1).padLeft(),
                d.getDate().padLeft(),
                d.getFullYear()].join('') +
            '' +
            [d.getHours().padLeft(),
                d.getMinutes().padLeft(),
                d.getSeconds().padLeft()].join('');

    $(function () {
        $(".btn-excel").click(function (e) {
            var table = $('.' + tableClass);
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: lastSegment,
//                    filename: lastSegment + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    filename: lastSegment + dformat + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });
}

function GetMonthName(monthNumber) {
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return months[monthNumber];
}

function getSelect2() {
    $('.select2').select2();
}

function dateDurationInsideFormValidation(formClassName) {
    var form = ("." + formClassName);
    $(form).validate({
        rules: {
            start_date: "required",
            end_date: "required",
        },
        messages: {
            start_date: "Please Select start date",
            end_date: "Please Select end date",
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },
        invalidHandler: function (form, validator) {

        }
    });
    var isValid = $(form).valid();
    return isValid;
}