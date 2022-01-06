@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                       Edit Post
                    </div>
                    <div class="card-body">
                        <form action="{{route('post.update',$post->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Post Title</label>
                                        <input type="text" name="title" value="{{old('title',$post->title)}}" class="form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                        <p class="text-danger small">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Category</label>
                                        <select type="text" name="category" value="{{old('category')}}" class="form-select @error('category') is-invalid @enderror">
                                            @foreach(\App\Models\Category::all() as $category)
                                                <option value="{{$category->id}}" {{old('category',$post->category_id) == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                            @error('category')
                                            <p class="text-danger small">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label>Description</label>
                                        <textarea type="text" name="description" rows="10" class="form-control @error('description') is-invalid @enderror">{{old('description',$post->description)}}</textarea>
                                        @error('description')
                                        <p class="text-danger small">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                        @if (session('status'))
                            <p class="alert alert-success">{{session('status')}}</p>
                        @endif

                    </div>
                </div>



            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Manage Photo
                    </div>
                    <div class="card body">
                        <div class="mb-3">
                            <form action="{{route('photo.store')}}" method="post" enctype="multipart/form-data" class="d-none" id="uploaderForm">
                                @csrf
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <input type="file" name="photo[]" class="form-control" multiple id="uploaderInput">
                                <button class="btn btn-outline-primary">Upload</button>

                            </form>
                        </div>
                        <div class="mb-3 ">
                            <div class="d-inline-flex justify-content-center align-items-center border border-dark border-2 rounded" id="uploaderUi">
                                <i class="fas fa-plus-circle fa-2x"></i>
                            </div>
                            @forelse($post->photos as $photo)
                                <div class="d-inline-block position-relative" style="width:100px; height: 100px ">
                                    <img src="{{asset('storage/thumbnail/'.$photo->name)}}" class="position-absolute" height="100" alt="">
                                    <form action="{{route('photo.destroy',$photo->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger position-absolute btn-sm" style="bottom: 5px;right: 5px">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let uploaderUi = document.getElementById('uploaderUi');
        let uploaderInput = document.getElementById('uploaderInput');
        let uploaderForm = document.getElementById('uploaderForm');

        uploaderUi.addEventListener('click',function (){
            uploaderInput.click();
        })
        uploaderInput.addEventListener('change',function (){
            uploaderForm.submit();
        })
    </script>
@endsection
