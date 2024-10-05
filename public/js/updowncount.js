/* up down vote for dad jokes */
'use strict';
  (function($){
    $(function(){
    jQuery(document).ready(function($) {
        
        $('.udv-upvote').click(function() {
            var postId = $(this).data('postid');
            $.post(udv_ajax.ajax_url, { 
                action: 'udv_upvote', 
                post_id: postId }, 
            function(response) {
                location.reload();
            });
        });
        $('.udv-downvote').click(function() {
            var postId = $(this).data('postid');
            $.post(udv_ajax.ajax_url, { 
                action: 'udv_downvote', 
                post_id: postId 
            }, 
            function(response) {
                location.reload();
            });
        });
      
    });
  });
})(jQuery);