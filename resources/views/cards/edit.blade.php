@extends('layout')

@section('content')
    <h1>Edit Note</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="/notes/{{ $note->id }}">
                    {{ method_field('PATCH') }}
                    {{ csrf_field()}}
                    <div class="form-group">
                        <textarea name="body" class="form-control">{{ $note->body }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="form-control">Edit Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop