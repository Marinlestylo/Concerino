$(() => {
    $(".sorted-table").tablesorter();
    $('.datepicker').datepicker({
        altFormat: 'yy-mm-dd',
        altField: '#hiddenDate'
    });
});