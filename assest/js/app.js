    // Creating Post card photo file {Toggle}
    $('#togglePhoto').click(function () {
        $('#photo_preview_box').slideToggle(300);
    });

    $(document).on("keyup", "#postText", function (e) {
        e.preventDefault();
        let textbox = $(e.target);
        let value = textbox.val().trim();
        let imgValue = $("#file-post-img").val();
       
        // let isReplyModal = textbox.parents(".reply-wrapper").length == 1;

        // let submitButton = isReplyModal ? $("#replyBtn") : $("#addBtn");
        let submitButton = $("#addBtn");

        if (value == "") {
            submitButton.prop("disabled", true);
            return;
        } 
        // else if(value.length >= 200){
        //     submitButton.prop("disabled",true);
        //     return;
        // }

        submitButton.prop("disabled", false);

    });



   