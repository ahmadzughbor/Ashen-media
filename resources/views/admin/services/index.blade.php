@extends('layouts.admin.index')


@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="javascript:void(0)" class="btn btn-primary  " id="createNewServise"> add Servise</a>
        <!-- <h6 class="m-0 font-weight-bold text-primary">slider</h6> -->

    </div>
    <div class="container">
        <h1>Servise section </h1>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>title</th>
                    <th>title_ar</th>
                    <th>description</th>
                    <th>description_ar</th>
                    <th>icon</th>
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
                <form id="serviceForm" name="serviceForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">title en</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title en" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">title ar</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title_ar" name="title_ar" placeholder="Enter title ar" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">description en</label>
                        <div class="col-sm-12">

                            <!-- <input type="text" class="form-control" id="description" name="description" placeholder="Enter Name" value="" maxlength="50" required=""> -->
                            <textarea class="form-control" id="description" name="description" placeholder="Enter description en"> </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">description ar </label>
                        <div class="col-sm-12">

                            <!-- <input type="text" class="form-control" id="description" name="description" placeholder="Enter Name" value="" maxlength="50" required=""> -->
                            <textarea class="form-control" id="description_ar" name="description_ar" placeholder="Enter description ar "> </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">service icon</label>
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
            $('#serviceForm').trigger("reset");
            $('#modelHeading').html("Create New service");
            $("#serviceForm").attr('action', "{{ route('service.store') }}");

            $('#ajaxModel').modal('show');
        });

        $(document).on('click', '.editservicee', function() {
            var id = $(this).data('serviceid');
            var url = $(this).data('url');
            
            $.ajax({
                data: id,
                url: "{{ route('service.edit') }}" + '/' + id,
                type: "get",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    
                    $('#title').val(data.title);
                    $('#title_ar').val(data.title_ar);
                    $('#description').val(data.description);
                    $('#description_ar').val(data.description_ar);

                    $("#serviceForm").attr('action', url);
                    $('#ajaxModel').modal('show');


                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $(document).on('click', '.deleteservice', function() {

            var product_id = $(this).data("serviceid");
            Swal.fire({
                title: 'هل انت متاكد من عملية الحدف?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'نعم',
                denyButtonText: `لا`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Saved!', '', 'success')

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('service.delete') }}" + '/' + product_id,
                        success: function(data) {
                            table.draw();
                            toastr.success('done');

                        },
                        error: function(data) {
                            toastr.error('error');
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })


        });

        $('#saveBtn').click(function(e) {

            var form = $("#serviceForm")[0];
            e.preventDefault();
            var data = new FormData(form)
            var url = $("#serviceForm").attr('action');
            
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
                    $('#serviceForm').trigger("reset");
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
            ajax: "{{ route('service.data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'title_ar',
                    name: 'title_ar'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'description_ar',
                    name: 'description_ar'
                },
                {
                    data: 'icon',
                    name: 'icon'
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