var contactu_tbl = $("#contactu_tbl");
var contactu_msf = null;


window.app.defineEvents();


/* ContactU DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#contactu_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            { data: "title" , name:"title",  class: "text-center align-top mt-4" },
            // { data: "fullName", name: "fullName" },
            { data: "email" , name:"email",  class: "text-center align-top mt-4" },
            { data: "created_at", name: "created_at",  class: "text-center align-top mt-4" },
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





