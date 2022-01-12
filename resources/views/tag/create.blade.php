@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                       Mange Category
                    </div>
                    <div class="card-body">
                        <form action="{{route('tag.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="">
                                        <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-primary">Add</button>

                                    </div>
                                </div>
                            </div>
                            @error('title')
                            <p class="text-danger small">{{$message}}</p>
                            @enderror
                        </form>

                        @if (session('status'))
                            <p class="alert alert-success">{{session('status')}}</p>
                        @endif

                    </div>
                </div>
                @include('tag.list')

            </div>
        </div>
    </div>
@stop
