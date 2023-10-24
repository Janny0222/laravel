@extends('layouts.app')

@section('content')
@if (session('status'))
    <h6 class="alert alert-success">{{ session('status') }}</h6>
@endif
    @foreach ($posts as $post)
        <div class="card text-center">
                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
            <div class="card-body">
                <h4 class="card-title mb-3"><a href="/posts/{{$post->id}}"></a>{{$post->title}}</h4>
                <h6 class="card-text mb-3">Author: {{$post->user->name}}</h6>
                <p class="card-subtitle mb-3 text-muted">Created at: {{$post->created_at}}</p>
            </div>
                    <div class="card-footer">
                        @if(Auth::user()->id == $post->user_id)
                        <form action="/posts/{{$post->id}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit Post</a>
                            @if($post->isActive)
                            <button class="btn btn-danger" type="submit">Archive Post</button>
                            @else
                            <form action="/posts/{{$post->id}}" method="POST">
                                @method('PATCH')
                                @csrf
                            <button class="btn btn-warning" type="submit">Activate Post</button>
                            </form>
                            @endif
                        </form>
                        @endif
                    </div>
        </div>
    @endforeach
@endsection