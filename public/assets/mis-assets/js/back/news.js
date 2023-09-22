var news_tbl = $("#news_tbl");
var news_msf = null;


window.app.defineEvents();


/* News DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#news_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {   
                data: "title",
                name: "title",
                class: "text-right align-top mt-4"
            },
            {
                data: "news_type",
                name: "news_type",
                class: "text-center align-top mt-4"
            },
            {
                data: "updated_at",
                name: "updated_at",
                class: "text-center align-top mt-4"
            },
            {
                data: "status",
                name: "status",
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



    