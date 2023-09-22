var test_tbl = $("#test_tbl");
var test_msf = null;


window.app.defineEvents();


/* Test DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#test_tbl",
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





