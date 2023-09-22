
$(document).ready(function () {
    getCoursesModelsAttchmentsList(url_update_course_model_attchments);
  
})
function getCoursesModelsAttchmentsList(url_update_course_model_attchments) {
   
    $.ajax({
        url: url_update_course_model_attchments  ,
     
        success: function(response) {
      
            $("#courses-models-div").html(response);
        },
     
    });

}

function refreshCoursesModelTbl(object, response) {

    $("#courses-models-div").html(response.DATA);
    

}




