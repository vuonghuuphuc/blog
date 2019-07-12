<div class="card mb-4 shadow-lg">
    <div class="row no-gutters">
        <a href="{{ url('/posts/' . $post->id . '/' . $post->slug) }}" class="col-md-3"
            style="-webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
            filter: grayscale(100%);min-height: 180px; background: url({{ $post->image_url }}) no-repeat center center; background-size: cover;">
        </a>
        <div class="col-md-9">
            <div class="card-body">
                <small class="text-muted" style="float: right">
                    <i class="fa fa-calendar-alt"></i>
                    {{ $post->created_at->isoFormat('d MMM Y') }}
                </small>
                <h4 class="card-title">
                    <a href="{{ url('/posts/' . $post->id . '/' . $post->slug) }}" class="text-dark">
                        <strong>{{ $post->title }}</strong>
                    </a>
                </h4>
                <div style="clear: both"></div>
                <p class="card-text">
                    @include('posts.tags', [
                        'post' => $post
                    ])
                </p>
                <p class="card-text text-muted">{{ $post->description }}</p>
                <div>
                    <div style="float: left">
                        @include('includes.facebook_share', [
                            'url' => url('/posts/' . $post->id . '/' . $post->slug)
                        ])
                    </div>
                    <a style="float: right" href="{{ url('/posts/' . $post->id . '/' . $post->slug) }}"
                        class="btn btn-link">
                        <i class="fa fa-chevron-right"></i>
                        {{ __('Read more') }}
                    </a>
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
            </div>
        </div>
    </div>
</div>