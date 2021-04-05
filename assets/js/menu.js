$( document ).ready(function() {

    $('.modal-button-add-to-cart').on('click',function(){

    });

    $('.sub-product-side-dishes-modal').on('click',function(){
        var data_id=$(this).attr('data-id');
        $('.modal-on-modal .modal-content').css('top',$(this).position().top-150+'px')
        $('#'+data_id).modal('show');




    });

    $('.product form').on('submit',function(event){
        var dish= $(this);
        $.ajax({
            type: "POST",
            url:$(this).attr('action'),
            data:$(this).serialize(),
            success: function (data) {
                $('.modal').modal('hide');
                $('.product-cart-block').empty();
                $('.product-cart-block').html(data);
            },
            error:function(error){

            }
        });


        event.preventDefault();
    });





});
