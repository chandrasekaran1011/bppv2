@extends('main.vlayout')

@section('content')

    <div class="container">
        @if($success)
        <div class="alert alert-success" role="alert">
            {{$msg}}
        </div>
        @else
        <div class="alert alert-danger" role="alert">
            {{$msg}}
        </div>
        @endif
    </div>
@endsection