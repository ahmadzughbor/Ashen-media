var course_tbl = $("#course_tbl");
var course_msf = null;


window.app.defineEvents();


/* Course DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#course_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "courseName",
                name: "courseName",
                class: "text-center align-top mt-4"
            },
            {
                data: "program",
                name: "program",
                class: "text-center align-top mt-4"
            },
            {
                data: "status",
                name: "status",
                class: "text-center align-top mt-4"
            },
            {
                data: "publishing_status",
                name: "publishing_status",
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




function addObjectiveKeyword(input,list){
    addObjectiveKeywordToContainer('#objectives_input','#objectives_list');
}


// function appendKeywords(form, formData){
//     let objectives = collectContainerKeywords('objectives_list');
//     let outcomes = collectContainerKeywords('outcomes_list');
// }


