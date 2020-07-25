@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @foreach ($apps as $key=>$a)
            <div class="col-md-4 " >
            <a href="{{$a->link}}"   style="text-decoration: none">
                <div class="card rounded mb-3 animate__animated animate__fadeInDown animate__delay-{{$key+1}}s" style="width: 18rem;">
                <img class="card-img-top" src="{{$a->image}}" alt="Card image cap">
                    <div class="card-header text-white text-center " style="background-color: #3f51b5">
                       <strong>{{$a->short}} </strong> 
                    </div>
                    </div>
                </a>
            </div> 
        @endforeach

    </div>
</div>
@endsection
