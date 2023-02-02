@extends('master')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-5">
                <div class="p-3">
                    @if (session('insertSuccess'))
                    <div class="alert-text">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session('insertSuccess')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>

                    @endif
                    @if (session('updateSuccess'))
                    <div class="alert-text">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{session('updateSuccess')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>

                    @endif

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>


                    @endif --}}

                    <form action="{{route('post#create')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-group mb-3">
                            <label for="name" class="form-label">Post Title</label>
                            <input type="text" class="form-control @error('postTitle') is-invalid @enderror" value="{{old('postTitle')}}" name="postTitle" id="name" placeholder="Enter post title">

                                @error('postTitle')
                                <div class="invalid-feedback">
                                    {{$message}}
                                 </div>
                                @enderror

                        </div>
                        <div class="text-group mb-3">
                            <label for="" class="form-label">Post Description</label>
                            <textarea name="postDescription"  id="" cols="30" rows="10" placeholder="Enter post description" class="form-control @error('postDescription') is-invalid @enderror">{{old('postDescription')}}</textarea>

                           @error('postDescription')
                           <div class="invalid-feedback">
                                {{$message}}
                           </div>
                           @enderror

                        </div>
                        <div class="text-group mb-3">
                            <label for="" class="form-label ">Fee(in -Ks)</label>
                            <input type="number" name="postFee" class="form-control @error('postFee') is-invalid @enderror" placeholder="enter post fee" value = "{{old('postFee')}}" >
                            @error('postFee')
                                <div class="invalid-feedback">
                                    {{$message}}
                                 </div>
                                @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="" class="form-label">Image</label>
                            <input type="file" name="postImage" class="form-control @error('postImage') is-invalid @enderror"  {{old('postIamge')}} >
                            @error('postImage')
                                <div class="invalid-feedback">
                                    {{$message}}
                                 </div>
                                @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="" class="form-label ">Address</label>
                            <input type="text" name="postAddress" class="form-control @error('postAddress') is-invalid @enderror" placeholder="enter the address" value = "{{old('postAddress')}}" >
                            @error('postAddress')
                                <div class="invalid-feedback">
                                    {{$message}}
                                 </div>
                                @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="" class="form-label ">Rating</label>
                            <input type="number" min="0" max="5" name="postRating" class="form-control @error('postRating') is-invalid @enderror"  value = "{{old('postRating')}}" >
                            @error('postRating')
                                <div class="invalid-feedback">
                                    {{$message}}
                                 </div>
                                @enderror
                        </div>

                        <input type="submit" value="Create" class="btn btn-warning">
                    </form>
                </div>
            </div>
            <div class="col-7">
                <div class="d-flex justify-content-between">
                    <div><h3>Total - {{$posts->total()}}</h3></div>
                    <form action="{{route('post#createPage')}}" method="GET">
                        <div class="d-flex">
                            <input type="text" class="form-control" name="searchKey" value="{{ request('searchKey')}}" id="">
                            <button class="btn btn-danger" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
                <div class="data-container">
                   @if (count($posts)!= 0)
                   @foreach ($posts as $item)
                   <div class="post shadow-lg p-3 mb-4">
                       <div class="d-flex justify-content-between bg-white">
                           <h5>{{$item['title']}}</h5>
                          {{$item->created_at->format('d-m-Y | n:i:A')}}
                       </div>
                       <p class="text-muted">{{ Str::words($item['description'], 20, '...') }}</p>
                       <span>
                           <small>
                               <i class="fa-solid fa-sack-dollar text-success"></i> {{$item->price}}-Ks
                           </small>
                       </span>
                       |
                       <span>
                           <small>
                               <i class="fa-solid fa-location-dot text-danger"></i> {{$item->address}}
                           </small>
                       </span>
                       |
                       <span>
                           <i class="fa-solid fa-star text-warning"></i> {{$item->rating}}
                       </span>
                       <div class="text-end">
                           <a href="{{route('post#delete', $item['id'])}}">
                               <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> ဖျက်ရန်</button>
                           </a>
                           {{-- <form action="{{route('post#create', $item['id'])}}" method="POST">
                               @csrf
                               @method('delete')
                               <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> ဖျက်ရန်</button>
                           </form> --}}
                           <a href="{{route('post#updatePage', $item['id'])}}">
                               <button class="btn btn-sm btn-primary"><i class="fa-regular fa-file-lines"></i> အပြည့်အစုံဖတ်ရန်</button>
                           </a>
                       </div>
                   </div>
                   @endforeach

                   @else
                       <div class="alert alert-danger text-center mt-5">
                            There is no search data!
                       </div>
                   @endif
                </div>
                {{$posts->appends(request()->query())->links()}}
            </div>
        </div>
    </div>
@endsection
