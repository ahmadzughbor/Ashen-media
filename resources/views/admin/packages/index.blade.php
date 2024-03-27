@extends('layouts.admin.index')


@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="javascript:void(0)" class="btn btn-primary  " id="createNewServise"> add package</a>
        <!-- <h6 class="m-0 font-weight-bold text-primary">slider</h6> -->

    </div>
    <div class="container">
        <h1>package section </h1>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>name</th>
                    <th>amount</th>
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
                <form id="package-form" id="package-form" name="package-form" class="form-horizontal">
                    <div class="form-group">
                        <label for="packageName">Package Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="packagePrice">Package Price:</label>
                        <input type="number" class="form-control" id="amount" name="amount">
                    </div>

                    <h4>Features:</h4>
                    <div id="features-container">
                        <!-- Features will be added here -->
                        @if(isset($Package))
                        @foreach($Package->features as $index => $feature)
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Feature Name" name="featureNames[]" value="{{ $feature->name }}">
                            <input type="text" class="form-control" placeholder="Feature Value" name="featureValues[]" value="{{ $feature->value }}">
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <button type="button" class="btn btn-success" id="addFeature">Add Feature</button>
                    <button id="saveBtn" class="btn btn-primary">Add Package</button>
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
            $('#package-form').trigger("reset");
            $('#features-container').html("");
            $('#modelHeading').html("Create New package");
            $("#package-form").attr('action', "{{ route('packages.store') }}");

            $('#ajaxModel').modal('show');
        });

        $(document).on('click', '.editproject', function() {
            var id = $(this).data('packageid');
            var url = $(this).data('url');
            
            $.ajax({
                data: id,
                url: "{{ route('packages.edit') }}" + '/' + id,
                type: "get",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    
                    $('#amount').val(data.amount);
                    $('#name').val(data.name);

                    $("#package-form").attr('action', url);

                    $('#ajaxModel').modal('show');
                    $.each(data.features, function(index, feature) {
                        var featureNameInput = $('<input type="text" class="form-control mt-2" placeholder="Feature Name" name="featureNames[]" value="' + feature.name + '">');
                        var featureValueInput = $('<input type="text" class="form-control mt-2" placeholder="Feature Value" name="featureValues[]" value="' + feature.value + '">');
                        var deleteButton = $('<button type="button" class="btn btn-danger mt-2">Delete</button>');

                        deleteButton.on('click', function() {
                            // Remove the feature inputs and delete button
                            featureNameInput.remove();
                            featureValueInput.remove();
                            deleteButton.remove();
                        });

                        $('#features-container').append(featureNameInput);
                        $('#features-container').append(featureValueInput);
                        $('#features-container').append(deleteButton);
                    });

                },
                error: function(data) {

                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $(document).on('click', '.deletepackage', function() {

            var product_id = $(this).data("packageid");
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
                        url: "{{ route('packages.delete') }}" + '/' + product_id,
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

            var form = $("#package-form")[0];
            e.preventDefault();
            var data = new FormData(form)
            var url = $("#package-form").attr('action');
            
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
            ajax: "{{ route('packages.data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // Function to add a feature field
        $('#addFeature').on('click', function() {
            var featureNameInput = $('<input type="text" class="form-control mt-2" placeholder="Feature Name" name="featureNames[]">');
            var featureValueInput = $('<input type="text" class="form-control mt-2" placeholder="Feature Value" name="featureValues[]">');
            var removeButton = $('<button type="button" class="btn btn-danger mt-2">Remove</button>');

            removeButton.on('click', function() {
                featureNameInput.remove(); // Remove the name input field
                featureValueInput.remove(); // Remove the value input field
                $(this).remove(); // Remove the remove button
            });

            $('#features-container').append(featureNameInput);
            $('#features-container').append(featureValueInput);
            $('#features-container').append(removeButton);
        });


    }
</script>