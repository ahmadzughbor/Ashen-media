var slider_tbl = $("#slider_tbl");
var slider_msf = null;


window.app.defineEvents();


/* Slider DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#slider_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
                },
                {
                data: "image",
                name: "image" ,
                class: "text-center align-top mt-4"
                },
                { data: "title",
                name: "title" ,
                class: "text-right align-top mt-4"
                },
                { data: "status",
                name: "status" ,
                class: "text-right align-top mt-4"
                },
                { data: "created_at",
                name: "created_at" ,
                class: "text-center align-top mt-4"},
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





