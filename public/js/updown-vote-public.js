'use strict';

document.addEventListener('DOMContentLoaded', function() {
    var upvoteButtons = document.querySelectorAll('.udv-upvote');
    var downvoteButtons = document.querySelectorAll('.udv-downvote');

    upvoteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var postId = button.getAttribute('data-postid');
            var _udv_nonce = button.getAttribute("name['_udv_nonce']");
            var udv_upvote = button.getAttribute("name['action']");
            var xhr = new XMLHttpRequest();
            xhr.open('POST', udv_ajax.ajax_url, true);
// Set header so the called script knows that it's an XMLHttpRequest
xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send('action=udv_upvote&_udv_nonce=' + 
                encodeURIComponent(postId) + '&post_id=' 
                + encodeURIComponent(_udv_nonce));
        });
    });

    downvoteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var postId = button.getAttribute('data-postid');
            var _udv_nonce = button.getAttribute("name['_udv_nonce']");
            var udv_downvote = button.getAttribute("name['action']");
            var xhr = new XMLHttpRequest();
            xhr.open('POST', udv_ajax.ajax_url, true);
// Set header so the called script knows that it's an XMLHttpRequest
xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send('action=udv_downvote&_udv_nonce=' + 
                encodeURIComponent(postId) + '&post_id=' 
                + encodeURIComponent(_udv_nonce));
        });
    });
});
