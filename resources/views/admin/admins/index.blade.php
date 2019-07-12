@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'label' => __('Admins')
])


<div class="card">
    <div class="card-body">
        <a class="btn btn-primary mb-3" href="{{ adminUrl('/admins/create') }}">
            <i class="fa fa-plus"></i>
            {{ __("Create New Admin") }}
        </a>
        <table id="admins-table" class="table table-bordered table-hover"></table>
    </div>
</div>
@endsection

@include('includes.libs.datatable')

@push('scripts')
<script>
$(document).ready(function(){
    var adminsTable = $('#admins-table').DataTable({
        order: [[ 2, "desc" ]],
        columns: [
            { 
                title: "{{ __('Username') }}",
                data: 'username',
                filter: 'username',
            },
            { 
                title: "{{ __('Type') }}",
                data: 'type',
                filter: 'type',
            },
            {
                title: '{{ __("Created") }}',
                data: 'created_at',
                render: function ( data, type, row, meta ) {
                    return fromNow(data);
                }
            },
            {
                title: 'Actions',
                orderable: false,
                render: function ( data, type, row, meta ) {
                    return '<a class="button-edit" href="{{ adminUrl('/admins') }}/'+row.id+'/edit"><i class="fa fa-edit"></i></a>';
                }
            }
        ],
        createdRow: function( row, data, dataIndex){
            if(data.is_banned){
                $(row).addClass('text-danger');
            }
        },
        ajax: {
            url: '{{ adminUrl("/admins") }}',     
            data: function ( d ) {
                d.order[0].column = d.columns[d.order[0].column].data;
            }       
        }, 
        serverSide: true,
        scrollX: true,
        autoWidth: false,
        pagingType: "full_numbers"
    });

})
</script>
@endpush

