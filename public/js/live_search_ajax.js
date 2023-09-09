const searchOrder = document.getElementById('searchOrder');


    searchOrder.addEventListener('keyup', function()
    {
        var query=$(this).val();
        $.ajax({
            url:"find",
            type:"GET",
            data:{'query':query},
            success:function (data){
                $('#userList').html(data);
            }
        })
    });

    $('body').on('click', 'li', function(){
        var value = $(this).text();
    })