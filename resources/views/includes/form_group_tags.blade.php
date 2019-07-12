@php ($id = htmlId())
<div class="form-group">
    @if (isset($label))
    <label for="{{ $id }}">{{ $label }}</label>
    @endif
    <select 
        style="width: 100%" 
        id="{{ $id }}" 
        name="{{ $name ?? 'tags[]' }}" 
        class="form-control"></select>
</div>


@include('includes.libs.select2')

@push('scripts')
<script>
$(document).ready(function(){
    var value = @json($value ?? []);
    var data = @json(\App\Tag::orderBy('name', 'ASC')->get()->pluck('name') ?? []);
    $('#{{ $id }}').select2({
        multiple: true,
        tags: true,
        data: data,
    });
    $('#{{ $id }}').val(value).change();
});
</script>
@endpush