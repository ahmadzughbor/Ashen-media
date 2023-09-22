var activitiesandevent_tbl = $("#activitiesandevent_tbl");
var activitiesandevent_msf = null;


window.app.defineEvents();


/* ActivitiesAndEvent DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#activitiesandevent_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "name",
                name: "name",
                class: "text-center align-top mt-4"
            },
            {
                data: "appointment",
                name: "appointment",
                class: "text-center align-top mt-4"
            },
            {
                data: "address",
                name: "address",
                class: "text-center align-top mt-4"
            },
            {
                data: "attendance",
                name: "attendance",
                class: "text-center align-top mt-4"
            },
            {
                data: "is_public",
                name: "is_public",
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





