@extends('layout')
@section('content')
	<div id="main-content">
		<div class="display">
			<h1>{{ $card->title }}</h1>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-6-offset-3">	
					<ul class="list-group">
						@foreach($card->notes as $note)
							<li class="list-group-item">{{$note->body}}
                                <a class="pull-right" href="/notes/{{$note->id}}/edit">Edit</a>
                                <a href="#" class="pull-right">{{ $note->user->username }}</a>
                            </li>
						@endforeach	
					</ul>	
				</div>
			</div>	
			<div class="row">
				<div class="col-md-6">
					<form method="post" action="/cards/{{ $card->id }}/notes">
						{{ csrf_field() }}
						<div class="form-group">
							<textarea name="body" class="form-control">{{ old('body') }}</textarea>
						</div>
							<div class="form-group">
							<button type="submit" name="submit" class="form-control">Add Note</button>
						</div>
					</form>
                    @if (count($errors))
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="warning">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
				</div>
			</div>			
		</div>	
	</div>
@stop