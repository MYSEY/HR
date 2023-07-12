$(function(){
    $('#date-range-picker').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 last days': [moment().subtract(6, 'days'), moment()],
            '30 last days': [moment().subtract(29, 'days'), moment()],
            'This month': [moment().startOf('month'), moment().endOf('month')],
            'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
        },
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        },
        function(start, end, label) {
            var s = moment(start.toISOString());
            var e = moment(end.toISOString());
            startdate = s.format("DD-MM-YYYY");
            enddate = e.format("DD-MM-YYYY");
        }
    });
    $('#date-range-picker').on('apply.daterangepicker', function(ev, picker) {
        fromDateCusInfo = picker.startDate.format('YYYY-MM-DD');
        toDateCusInfo = picker.endDate.format('YYYY-MM-DD');
        $('#datatable-filters').find('table').DataTable().ajax.reload();
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
            'DD/MM/YYYY'));
    });
    $('#date-range-picker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        fromDateCusInfo = null;
        toDateCusInfo = null;
        $('#datatable-filters').find('table').DataTable().ajax.reload();
    });
});