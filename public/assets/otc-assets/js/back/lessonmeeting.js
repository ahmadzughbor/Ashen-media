var lessonmeeting_tbl = $("#lessonmeeting_tbl");
var lessonmeeting_msf = null;


window.app.defineEvents();


/* LessonMeeting DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#lessonmeeting_tbl",
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





