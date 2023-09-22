var coursecenter_tbl = $("#coursecenter_tbl");
var coursecenter_msf = null;


window.app.defineEvents();


/* CourseCenter DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#coursecenter_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "center_name",
                name: "center_name",
                class: "text-center align-top mt-4"
            },
            {
                data: "owner_name",
                name: "owner_name",
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





