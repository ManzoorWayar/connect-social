function following(button, reciverId) {
    $.post('../ajax/follow.ajax.php', {reciverId: reciverId})
    .done(function(res) {
      
       $(button).toggleClass("FOLLOW FOLLOWING");
       let followClass = $(button).hasClass("FOLLOW") ? "FOLLOW" : "FOLLOWING";
       $(button).text(followClass);
 
    }); 
 }