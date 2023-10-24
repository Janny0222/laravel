@extends ('layouts.app')

@section ('content')
@if (session('comment'))
    <h6 class="alert alert-success">{{ session('comment') }}</h6>
@endif
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{$post->title}}</h2>
            <p class="card-subtitle text-muted">Author: {{$post->user->name}}</p>
            <p class="card-subtitle text-muted mb-3">Created at: {{$post->created_at}}</p>
            <p class="card-text">{{$post->content}}</p>

            <div class="d-flex">
                <p class="card-subtitle text-muted mb-3">Likes: {{count($post->likes->where("post_id", $post->id))}} | </p>
                
                <p class="card-subtitle text-muted ms-1 mb-3">Comments: {{count($post->comments->where("post_id", $post->id))}}</p>
            </div>

            @if(Auth::user())
                @if(Auth::id() != $post->user_id)
                <form class="d-inline" action="/posts/{{$post->id}}/like" method="POST">
                    @method('PUT')
                    @csrf
                    @if($post->likes->contains("user_id", Auth::id()))
                        <button type="submit" class="btn btn-danger">Unlike</button>
                    @else
                        <button type="submit" class="btn btn-success">Like</button>
                    @endif
                </form>
                @endif
                    <div class="modal" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Leave a Comment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/posts/{{$post->id}}/comment" method="POST">
                                        @method('PUT')
                                        @csrf
                                        Comment:<textarea name="content" class="form-control" rows="3" placeholder="Write your comment here"></textarea>
                                        <br>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Comment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">
                        Comment
                    </button>
            @endif
            <div class="mt3">
                <a href="/posts" class="card-link">View All Posts</a>
            </div>
        </div>
    </div>
    <h3 class="card-title mt-4">Comments</h3>
    <div class="card">
            @if($post->comments->count() > 0)
        <div class="card-body ">
                    @foreach($post->comments as $comment)
                        <h2 class="text-center">{{ $comment->content }}</h2>
                           <div class="text-end"><h6 class="">Posted by: {{ $comment->user->name }}</h6>
                            <small class="text-muted text-center">posted on: {{ $comment->created_at }}</small></div>
                            <hr>
                    @endforeach
        </div>
            @else
                <p>No comments yet.</p>
            @endif
        
    </div>
@endsection