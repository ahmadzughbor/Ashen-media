var activitiesandevent_tbl = $("#approvalrejectionactivity_tbl");
var activitiesandevent_msf = null;


window.app.defineEvents();


/* ActivitiesAndEvent DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#approvalrejectionactivity_tbl",
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
                data: "type",
                name: "type",
                class: "text-center align-top mt-4"
            },
            {
                data: "attendance",
                name: "attendance",
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





