var program_tbl = $("#program_tbl");
var program_msf = null;



window.app.defineEvents();


/* Program DataTable Define */
window.app.definePageDatatable({
    tableElementId: $("#program_tbl"),
    options: {
        serverSide: true,
        searching: true,
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "title",
                name: "title",
                class: "text-right align-top mt-4"
            },
            {
                data: "title_en",
                name: "title_en",
                class: "text-center align-top mt-4"
            },
            {
                data: "type_name",
                name: "type_name",
                class: "text-center align-top mt-4"
            },
            {
                data: "created_at",
                name: "created_at",
                
                class: "text-center align-top mt-4"
            },
            {
                data: "action",
                name: "action",
                class: "text-center align-top mt-4"
            },
        ],
        ajax: {
            data: function(filter) {
                (filter.function = 'dataTable');
                (filter.actionName = 'SELECT');
            }
        }
    }
});





