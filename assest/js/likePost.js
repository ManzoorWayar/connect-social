function likePost(button, postId) {
    $.post('../ajax/like.ajax.php', {
            postId: postId
        })
        .done(function (res) {

            let likeButton = $(button);
            likeButton.addClass("like-active");

            let result = JSON.parse(res);
            updateLikesValue(likeButton.find(".like-count"), result.likes);

            if (result.likes < 0) {
                likeButton.removeClass("like-active");
                likeButton.find(".fa-heart").addClass("fa-heart-o");
                likeButton.find(".fa-heart-o").removeClass("fa-heart");

            } else {
                likeButton.addClass("like-active");
                likeButton.find(".fa-heart-o").addClass("fa-heart");
                likeButton.find(".fa-heart").removeClass("fa-heart-o");
            }
        });
}

// updates like/dislike values
function updateLikesValue(element, num) {
    let likesCountVal = element.text() || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));
}