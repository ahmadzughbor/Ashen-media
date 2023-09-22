@extends('layouts.admin.index')


@section('content')

<h1>add our vision section</h1>
<form action="{{route('aboutus.storeVision')}}" method="post" id="visionForm" name="visionForm" enctype="multipart/form-data">
    @csrf
    @method('post')

    <div class="col-md-6 mb-10">
        <label class="form-label">description </label>
        <textarea name="description"  class="form-control form-control-solid" cols="30" rows="10"> @isset($ourvision){{  $ourvision->description}}  @endisset</textarea>
    </div>
    <div class="col-md-6 mb-10">
        <label class="form-label">photo </label>
        <input type="file" name="file" class="form-control form-control-solid" />
        @if($ourvision)
        @if($ourvision->path)
        <img src="{{asset('storage/images/' . $ourvision->path)}}" alt="" width="40" height="40">
        @endif
        @endif

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

        var form = $("#visionForm")[0];
        e.preventDefault();
        var data = new FormData(form)
        var url = $("#visionForm").attr('action');
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

                
            },
            error: function(data) {
                toastr.error(data.responseJSON.message);

            }
        });
    });
</script>