
window.app.defineEvents();


function userPermissionFunction(elementJQ, event) {
    event.preventDefault();
    var form = $('#user_search_permission');
    var userPermissionContent = $('#userPermissionContent');
    var type = 'normal';
    $.ajax({
        type: "GET",
        url: app.page_url + '/getUserPermission',
        data: form.serialize(),
        success: function (data) {
            userPermissionContent.html(data);
            $('.select-all').click(function (event) {
                var groupId = $(this).data('groupId');
                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox.group' + groupId).each(function () {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox.group' + groupId).each(function () {
                        this.checked = false;
                    });
                }
            });
            $('.selectpicker').selectpicker('refresh');

            $('.default-btn').click(function (e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                userPermissionFunction(form, actionUrl, 'default');


            });

            $("#submitPermission").submit(function (e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                $.ajax({
                    type: "POST",
                    url: app.page_url + '/syncUserPermissions',
                    data: $(this).serialize(),
                    type: "post",
                    success: function (data) {
                        if (data.STATUS) {
                            toastr.success(data.MESSAGE);
                            // location.reload();
                        } else
                            toastr.error(data.MESSAGE);
            
            
                    },
                    error: function (data) {
                        toastr.error(data.MESSAGE);
                    }
                });
            });
            

            $(".user_search_permission").find('.spinner-loading').css('display', 'none');
            $(".user_search_permission").find('.search-icon').css('display', 'block');

        },
        error: function (jqXHR, textStatus, errorThrown) {

        }

    })
}



var user_options = {
    values: "a, b, c",
    ajax: {
        url: app.page_url + '/getUsers',
        type: "POST",
        dataType: "json",
        data: {
            q: '{{{q}}}'
        }
    },

    locale: {
        emptyTitle: 'ابدأ بالكتابة واختار المستخدمين',
        statusInitialized: 'ابدأ بالكتابة واختار المستخدمين',
        searchPlaceholder: 'ابحث',
        statusNoResults: 'لا بوجد نتائج',
        errorText: 'لا يوجد نتائج',
    },
    preprocessData: function (data) {
        var i,
            l = data.length,
            array = [];
        if (l) {
            for (i = 0; i < l; i++) {
                array.push(
                    $.extend(true, data[i], {
                        text: data[i].name,
                        value: data[i].id,
                    })
                );
            }
        }

        return array;
    }
};


$("#users_list")
    .selectpicker()
    .filter(".with-ajax")
    .ajaxSelectPicker(user_options);
$("select").trigger("change");

function chooseSelectpicker(index, selectpicker) {
    $(selectpicker).val(index);
    $(selectpicker).selectpicker('refresh');
}