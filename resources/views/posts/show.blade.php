@extends('layouts.posts')

@section('title')
{{ $post->title }}
@endsection

@section('posts')
<div class="card mb-3 shadow-lg">
    <div class="row no-gutters">
        <div class="col-md-12" style="-webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
        filter: grayscale(100%);min-height: 180px; background: url({{ $post->image_url }}) no-repeat center center; background-size: cover;">
            
        </div>
        <div class="col-md-12">
            <div class="card-body">
                <small class="text-muted" style="float: right">
                    <i class="fa fa-calendar-alt"></i>
                    {{ $post->created_at->isoFormat('d MMM Y') }}
                </small>
                <h4 class="card-title"><strong>{{ $post->title }}</strong></h4>
                <div style="clear: both"></div>
                <p class="card-text">
                    @include('posts.tags', [
                        'post' => $post
                    ])
                </p>
                <p class="card-text text-muted">{{ $post->description }}</p>

                <div class="form-group">
                    @include('includes.facebook_share', [
                        'url' => url()->current()
                    ])

                    @if (auth()->check())
                    @if (auth()->user()->can('update', $post))
                    <a style="float: right" target="_blank" href="{{ adminUrl('/posts/' . $post->id . '/edit') }}"
                        class="btn btn-secondary">
                        <i class="fa fa-edit"></i>
                        {{ __('Edit') }}
                    </a>
                    @endif
                    @endif
                    <div style="clear: both"></div>
                </div>

                <p class="card-text">{!! $post->body !!}</p>

                @include('includes.facebook_comment')
                
            </div>
        </div>
    </div>
</div>
@endsection

@include('includes.libs.prism')
@include('includes.libs.facebook_sdk')

@push('metas')
<meta name="description" content="{{ $post->description }}" />
@if ($post->keywords)
<meta name="keywords" content="{{ $post->keywords }}">    
@endif
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $post->title }}" />
<meta property="og:description" content="{{ $post->description }}" />
<meta property="og:image" content="{{ $post->image_url }}" />
@endpush