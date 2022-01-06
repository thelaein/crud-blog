<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::when(isset(request()->search),function ($query){
            $keyword = request()->search;
            $query->orWhere('title','like','%'.$keyword.'%')->orWhere('description','like',"%$keyword%");
        })->with(['user','category','photos'])->latest('id')->paginate(7);
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create',Post::class);

        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        if (!Storage::exists('public/thumbnail')){
            Storage::makeDirectory('public/thumbnail');
        }
//       return $request;

        $post= new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category;
        $post->description  = $request->description;
        $post->excerpt  = Str::words($request->description);
        $post->user_id = Auth::id();
        $post->isPublish = '1';
        $post->save();

        //hasFile?
        if ($request->hasFile('photo')){
            foreach ($request->file('photo') as $photo){
                $newName = uniqid()."_photo.".$photo->extension();
                $photo->storeAs('public/photo',$newName);

                //intervention image
                $img = Image::make($photo);
                $img->fit(200,200);
                $img->save('storage/thumbnail/'.$newName,100);



                $photo = new Photo();
                $photo->name = $newName;
                $photo->post_id = $post->id;
                $photo->user_id = Auth::id();
                $photo->save();
            }
        }

        //return $request;

        return redirect()->route('post.index')->with('status','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        Gate::authorize('view',$post);

        //! allows = demine
//        if (! Gate::allows('post-edit',$post)){
//            return abort(403);
//        }

        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('view',$post);

        $request->validate([
            'title'=>'required|min:3|unique:posts,title,'.$post->id,
            'category'=>'required|exists:categories,id',
            'description'=>'required|min:10'
        ]);
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category;
        $post->description  = $request->description;
        $post->excerpt  = Str::words($request->description);
        $post->update();
        return redirect()->route('post.index')->with('status','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Gate::authorize('view',$post);

//        return $post;

        //delete photo files
        foreach ($post->photos as $photo){
            Storage::delete('public/photo/'.$photo->name);
            Storage::delete('public/thumbnail/'.$photo->name);
        }

        //delete db records
        $post->photos()->delete();

        //post delete
        $post->delete();

        return redirect()->route('post.index')->with('status','success');

    }
}
