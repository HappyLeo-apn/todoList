@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">

            <div class="col-6 offset-3">
                <div class="my-2">
                   <a href="{{route('post#updatePage', $post['id'])}}" class="text-decoration-none text-danger">
                    <i class="fa-solid fa-arrow-left"></i> back
                   </a>
                </div>
                <form action="{{route('post#update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="postId" value="{{$post['id']}}">
                    <label for="">Post Title</label>
                    <input type="text" name="postTitle" class="form-control @error('postTitle') is-invalid @enderror" id="" placeholder="Enter Post Title" value="{{old('postTitle', $post['title'])}}">
                    @error('postTitle')
                                <div class="invalid-feedback mb-3">
                                    {{$message}}
                                 </div>
                                @enderror
                                <div>
                                    @if ($post['image'] == null)
                                     <img src="{{asset('404_image.png' )}}" alt="" class="img-thumbnail shadow-sm">
                                    @else
                                    <img src="{{asset('storage/' . $post['image'])}}" alt="" class="img-thumbnail shadow-sm">
                                    @endif
                                 </div>
                                 <input type="file" name="postImage" class="form-control @error('postImage') is-invalid @enderror"  {{old('postIamge')}} >
                                @error('postImage')
                                <div class="invalid-feedback">
                                    {{$message}}
                                 </div>
                                @enderror
                    <label for="">Post Description</label>
                    <textarea name="postDescription" class="form-control my-2 @error('postDescription') is-invalid @enderror" id="" placeholder="Enter Post Description" cols="30" rows="10">{{old('postDescription', $post['description'])}}
                    </textarea>
                    @error('postDescription')
                                <div class="invalid-feedback">
                                    {{$message}}
                                 </div>
                                @enderror
                                    <div class="text-group mb-3">
                                    <label for="" class="form-label ">Price</label>
                                    <input type="number"  name="postFee" class="form-control"  value = "{{$post['price']}}" >
                                    
                                </div>
                                <div class="text-group mb-3">
                                    <label for="" class="form-label ">Address</label>
                                    <input type="text"  name="postAddress" class="form-control"  value = "{{$post['address']}}" >
                                   
                                </div>
                                <div class="text-group mb-3">
                                    <label for="" class="form-label ">Rating</label>
                                    <input type="number"  name="postRating" class="form-control"  value = "{{$post['rating']}}" >
                                    
                                </div>
                    <input type="submit" value="Update" class="btn btn-dark float-end">
                </form>
            </div>
        </div>
        {{-- <div class="row my-3">
            <div class="col-2 offset-8">
                <button class="btn btn-dark text-white">Edit</button>
            </div>
        </div> --}}
    </div>
@endsection
