@extends('layouts/app')

@section('content')
<body>
	<div class="d-flex" style="float: left; margin: 2em;">
		@if ($thread->image_path)
			<img src="{{ asset('storage/' . $thread->image_path) }}">
		@endif
	</div>
	<h1>
		{{ $thread->title }}
	</h1>
	<p>
		{{ $thread->body }}
	</p>
	@auth
	<form method="POST" action="/threads/{{ $thread->id }}/comment">
		@csrf
		<div class="form-group">
			<textarea name="body" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<button class="btn btn-primary">Post</button>
		</div>
	</form>
	@else
		<p>Please sign in to leave a comment</p>
	@endauth
	@foreach($thread->comments()->latest()->get() as $comment)
		<h6>{{ $comment->user->name }}</h6>
		<p>{{ $comment->body }}</p>
		<p class ="d-flex" style="color:grey; font-size:10px;">
    		{{ $thread->created_at}}
    	</p>
	@endforeach
@endsection