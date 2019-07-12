@push('styles')
@style('//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css')
@endpush


@push('scripts')
@script('//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js')
@script('//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js')
<script>
$(document).ready(function(){
    $.extend($.fn.dataTable.defaults, {
        responsive: true,
        scrollX: true,
        autoWidth: false,
        pagingType: "full_numbers",
        language: {
            "decimal":        "",
            //"emptyTable":     "{{ __('No data available in table') }}",
            "emptyTable":     "{{ __('No results found') }}",
            //"info":           "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
            "info":           "{{ __('_TOTAL_ items') }}",
            //"infoEmpty":      "{{ __('Showing 0 to 0 of 0 entries') }}",
            "infoEmpty":      "",
            "infoFiltered":   "{{ __('(filtered from _MAX_ total entries)') }}",
            "infoPostFix":    "",
            "thousands":      ",",
            //"lengthMenu":     "{{ __('Show _MENU_ entries') }}",
            "lengthMenu":     "{{ __('_MENU_ items per page') }}",
            "loadingRecords": "{{ __('Loading...') }}",
            "processing":     "{{ __('Processing...') }}",
            "search":         "{{ __('Search') }}:",
            "zeroRecords":    "{{ __('No matching records found') }}",
            "paginate": {
                "first":      "{{ __('First') }}",
                "last":       "{{ __('Last') }}",
                "next":       "{{ __('Next') }}",
                "previous":   "{{ __('Previous') }}"
            },
            "aria": {
                "sortAscending":  ": {{ __('activate to sort column ascending') }}",
                "sortDescending": ": {{ __('activate to sort column descending') }}"
            }
        },
        serverSide: true
    });
});
</script>
@endpush