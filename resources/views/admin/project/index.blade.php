@extends('layouts.admin.index')


@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="javascript:void(0)" class="btn btn-primary  " id="createNewServise"> add Project</a>
        <!-- <h6 class="m-0 font-weight-bold text-primary">slider</h6> -->

    </div>
    <div class="container">
        <h1>Projects section </h1>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>name</th>
                    <th>link</th>
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
                <form id="ProjectForm" name="ProjectForm" class="form-horizontal">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">link</label>
                        <div class="col-sm-12">

                            <input type="text" class="form-control" id="link" name="link" placeholder="Enter link" value="" maxlength="50" required="">
                            <!-- <textarea class="form-control" id="link" name="description" placeholder="Enter Name"> </textarea> -->
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
            $('#ProjectForm').trigger("reset");
            $('#modelHeading').html("Create New project");
            $("#ProjectForm").attr('action', "{{ route('project.store') }}");

            $('#ajaxModel').modal('show');
        });

        $(document).on('click', '.editproject', function() {
            var id = $(this).data('projectid');
            var url = $(this).data('url');
            debugger;
            $.ajax({
                data: id,
                url: "{{ route('project.edit') }}" + '/' + id,
                type: "get",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    debugger;
                    $('#link').val(data.link);
                    $('#name').val(data.name);

                    $("#ProjectForm").attr('action', url);
                    $('#ajaxModel').modal('show');


                },
                error: function(data) {

                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $(document).on('click', '.deleteproject', function() {

            var product_id = $(this).data("projectid");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('project.delete') }}" + '/' + product_id,
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

            var form = $("#ProjectForm")[0];
            e.preventDefault();
            var data = new FormData(form)
            var url = $("#ProjectForm").attr('action');
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

                    // $('#ProjectForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    toastr.success('done');

                    table.ajax.reload();
                },
                error: function(data) {
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
            ajax: "{{ route('project.data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'link',
                    name: 'link'
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