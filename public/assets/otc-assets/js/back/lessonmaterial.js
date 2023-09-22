var lessonmaterial_tbl = $("#lessonmaterial_tbl");
var lessonmaterial_msf = null;


window.app.defineEvents();


/* LessonMaterial DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#lessonmaterial_tbl",
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





