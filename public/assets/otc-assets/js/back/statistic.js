var statistic_tbl = $("#statistic_tbl");
var statistic_msf = null;


window.app.defineEvents();


/* Statistic DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#statistic_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "statistic_title_index",
                name: "statistic_title_index",
                class: "text-center align-top mt-4"
            },
            {
                data: "statistic_title_en_index",
                name: "statistic_title_en_index",
                class: "text-center align-top mt-4"
            },
            {
                data: "statistic_card_color",
                name: "statistic_card_color",
                class: "text-center align-top mt-4"
            },
            {
                data: "statistic_icon",
                name: "statistic_icon",
                class: "text-center align-top mt-4"
            },
            {
                data: "statistic_type_name",
                name: "statistic_type_name",
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





