var constant_tbl = $("#constant_tbl");
var constant_msf = null;


window.app.defineEvents();


/* Constant DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#constant_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "value",
                name: "value",
                class: "text-right align-top mt-4"
            },
            {
                data: "constant_type_name",
                name: "constant_type_name",
                class: "text-center align-top mt-4"
            },
            {
                data: "action",
                name: "action",
                class: "text-center align-top mt-4"
            },
        ],
        ajax: {
            data: function (filter) {
                (filter.constant_type = $("#constant_type").val())

            }
        }
    }
});



$("#constant_type").selectpicker('refresh');


$(document).on("change", "#constant_type", function (e) {
    e.preventDefault();
    constant_tbl.DataTable().ajax.reload();
});


