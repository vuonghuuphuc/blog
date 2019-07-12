@foreach ($post->tags()->orderBy('name', 'ASC')->get() as $item)
    <a href="{{ url('/posts?keyword='.request()->input('keyword').'&tagId='. $item->id) }}" 
        class="mb-1 badge {{ $item->id == request()->input('tagId') ? 'badge-primary' : 'badge-secondary' }}">{{ $item->name }}</a>
@endforeach