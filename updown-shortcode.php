
// Shortcode to display up and down vote buttons
function udv_display_votes($atts) {
    $atts = shortcode_atts(array(
        'id' => 0,
    ), $atts);
    $post_id = intval($atts['id']);
    $up_votes = get_post_meta($post_id, 'up_vote', true) ?: 0;
    $down_votes = get_post_meta($post_id, 'down_vote', true) ?: 0;

    ob_start();
    ?>
    <div class="udv-votes">
        <button class="udv-upvote" data-postid="<?php echo $post_id; ?>"><i></i> <span><?php echo $up_votes; ?></span></button>
        <button class="udv-downvote" data-postid="<?php echo $post_id; ?>"><i></i> <span><?php echo $down_votes; ?></span></button>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.udv-upvote').click(function() {
                var postId = $(this).data('postid');
                $.post(udv_ajax.ajax_url, { action: 'udv_upvote', post_id: postId }, function(response) {
                    location.reload();
                });
            });
            $('.udv-downvote').click(function() {
                var postId = $(this).data('postid');
                $.post(udv_ajax.ajax_url, { action: 'udv_downvote', post_id: postId }, function(response) {
                    location.reload();
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('updownvote', 'udv_display_votes');

// AJAX handler for upvote
function udv_upvote() {
    $post_id = intval($_POST['post_id']);
    $current_votes = get_post_meta($post_id, 'up_vote', true) ?: 0;
    update_post_meta($post_id, 'up_vote', $current_votes + 1);
    wp_die();
}
add_action('wp_ajax_udv_upvote', 'udv_upvote');

// AJAX handler for downvote
function udv_downvote() {
    $post_id = intval($_POST['post_id']);
    $current_votes = get_post_meta($post_id, 'down_vote', true) ?: 0;
    update_post_meta($post_id, 'down_vote', $current_votes + 1);
    wp_die();
}
add_action('wp_ajax_udv_downvote', 'udv_downvote');
