var graduate_tbl = $("#graduate_tbl");
var graduate_msf = null;


window.app.defineEvents();


/* Graduate DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#graduate_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "user_id",
                name: "user_id",
                class: "text-right align-top mt-4"
            },
            {
                data: "id_no",
                name: "id_no",
                class: "text-center align-top mt-4"
            },
            {
                data: "course_id",
                name: "course_id",
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





