@extends('layouts.admin.index')


@section('content')

<h1> Statistics  :  الاحصائيات</h1>
<form action="{{route('Statistic.store')}}" method="post" id="StatisticsForm" name="StatisticsForm" enctype="multipart/form-data">
    @csrf
    @method('post')

    <div class="row">
            <div class="col-md-12">
                <div class="form-group form-inline">
                    <label for="section1_label1">Section 1 :</label>
                    <input type="text" value="@if($Statistic){{ $Statistic->section1}} @endif"  name="section1"class="form-control mx-2" id="section1" placeholder="Section 1 ">
                    <input type="text" value="@if($Statistic){{ $Statistic->section1_ar}} @endif"  name="section1_ar"class="form-control mx-2" id="section1_ar" placeholder="section ar 1 ">
                    <input type="number"   value="{{ $Statistic ? $Statistic->num1 : '' }}"   name="num1" class="form-control mx-2" id="num1" placeholder="القيمة">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group form-inline">
                    <label for="section1_label2">Section 2:</label>
                    <input type="text" value="@if($Statistic){{ $Statistic->section2}} @endif"   name="section2"class="form-control mx-2" id="section2" placeholder="Section 2">
                    <input type="text" value="@if($Statistic){{ $Statistic->section2_ar}} @endif"   name="section2_ar"class="form-control mx-2" id="section2_ar" placeholder="section ar 2">
                    <input type="number" value="{{ $Statistic ? $Statistic->num2 : '' }}" name="num2" class="form-control mx-2" id="num2" placeholder="القيمة">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-inline">
                    <label for="section2_label1">Section 3 :</label>
                    <input type="text"  value="@if($Statistic){{ $Statistic->section3}} @endif"  name="section3"class="form-control mx-2" id="section3" placeholder="Section 3 ">
                    <input type="text"  value="@if($Statistic){{ $Statistic->section3_ar}} @endif"  name="section3_ar"class="form-control mx-2" id="section3_ar" placeholder="section ar 3 ">
                    <input type="number" value="{{ $Statistic ? $Statistic->num3 : '' }}"   name="num3" class="form-control mx-2" id="num3" placeholder="القيمة">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group form-inline">
                    <label for="section2_label2">Section 4 :</label>
                    <input type="text" value="@if($Statistic){{ $Statistic->section4}} @endif"  name="section4" class="form-control mx-2" id="section4" placeholder="Section 4">
                    <input type="text" value="@if($Statistic){{ $Statistic->section4_ar}} @endif"  name="section4_ar" class="form-control mx-2" id="section4_ar" placeholder="section ar 4">
                    <input type="number" value="{{ $Statistic ? $Statistic->num4 : '' }}"   name="num4" class="form-control mx-2" id="num4" placeholder="القيمة">
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-10">
            <button id="saveBtn" class="btn btn-primary mt-3">save</button>
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

        var form = $("#StatisticsForm")[0];
        var data = new FormData(form)
        var url = $("#StatisticsForm").attr('action');
        
        $.ajax({
            data: data,
            url: url,
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#section4').val(data.section4);
                $('#num4').val(data.num4);
                $('#section3').val(data.section3);
                $('#num3').val(data.num3);
                $('#section2').val(data.section2);
                $('#num2').val(data.num2);
                $('#section1').val(data.section1);
                $('#num1').val(data.num1);
                $('#section1_ar').val(data.section1_ar);
                $('#section2_ar').val(data.section2_ar);
                $('#section3_ar').val(data.section3_ar);
                $('#section4_ar').val(data.section4_ar);
                $('#StatisticsForm').trigger("reset");
                toastr.success('done');


            },
            error: function(data) {
                toastr.error(data.responseJSON.message);

            }
        });
    });
</script>