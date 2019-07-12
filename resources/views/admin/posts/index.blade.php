@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'label' => __('Posts')
])


<div class="card shadow-lg">
    <div class="card-body">
        <a class="btn btn-dark mb-3" href="{{ adminUrl('/posts/create') }}">
            <i class="fa fa-plus"></i>
            {{ __("Create New Post") }}
        </a>
        <table id="posts-table" class="table table-bordered table-hover"></table>
    </div>
</div>
@endsection

@include('includes.libs.datatable')

@push('scripts')

<script>
$(document).ready(function(){
    var postsTable = $('#posts-table').DataTable({
        order: [[ 2, "desc" ]],
        columns: [
            { 
                title: "{{ __('Title') }}",
                data: 'title',
                filter: 'title',
            },
            { 
                title: "{{ __('User') }}",
                orderable: false,
                render: function ( data, type, row, meta ) {
                    return row.user.email;
                }
            },
            {
                title: '{{ __('Created') }}',
                data: 'created_at',
                render: function ( data, type, row, meta ) {
                    return dateFormat(data);
                }
            },
            {
                title: '{{ __('Published') }}',
                data: 'published_at',
                render: function ( data, type, row, meta ) {
                    if(data){
                        return dateFormat(data);
                    }
                    return '';
                }
            },
            { 
                title: "{{ __('Views') }}",
                data: 'views',
                filter: 'views',
            },
            {
                title: 'Actions',
                orderable: false,
                render: function ( data, type, row, meta ) {
                    var html = '<a class="button-edit" href="{{ adminUrl('/posts') }}/'+row.id+'/edit"><i class="fa fa-edit"></i></a>';
                    if(row.published_at){
                        html += ' <a target="_blank" class="ml-3" href="{{ url('/posts') }}/'+row.id+'/'+row.slug+'"><i class="fa fa-link"></i></a>';
                    }
                    return html;
                }
            }
        ],
        createdRow: function( row, data, dataIndex){
            if(!data.published_at){
                $(row).addClass('text-muted');
            }
        },
        ajax: {
            url: '{{ adminUrl("/posts") }}',     
            data: function ( d ) {
                d.order[0].column = d.columns[d.order[0].column].data;
            }       
        }, 
        
    });


})
</script>

@endpush
