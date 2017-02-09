$(function () {

    //$.tablesorter.addParser({
    //    id: 'getDate',
    //    is: function (sort) { return false },
    //    format: function (sort, table, cell, cellIndex) { return $(cell).attr('data-date'); },
    //    type:'text'
    //})

    $('.first-row').addClass('headerSortDown');
    $('.admin-table th').on('click', function () {
        $('.first-row').removeClass('headerSortDown');
    });
    $('table.admin-table').tablesorter();

})