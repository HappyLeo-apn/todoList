@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">

            <div class="col-6 offset-3">
                <div class="my-2">
                   <a href="{{route('post#home')}}" class="text-decoration-none text-danger">
                    <i class="fa-solid fa-arrow-left"></i> back
                   </a>
                </div>
               
                <h1>{{$post[0]['title']}}</h1>
                <div class="d-flex">
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"> <i class="fa-solid fa-sack-dollar text-success"></i> {{$post[0]['price']}}-Ks</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"> <i class="fa-solid fa-location-dot text-danger"></i> {{$post[0]['address']}}</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"><i class="fa-solid fa-star text-warning"></i> {{$post[0]['rating']}}</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"><i class="fa-solid fa-calendar-days"></i> {{$post[0]['created_at']->format("j-F-Y")}}</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"><i class="fa-solid fa-clock"></i> {{$post[0]['created_at']->format("h:m:s:A")}}</div>
                </div>
                <div>
                   @if ($post[0]['image'] == null)
                    <img src="{{asset('404_image.png' )}}" alt="" class="img-thumbnail shadow-sm">
                   @else
                   <img src="{{asset('storage/' . $post[0]['image'])}}" alt="" class="img-thumbnail shadow-sm">
                   @endif
                </div>
                <p class="text-muted">
                     {{$post[0]['description']}}
                </p>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-2 offset-8">
               <a href="{{route('post#editPage', $post[0]['id'])}}">
                <button class="btn btn-dark text-white">Edit</button>
               </a>
            </div>
        </div>
    </div>
@endsection
