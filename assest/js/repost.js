function rePost(button, postId) {
    $.post('../ajax/repost.ajax.php', {
            postId: postId
        })
        .done(function (res) {

            let rePostButton = $(button);
            rePostButton.addClass("rePosted");

            let result = JSON.parse(res);
            updateRePostValue(rePostButton.find(".rePost-count"), result.rePosts);

            if (result.rePosts < 0) {
                rePostButton.removeClass("rePosted");
                rePostButton.find(".text-success").addClass("text-info");
                rePostButton.find(".text-info").removeClass("text-success");

            } else {
                rePostButton.addClass("rePosted");
                rePostButton.find(".text-info").addClass("text-success");
                rePostButton.find(".text-success").removeClass("text-info");
            }
        });
}

// Add rePost UI
// $('.rePostBtn').click(function(e) {
//     postID = e.target.parentElement.id;

//     $.post('../ajax/repost.ajax.php', {
//         action: 'rePosting',
//         postId: postID
//     })
//     .done(function (rePostUI) {
//         $('.re-post').html(rePostUI);
//     });
// });    

// updates like/dislike values
function updateRePostValue(element, num) {
    let rePostCountVal = element.text() || 0;
    element.text(parseInt(rePostCountVal) + parseInt(num));
}