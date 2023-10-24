@extends ('layouts.app')

@section ('content')

    @if(Auth::user()->id == $post->user_id)
    <form action="/posts/{{$post->id}}" method="POST" class="px-5">
        @csrf
        @method('PUT')
        
        <div class="border rounded p-2">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="{{$post->title}}">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" name="content" id="content" rows="3">{{$post->content}}</textarea>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Update Post</button>
            </div>
        </div>
    </form>
    @endif

@endsection