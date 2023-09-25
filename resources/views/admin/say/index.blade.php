@extends('layouts.admin.index')


@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="javascript:void(0)" class="btn btn-primary  " id="createNewServise"> add slider</a>
        <!-- <h6 class="m-0 font-weight-bold text-primary">slider</h6> -->

    </div>
    <div class="container">
        <h1>slider section </h1>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>user name</th>
                    <th>company name</th>
                    <th>description</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="sayForm" name="sayForm" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">user_name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">company_name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">description</label>
                        <div class="col-sm-12">

                            <!-- <input type="text" class="form-control" id="description" name="description" placeholder="Enter Name" value="" maxlength="50" required=""> -->
                            <textarea class="form-control" id="description" name="description" placeholder="Enter Name"> </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">User image</label>
                        <div class="col-sm-12">
                            <input type="file" src="" id="image" name="image">
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10">
                        <button class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

    $(document).ready(function() {
        getdata();
        $('#createNewServise').click(function() {
            $('#saveBtn').val("create-service");
            $('#product_id').val('');
            $('#sayForm').trigger("reset");
            $('#modelHeading').html("Create New say");
            $("#sayForm").attr('action', "{{ route('say.store') }}");

            $('#ajaxModel').modal('show');
        });

        $(document).on('click', '.editsay', function() {
            var id = $(this).data('sayid');
            var url = $(this).data('url');
            debugger;
            $.ajax({
                data: id,
                url: "{{ route('say.edit') }}" + '/' + id,
                type: "get",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    debugger;
                    $('#user_name').val(data.user_name);
                    $('#company_name').val(data.company_name);
                    $('#description').val(data.description);

                    $("#sayForm").attr('action', url);
                    $('#ajaxModel').modal('show');


                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $(document).on('click', '.deletesay', function() {

            var product_id = $(this).data("sayid");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('say.delete') }}" + '/' + product_id,
                success: function(data) {
                    table.draw();
                    toastr.success('done');

                },
                error: function(data) {
                    toastr.error('error');
                }
            });
        });

        $('#saveBtn').click(function(e) {

            var form = $("#sayForm")[0];
            e.preventDefault();
            var data = new FormData(form)
            var url = $("#sayForm").attr('action');
            debugger;
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

                    table.ajax.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                    toastr.error(data.responseJSON.message);

                    $('#saveBtn').html('Save Changes');
                }
            });
        });
    });

    var table = $('.data-table').DataTable();

    function getdata() {

        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('say.data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

    }
</script>