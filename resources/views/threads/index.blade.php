@extends('layouts/app')

@section('content')

	<link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">

	<div style="max-width: 30%; margin: 0 auto; display: flex; justify-content: space-between; ">
		<a href="/threads">Allt</a>
		<a href="/threads?categories=Heimilið">Heimilið</a>
		<a href="/threads?categories=Matur">Matur</a>
		<a href="/threads?categories=Þrif">Þrif</a>
		<a href="/threads?categories=Lífið">Lífið</a>
		<a href="/threads?categories=Annað">Annað</a>
	</div>	

	<h1>Threads</h1>

	@foreach($threads as $thread)
	<div class="card mb-4">
		<div class="card-body">
			<div class="d-flex" style="float: left; margin: 2em; max-width: 25em; max-height: 30em;">
				@if ($thread->image_path)
					<img src="{{ asset('storage/' . $thread->image_path) }}">
				@endif
			</div>
   			<h5 class="card-title d-flex justify-content-between">
   				<a href="{{ $thread->path() }}">
   					{{ $thread->title }}
				</a>
				<form method="POST" action="/threads/{{ $thread->id }}/upvote">@csrf
					<button class="bg-transparent text-black font-semibold hover:text-green" style="outline: none;" onclick="myFunction()">
						Upvote
					</button>
				</form>
				<p>{{ $thread->upvote }}</p>
				<form method="POST" action="/threads/{{ $thread->id }}/downvote">@csrf
					<button id="upvoteButton" href='javascript:void();' class="bg-transparent text-black font-semibold hover:text-red" style="outline: none;">
						Downvote
					</button>
				</form>
				<div class="d-flex">
					@can('update', $thread)
						<a class="btn" href="/threads/{{ $thread->id }}/edit">Edit</a>
						<form method="POST" action="{{ $thread->path() }}">
							@csrf
							@method('DELETE')
							<button class="btn btn-danger">Delete</button>
						</form>
					@endcan()
				</div>
   			</h5>
       		<p class="card-text" style="display: flex; flex-wrap: nowrap;">
				{{ $thread->body }}
    		</p>
    		<div style="float:right; ">
    			<h6 style="display: flex; align-items: flex-end;" class="card-subtitle mb-2 text-muted">
    				<a href="/threads/user/{{ $thread->user->id }}">
    					{{ $thread->user->name }}
    				</a>
    			</h6>

    			<p class ="d-flex" style="color:grey; font-size:10px;">
    				{{ $thread->created_at}}
    			</p>
    			<p class ="d-flex" style="color:grey; font-size:10px;">{{ $thread->categories }}</p>
    		</div>
  		</div>
	</div>
	@endforeach
@endsection

<script>
function myFunction() {
    javascript:void(0)
}
</script>
