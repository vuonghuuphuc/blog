@extends('layouts.posts')

@section('posts')

@each('posts.card', $posts, 'post', 'posts.empty')

<div class="text-center">
    {{ $posts->appends([
        'keyword' => request()->input('keyword') ?? null,
        'tagId' => request()->input('tagId') ?? null,
    ])->links() }}
</div>
@endsection


@include('includes.libs.facebook_sdk')