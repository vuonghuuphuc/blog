<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white shadow-lg">
        @isset($urls)
        @foreach ($urls as $url)
        <li class="breadcrumb-item"><a href="{{ $url['href'] }}">{{ $url['label'] }}</a></li>    
        @endforeach    
        @endisset
        @isset($label)
        <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>    
        @endisset
    </ol>
</nav>
      