@extends('layouts.admin.index')


@section('content')

<h1>update your password</h1>
<form action="{{route('newPassword.store')}}" method="post" id="passwordForm" name="passwordForm" enctype="multipart/form-data">
    @csrf
    @method('post')

    <div class="col-md-6 mb-10">
        <label class="form-label"> inter your password </label>
        <input type="password" name="password"  class="form-control form-control-solid" id="password">
    </div>
    <div class="col-md-6 mb-10">
        <label class="form-label">inter your new password</label>
        <input type="password" name="New_password"  class="form-control form-control-solid" id="New_password">
    </div>
    <div class="col-md-6 mb-10">
        <label class="form-label">Confirm the password </label>
        <input type="password" name="Confirm_password"  class="form-control form-control-solid" id="Confirm_password">
        

    </div>
    
    <div class="col-md-6 mb-10">
        <button  id="saveBtn" class="btn btn-primary mt-3">save</button>
    </div>

</form>




@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(function() {

        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
    });

    $(document).on('click','#saveBtn',function(e) {
        e.preventDefault();

        var form = $("#passwordForm")[0];
        var data = new FormData(form)
        var url = $("#passwordForm").attr('action');
        $.ajax({
            data: data,
            url: url,
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                $('#ajaxModel').modal('hide');
                toastr.success('done');

                
            },
            error: function(data) {
                debugger;
                toastr.error(data.responseJSON);

            }
        });
    });
</script>