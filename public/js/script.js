$(document).ready(function() {
    //
    $('#new').click(function () {
        var list = $(this).data('list');
        $.ajax({
            url: '/member/task/create/' + list,
            //data: $(this).serialize(),
            method: 'GET',
            success: function(data) {
                $('.modal-body').html(data);
                $('.modal').modal('show');
                $('form').submit(function(event) {
                    $.ajax({
                        url: '/member/task/create/' + list,
                        data: $('form').serialize(),
                        method: 'POST',
                        success: function (data) {
                            var i = $("#index").text() + 1;
                            $('tbody').append(data);
                            $('.modal').modal('hide');
                        },
                    });
                    event.preventDefault();
                });
            },
        });
    });

    $('#delete').click(function () {
        $.ajax({
            url: '/member/task/delete/' + $(this).data('id'),
            //data: $(this).serialize(),
            method: 'GET',
            success: function (data) {
                //TODO
            },
        });
    });
});