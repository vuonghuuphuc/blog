@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'label' => __('Users')
])


<div class="card shadow-lg">
    <div class="card-body">
        <a class="btn btn-dark mb-3" href="{{ adminUrl('/users/create') }}">
            <i class="fa fa-plus"></i>
            {{ __("Create New User") }}
        </a>
        <table id="users-table" class="table table-bordered table-hover"></table>
    </div>
</div>
@endsection

@include('includes.libs.datatable')

@push('scripts')
<script>
$(document).ready(function(){
    var usersTable = $('#users-table').DataTable({
        order: [[ 0, "desc" ]],
        columns: [
            {
                title: '{{ __("Created") }}',
                data: 'created_at',
                render: function ( data, type, row, meta ) {
                    return dateFormat(data);
                }
            },
            { 
                title: "{{ __('First Name') }}",
                data: 'first_name',
                filter: 'first_name',
            },
            { 
                title: "{{ __('Last Name') }}",
                data: 'last_name',
            },
            { 
                title: "{{ __('E-Mail Address') }}",
                data: 'email',
            },
            { 
                title: "{{ __('Type') }}",
                data: 'type',
            },
            { 
                title: "{{ __('Posts') }}",
                data: 'posts_count',
                filter: 'posts_count',
            },
            { 
                title: "{{ __('Social') }}",
                orderable: false,
                data: 'facebook_id',
                render: function ( data, type, row, meta ) {
                    var result = '';
                    if(row.facebook_id){
                        result += '<i class="fab fa-facebook text-primary"></i>';
                    }
                    if(row.google_id){
                        result += ' <i class="fab fa-google text-danger"></i>';
                    }

                    return result;
                }
            },
            
            {
                title: '{{ __("Verified") }}',
                data: 'email_verified_at',
                render: function ( data, type, row, meta ) {
                    if(data){
                        return dateFormat(data);
                    }
                    return '';
                }
            },
            {
                title: '{{ __("Actions") }}',
                orderable: false,
                render: function ( data, type, row, meta ) {
                    return '<a class="button-edit" href="{{ adminUrl('/users') }}/'+row.id+'/edit"><i class="fa fa-edit"></i></a>';
                }
            }
        ],
        createdRow: function( row, data, dataIndex){
            if(data.is_banned){
                $(row).addClass('text-danger');
            }
        },
        ajax: {
            url: '{{ adminUrl("/users") }}',     
            data: function ( d ) {
                d.order[0].column = d.columns[d.order[0].column].data;
            }       
        }, 
        
    });

})
</script>
@endpush

