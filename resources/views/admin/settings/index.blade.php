@extends('layouts.admin.index')


@section('content')

<h1> settings : الاعدادت </h1>
<form action="{{route('settings.store')}}" method="post" id="settingsForm" name="settingsForm" enctype="multipart/form-data">
    @csrf
    @method('post')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="whatsappLink">WhatsApp Link</label>
                <input type="text" value="@isset($settings) {{ $settings->whatsappLink }} @endisset " name="whatsappLink" class="form-control" id="whatsappLink" placeholder="WhatsApp Link">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="facebookLink">Facebook Link</label>
                <input type="text" value="@isset($settings) {{ $settings->facebookLink }} @endisset " name="facebookLink" class="form-control" id="facebookLink" placeholder="Facebook Link">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="twitterLink">Twitter Link</label>
                <input type="text" value="@isset($settings) {{ $settings->twitterLink }} @endisset " name="twitterLink" class="form-control" id="twitterLink" placeholder="Twitter Link">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="instagramLink">Instagram Link</label>
                <input type="text" value="@isset($settings) {{ $settings->instagramLink }} @endisset " name="instagramLink" class="form-control" id="instagramLink" placeholder="Instagram Link">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="snapchatLink">Snapchat Link</label>
                <input type="text" value="@isset($settings) {{ $settings->snapchatLink }} @endisset " name="snapchatLink" class="form-control" id="snapchatLink" placeholder="Snapchat Link">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="tiktokLink">TikTok Link</label>
                <input type="text" value="@isset($settings) {{ $settings->tiktokLink }} @endisset " name="tiktokLink" class="form-control" id="tiktokLink" placeholder="TikTok Link">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="snapchatLink">app logo</label>

                <input type="file" name="app_logo"  class="form-control" id="app_logo" placeholder="app_logo">
            </div>
        </div>
        @if($settings)
        @if($settings->app_logo)
        <div class="col-md-6">
            <div class="form-group">

                <label for="snapchatLink">cuurent app logo</label>

                <img src="{{asset('storage/images/' . $settings->app_logo)}}" alt="" width="50" height="50">
            </div>
        </div>
        @endif

        @endif
    </div>

    <div class="col-md-12">
        <button id="saveBtn" class="btn btn-primary mt-3">Save</button>
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

    $(document).on('click', '#saveBtn', function(e) {
        e.preventDefault();

        var form = $("#settingsForm")[0];
        var data = new FormData(form)
        var url = $("#settingsForm").attr('action');
        $.ajax({
            data: data,
            url: url,
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#whatsappLink').val(data.whatsappLink);
                $('#instagramLink').val(data.instagramLink);
                $('#facebookLink').val(data.facebookLink);
                $('#twitterLink').val(data.whatsappLink);
                $('#tiktokLink').val(data.tiktokLink);
                $('#snapchatLink').val(data.snapchatLink);

                toastr.success('done');


            },
            error: function(data) {
                toastr.error(data.responseJSON.message);

            }
        });
    });
</script>