var courseunit_tbl = $("#courseunit_tbl");
var courseunit_msf = null;


window.app.defineEvents();


/* CourseUnit DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#courseunit_tbl",
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





