var coursetrainer_tbl = $("#coursetrainer_tbl");
var coursetrainer_msf = null;


window.app.defineEvents();


/* CourseTrainer DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#coursetrainer_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
               
                data: "user_name",
                name: "user_name",
                class: "text-right align-top mt-4"
            },
            {
               
                data: "course_name",
                name: "course_name",
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
                
            }
        }
    }
});





