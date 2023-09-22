var courseunitlesson_tbl = $("#courseunitlesson_tbl");
var courseunitlesson_msf = null;


window.app.defineEvents();


/* CourseUnitLesson DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#courseunitlesson_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
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





