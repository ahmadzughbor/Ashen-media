var coursesmodel_tbl = $("#coursesmodel_tbl");
var coursesmodel_msf = null;


window.app.defineEvents();


/* CoursesModel DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#coursesmodel_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "name",
                name: "name",
                class: "text-right align-top mt-4"
            },
            {
                data: "name_en",
                name: "name_en",
                class: "text-right align-top mt-4"
            },
            {
                data: "action",
                name: "action",
                class: "text-center align-top mt-4"
            },
        ],
        ajax: {
            data: function(filter) {
                
            }
        }
    }
});





