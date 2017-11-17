$(document).ready(function() {
    var ticket_id = null;

    var table = $('#tickets').DataTable( {
        rowId: "id",
        lengthChange: false,
        ajax: "/tickets",
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "created" },
            { data: "updated" },
            { data: "priority" },
            { data: "status" },
            { data: "project_name" },
            { data: "edit" }
        ],
        initComplete: function( settings, json ) {
            makeFilter();
        },
        select: false,
        searching: true,
    });

    function makeFilter() {
        $("#tickets tfoot th").each(function (i) {
            if($(this).text()=='Priority' || $(this).text()=='Status' || $(this).text()=='Project') {
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(this).empty())
                    .on('change', function () {
                        table.column(i)
                            .search($(this).val())
                            .draw();
                    });
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            } else {
                $(this).text('');
            }
        });
    }

    $('#editTicket').on('hidden.bs.modal', function (e) {
        $(this).removeData('bs.modal');
    })
});
