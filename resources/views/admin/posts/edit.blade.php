@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'urls' => [
        [
            'label' => __('Posts'),
            'href' => adminUrl('/posts')
        ]
    ],
    'label' => __('Edit Post')
])

<div class="card shadow-lg">
    <div class="card-body">
        <form id="form-edit-post" action="{{ adminUrl('posts/' . $post->id) }}" method="POST">

            @method('PUT')

            @include('includes.form_group_input', [
                'label' => __('Title'),
                'name' => 'title',
                'dataValidation' => 'required',
                'value' => $post->title
            ])

            @include('includes.form_group_tags', [
                'label' => __('Tags'),
                'name' => 'tags[]',
                'value' => $post->getTags(),
            ])

            @include('includes.form_group_textarea', [
                'label' => __('Description'),
                'name' => 'description',
                'rows' => 2,
                'value' => $post->description
            ])



            <div class="form-group">
                <label>Body</label>
                @include('includes.html_editor', [
                    'name' => 'body',
                    'value' => $post->body
                ])
            </div>

            <div class="form-group">
                @include('includes.checkbox', [
                    'label' => __('Must login to view body'),
                    'name' => 'is_required_auth',
                    'checked' => !!$post->is_required_auth
                ])
            </div>

            @if (auth()->user()->can('publish', \App\Post::class))
            <div class="form-group">
                @include('includes.checkbox', [
                    'label' => __('Published'),
                    'name' => 'published',
                    'checked' => !!$post->published_at
                ])
            </div>
            @endif

            
            
            <button class="btn btn-dark" type="submit">
                <i class="fa fa-save"></i>
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection


@push('scripts')

<script>
$(document).ready(function(){
    var form = $('#form-edit-post');
    form.toAjaxAndValidateForm({
        success: function(){
            Swal.fire({
                title: "{{ __('UPDATED') }}",
                text: "{{ __('The post is updated') }}",
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    redirect('{{ adminUrl('/posts') }}');
                }
            });
        }
    });
})
</script>

@endpush
