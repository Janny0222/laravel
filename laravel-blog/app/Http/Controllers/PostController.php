<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
  
    public function create(){
        if(Auth::user()){
        return view('posts.create');
    } else {
        return redirect('login');
    }
    }


    public function store(Request $request){
        if(Auth::user()){
            $post = new Post;
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->user_id = (Auth::user()->id);
            $post->save();

            return redirect('/posts');
        } else {
            return redirect('login');
        }
    }

    public function index(){
    if(Auth::user()){
        $posts = Post::where('isActive', true)->get();
        return view('posts.index')->with('posts',$posts);
    }else{
        return redirect('login');
    }
    }

    public function welcome(){
        $posts = Post::inRandomOrder()->where('isActive', true)->limit(3)->get();
        return view('welcome')->with('posts', $posts);
    }

    public function myPosts(){
        if(Auth::user()){
            $posts = Auth::user()->posts;
            return view('posts.index')->with('posts',$posts);
        }else{
            return redirect('login');
        }
    }

    public function show($id){
        $post = Post::with('comments.user')->find($id);

        return view('posts.show', compact('post'));
    }

    public function edit($id){
        if(Auth::user()){
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
        }else{
            return redirect('login');
        }
    }

    public function update(Request $request, $id){

        $post = Post::find($id);
        if(Auth::user()->id == $post->user_id){
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        
        return redirect('posts')->with('status', 'Post updated successfully!');
        }else{
            return redirect('login');
        }
    }

    public function archive($id){

        $post = Post::find($id);
        if(Auth::user()->id == $post->user_id){
        $post->isActive = false;
        $post->save();
        return redirect('posts')->with('status', 'Post archived successfully!');
        }else{
            return redirect('login');
        }
    }

    public function activate($id){
        $post = Post::find($id);
        if(Auth::user()->id == $post->user_id){
        $post->isActive = true;
        $post->save();
        return redirect('posts')->with('status', 'Post activate successfully!');
        }else{
            return redirect('login');
        }
    }

    public function like($id){
        $post = Post::find($id);
        $user_id = Auth::user()->id;
        if($post->user_id != $user_id){
            if($post->likes->contains("user_id", $user_id)){
                PostLike::where('post_id', $post->id)->where('user_id', $user_id)->delete();
            }else{
                $postLike = new PostLike;
                $postLike->post_id = $post->id;
                $postLike->user_id = $user_id;

                $postLike->save();
            }
            return redirect("/posts/$id");
        }
    }

    public function comment(Request $request, $id){
        $post = Post::find($id);
        $user_id = Auth::user()->id;
        if(Auth::user()){
        $postComment = new PostComment;
        $postComment->user_id = $user_id;
        $postComment->post_id = $post->id;
        $postComment->content = $request->input('content');

        $postComment->save();
        return redirect("/posts/$id")->with('comment', 'Leave a comment successfully');
        }else {
            return redirect('login');
        }
    }
}
