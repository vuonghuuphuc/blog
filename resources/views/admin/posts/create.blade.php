@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'urls' => [
        [
            'label' => __('Posts'),
            'href' => adminUrl('/posts')
        ]
    ],
    'label' => __('Create New Post')
])

<div class="card shadow-lg">
    <div class="card-body">
        <form id="form-create-post" action="{{ adminUrl('posts') }}" method="POST">
            
            @include('includes.form_group_input', [
                'label' => __('Image Url'),
                'name' => 'image_url',
                'dataValidation' => 'required url'
            ])
            @include('includes.form_group_input', [
                'label' => __('Title'),
                'name' => 'title',
                'dataValidation' => 'required'
            ])

            @include('includes.form_group_tags', [
                'label' => __('Tags'),
                'name' => 'tags[]',
            ])


            @include('includes.form_group_input', [
                'label' => __('Keywords'),
                'name' => 'keywords',
            ])

            @include('includes.form_group_textarea', [
                'label' => __('Description'),
                'name' => 'description',
                'rows' => 2,
                'dataValidation' => 'required'
            ])

            <div class="form-group">
                <label>Body</label>
                @include('includes.html_editor', [
                    'name' => 'body'
                ])
            </div>

            <div class="form-group">
                @include('includes.checkbox', [
                    'label' => __('Must login to view body'),
                    'name' => 'is_required_auth',
                ])
            </div>

            @if (auth()->user()->can('publish', \App\Post::class))
            <div class="form-group">
                @include('includes.checkbox', [
                    'label' => __('Published'),
                    'name' => 'published',
                ])
            </div>
            @endif


           
            
            <button class="btn btn-dark" type="submit">
                <i class="fa fa-plus"></i>
                Create New Post
            </button>
        </form>
    </div>
</div>
@endsection



@push('scripts')

<script>
$(document).ready(function(){
    var form = $('#form-create-post');
    form.toAjaxAndValidateForm({
        success: function(){
            Swal.fire({
                title: 'CREATED',
                text: 'New post is created',
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
