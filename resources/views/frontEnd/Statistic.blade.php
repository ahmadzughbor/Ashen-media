<div class="container bg-purecounter py-5">
    <div class="row counters">

        <div class="col-md-3 mb-md-0 mb-3 col-6 text-center">
            <img src="{{ $assets }}/assets/img/01.svg" alt>
            <span data-purecounter-start="0" data-purecounter-end="{{ $Statistic ? $Statistic->num1 :1}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>{{ $Statistic ? $Statistic->section1 : ''}}</p>
        </div>

        <div class="col-md-3 col-6 mb-md-0 mb-3 text-center">
            <img src="{{ $assets }}/assets/img/02.svg" alt>
            <span data-purecounter-start="0" data-purecounter-end="{{$Statistic ? $Statistic->num2 :1}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>{{ $Statistic ? $Statistic->section2 : ''}}</p>
        </div>

        <div class="col-md-3 col-6 mb-md-0 mb-3 text-center">
            <img src="{{ $assets }}/assets/img/03.svg" alt>
            <span data-purecounter-start="0" data-purecounter-end="{{$Statistic ? $Statistic->num3 :1}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>{{ $Statistic ? $Statistic->section3 : ''}}</p>
        </div>

        <div class="col-md-3 col-6 mb-md-0 mb-3 text-center">
            <img src="{{ $assets }}/assets/img/04.svg" alt>
            <span data-purecounter-start="0" data-purecounter-end="{{$Statistic ? $Statistic->num4 :1}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>{{ $Statistic ? $Statistic->section4 : ''}}</p>
        </div>
    </div>

</div>