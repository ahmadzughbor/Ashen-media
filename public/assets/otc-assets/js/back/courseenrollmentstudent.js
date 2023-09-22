var courseenrollmentstudent_tbl = $("#courseenrollmentstudent_tbl");
var courseenrollmentstudent_msf = null;


window.app.defineEvents();


/* CourseEnrollmentStudent DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#courseenrollmentstudent_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "user_name",
                name: "user_name",
                class: "text-right align-top mt-4"
            },
            {
                data: "course_name",
                name: "course_name",
                class: "text-center align-top mt-4"
            },
            {
                data: "grade",
                name: "grade",
                class: "text-center align-top mt-4"
            },
            {
                data: "is_graduated",
                name: "is_graduated",
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





