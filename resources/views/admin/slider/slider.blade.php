@extends('layouts.admin.index')


@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="javascript:void(0)" class="btn btn-primary  " id="createNewSlide"> add slider</a>
        <!-- <h6 class="m-0 font-weight-bold text-primary">slider</h6> -->

    </div>
    <div class="container">
        <h1>slider section </h1>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>file</th>
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
                <form id="sildeForm" name="sildeForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">file</label>
                        <div class="col-sm-12">
                            <input type="file" src="" id="file" name="file">
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
        $('#createNewSlide').click(function() {
            $('#saveBtn').val("create-slide");
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New slide");
            $("#sildeForm").attr('action', "{{ route('slider.store') }}");

            $('#ajaxModel').modal('show');
        });

        $(document).on('click', '.editSlide', function() {
            debugger;
            var id = $(this).data('slideid');
            var url = $(this).data('url');
            $.ajax({
                data: id,
                url: "{{ route('slider.edit') }}" + '/' + id,
                type: "get",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    debugger;
                    $('#name').val(data.name);
                    var imagePath = "{{ asset('storage/images/') }}" + '/' + data.path;

                    $('#file').attr('src', imagePath);
                    $("#sildeForm").attr('action', url);
                    $('#ajaxModel').modal('show');


                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $(document).on('click', '.deleteSile', function() {

            var product_id = $(this).data("slideid");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('slider.delete') }}" + '/' + product_id,
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

            var form = $("#sildeForm")[0];
            e.preventDefault();
            var data = new FormData(form)
            var url = $("#sildeForm").attr('action');

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
            ajax: "{{ route('slider.data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'file',
                    name: 'file'
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