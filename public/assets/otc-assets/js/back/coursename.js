var coursename_tbl = $("#coursename_tbl");
var coursename_msf = null;


window.app.defineEvents();


/* CourseName DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#coursename_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "name",
                name: "name",
                class: "text-center align-top mt-4"
            },
            {
                data: "name_en",
                name: "name_en",
                class: "text-center align-top mt-4"
            },
            {
                data: "program_name",
                name: "program_name",
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





