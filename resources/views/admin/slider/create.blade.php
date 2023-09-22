@extends('layouts.admin.index')


@section('content')

    <h1>add slide</h1>
    <form action="{{route('slider.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')

    <div class="col-md-6 mb-10">
        <label class="form-label">name </label>
        <input type="text" name="name" value="" class="form-control form-control-solid"/>
       
    </div>
    <div class="col-md-6 mb-10">
        <label class="form-label">photo </label>
        <input type="file" name="file" class="form-control form-control-solid"/>
       
    </div>
    <div class="col-md-6 mb-10">
            <button type="submit"  class="btn btn-primary mt-3">save</button>       
    </div>

    </form>

@endsection
