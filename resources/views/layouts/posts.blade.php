@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            @yield('posts')
        </div>
        <div class="col-md-3">
            <form action="{{ url('/posts') }}" method="GET">
                <div class="input-group mb-3 shadow-lg">
                    <input type="hidden" name="tagId" value="{{ request()->input('tagId') }}">
                    <input value="{{ request()->input('keyword') }}" type="text" name="keyword" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            @foreach (\App\Tag::whereHas('posts', function($query){
                $query->whereNotNull('published_at');
            })->orderBy('name', 'ASC')->get() as $item)
                @if ($item->id == request()->input('tagId'))
                <span href="{{ url('/posts?tagId='. $item->id) }}" 
                    class="btn btn-primary btn-sm mb-1 shadow-lg">
                    {{ $item->name }}
                    
                    <a href="{{ url('/posts?keyword='. request()->input('keyword')) }}">
                        <i class="fa fa-times text-dark"></i>
                    </a>
                </span>
                @else
                <a href="{{ url('/posts?keyword='.request()->input('keyword').'&tagId='. $item->id) }}" 
                    class="mb-1 btn btn-secondary btn-sm shadow-sm">
                    {{ $item->name }}
                </a>
                @endif
            @endforeach

            @isset($post)
                @php
                    $tagIds = $post->tags->pluck('id');

                    $posts = \App\Post::whereNotNull('published_at')
                        ->where('id', '!=', $post->id)
                        ->inRandomOrder()
                        ->limit(10);

                    if(count($tagIds)){
                        $posts = $posts->whereHas('tags', function($query) use($tagIds){
                            $query->whereIn('id', $tagIds);
                        });
                    }

                    $posts = $posts->get();

                    if(!$post->count()){
                        $posts = \App\Post::whereNotNull('published_at')
                            ->where('id', '!=', $post->id)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
                    }
                    
                @endphp

                @if ($posts->count())
                    <div class="list-group shadow-lg mt-3">
                        @foreach ($posts  as $item)
                            <a href="{{ url('/posts/' . $item->id . '/' . $item->slug) }}" class="list-group-item list-group-item-action">
                                <small>
                                    <i class="fas fa-newspaper"></i>
                                    {{ $item->title }}
                                </small>
                            </a>
                        @endforeach
                    </div>
                @endif

               
            @endisset

            <button style="display:none; position: fixed;bottom: 10px;" class="animated slideInUp btn btn-light shadow-lg" type="button" onclick="scrollToTop()" id="#scroll-to-top" title="Go to top">
                <i class="fa fa-chevron-up"></i>
                {{ __("Back to top") }}
            </button>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function(){
    
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.documentElement.scrollTop > 400) {
            document.getElementById("#scroll-to-top").style.display = "block";
        } else {
            document.getElementById("#scroll-to-top").style.display = "none";
        }
    }

});
</script>
@endpush