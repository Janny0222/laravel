@extends('layouts.app')

@section('content')
    
    <form action="/posts" method="POST" class="px-5">
        @csrf
        <div class="border rounded p-2">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" name="content" id="content" rows="3"></textarea>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Create Post</button>
            </div>
        </div>
    </form>

@endsection