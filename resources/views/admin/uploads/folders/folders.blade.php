@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @if (count($errors))
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session()->get('success') }}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @include('admin.uploads.folders.folders-table')
            </div>
        </div>
    </div>
@stop