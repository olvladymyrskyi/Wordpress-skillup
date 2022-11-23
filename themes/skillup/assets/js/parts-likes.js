
(function( $ ) {
    $.fn.partsLikes = function( options ) {
        options = $.extend({
            countLike: ".like-count",
            countDislike: ".dislike-count"
        }, options);


        return this.each(function() {
            var $element = $( this ),
                $count = '',
                url = parts_likes.ajaxurl,
                id = $element.data( "id" ),
                action = "parts_likes",
                data = {
                    action: action,
                    status: $element.data( "status" ),
                    post_id: id
                };

            if($element.data( "status" ) == "parts_like"){
                $count = $( options.countLike, $element );
            }else{
                $count = $( options.countDislike, $element );
            }
            $element.on( "click", function( e ) {
                e.preventDefault(data);
                $.getJSON( url, data, function( json ) {
                   let name = 'json.' + $element.data( "status" );

                    if( json && json.count ) {
                        $count.text( json.count );
                    }
                });
            });
        });
    };

})( jQuery );
