$(document).ready(function() {

    $('.modal-body').on('submit', 'form', function (event) {
        let url, id;
        let action = $(this).data('action');
        switch (action) {
            case 'edit':
                let edit = $('#edit');
                url = edit.data('target');
                id = edit.data('id');
                break;
            case 'details':
                let details = $('#details');
                url = details.data('target');
                id = details.data('id');
                break;
            case 'create':
                let n_new = $('#new');
                url = n_new.data('target');
                id = n_new.data('id');
        }
        $.ajax(
            {
                url: url,
                data: $('form').serialize(),
                method: 'POST',
                success: function (data) {
                    if(data.includes( "form" ))
                    {
                        //$('.modal-body form').replaceWith(data)
                        $('.modal-body').html(data);
                    }else {
                        if(action === 'edit')
                        {
                            $('#' + id).replaceWith(data)
                        }else if(action === 'create')
                        {
                            $('tbody').append(data);
                            hiddeNo();
                        }
                        $('.modal').modal('hide');
                    }
                },
            });
        event.preventDefault();
    });
    //
    $('tfoot').on('click', '#new', function (event) {

        $.ajax({
            url: $(this).data('target'),
            //data: $(this).serialize(),
            method: 'GET',
            success: function(data) {
                $('.modal-body').html(data);
                $('.modal').modal('show');
                //handleForm(url);
            },
        });
        event.preventDefault();
    });
    function isJSON(val){
        var str = val.replace(/\\./g, '@').replace(/"[^"\\\n\r]*"/g, '');
        return (/^[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]*$/).test(str);
    }
    function hiddeNo(){
        const no = $('#no');
        if ($('tbody tr').length > 0 ) {
            no.addClass('d-none');
        }else{
            no.removeClass('d-none')
        }
    }
    $('tbody').on('click', '.action',function (event) {
        let id = this.id;
        let task_id = $(this).data('id');
        $.ajax({
            url: $(this).data('target'),
            method: 'GET',
            success: function (data) {
                if (id === 'delete'){
                    if( data['res'] === true){
                        $(`#${task_id}`).addClass('d-none');
                        hiddeNo();
                    }
                }else if(id === 'edit'){
                    $('.modal-body').html(data);
                    $('.modal').modal('show');
                    $('.modal-title').text("Edit your task");
                }else if(id === 'details'){
                    $('.modal-body').html(data);
                    $('.modal').modal('show');
                    $('.modal-title').text("Your task" + $('#' + task_id).find('td:first-child').text());
                }
            },
        });
    });
});