@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{$post->title}}
                    </div>
                    <div class="card-body">
                        {{$post->description}}
                        <hr>
                        <button class="btn btn-primary">Read All</button>

                    </div>
                </div>


            </div>
        </div>
    </div>
@stop
