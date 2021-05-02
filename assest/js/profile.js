// Cover photo file image
$(function coverPhoto() {
  $('.coveruploadBtn').click(function () {
    $('#saveBtn').css({
      "display": "block"
    });
    $('#cancelBtn').css({
      "display": "block"
    });
  });
});

// Profile photo file image
$(function profilePhoto() {
  $('.profileUploadBtn').click(function () {
    $('#profileSaveBtn').css({
      "display": "block"
    });
  });
});