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
                <div class="center">
                    @include('admin.uploads.upload-form')
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @include('admin.uploads.folders.folders-table')
            </div>
        </div>
<?php  system('find '.storage_path('app/public/uploads').' -empty -type d -delete'); ?>
        @if(isset($files))
            <div class="row">
                <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                    @include('admin.uploads.uploads-table')
                </div>
            </div>
        @endif
    </div>
@stop