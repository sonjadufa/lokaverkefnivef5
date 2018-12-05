<?php

namespace App\Http\Controllers;
use App\Thread;
use Illuminate\Http\Request;
use App\User;

class ThreadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $threads = Thread::latest();
        if (request("categories")) {
            $threads = $threads->where("categories", request('categories'));
        }
        if($user->exists){
            $threads = $threads->where('user_id', $user->id);
        }

        $threads = $threads->get();

        return view("threads/index", compact("threads"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = [
            'Heimilið',
            'Matur',
            'Þrif',
            'Lífið',
            'Annað'
        ];

        return view("threads/create", compact('Categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $thread = Thread::create([
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->id(),
            'image_path' => request('image') ? request()->file('image')->store('img', 'public') : null,
            'created_at' => request('created_at'),
            'upvote' => request('upvote'),
            'categories' => request('categories')
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return view("threads/show", compact("thread"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        $this->authorize('update', $thread);
        /*if( ! auth()->user()->can('update', $thread)){
            return back();
        }*/
        return view('threads/edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Thread $thread)
    {
        $this->authorize('update', $thread);
        /*if( ! auth()->user()->can('update', $thread)){
            return back();
        }*/
            
        

        request()->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $thread->update(request()->all());

        return redirect($thread->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $thread->comments()->delete();
        $thread->delete();

        return redirect('/threads');
    }

    public function upvote(Thread $thread)
    {
        $thread->increment('upvote');
        return redirect('/threads');

    }

    public function downvote(Thread $thread)
    {
        $thread->decrement('upvote');
        return redirect('/threads');

    }
}
