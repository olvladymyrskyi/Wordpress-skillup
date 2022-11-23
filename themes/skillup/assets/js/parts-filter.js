jQuery( function( $ ){
    $( document ).ready(function() {
        $('.filter-item').on('click', function(e){
           e.preventDefault();
           let item = $(e.target);
           let value =item.attr('data-value');
           let el = item.closest('.filter-wrap').find('.filter-holder').val(value);
           let form = $(e.target).closest('form');
console.log(form.serialize());
            $.ajax({
                url : parts_obj.ajaxurl, // обработчик
                data : form.serialize(), // данные
                type : 'POST', // тип запроса
                beforeSend : function( xhr ){
                },
                success : function( data ){
                    $( '#filter-results' ).html(data);
                }
            });
            return false;

        });
    });
});
