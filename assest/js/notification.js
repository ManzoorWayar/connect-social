setInterval(() => {
    NotificationsCount();
}, 1000);

$('.notiBtn').click(function () {
    updateNotification();
});

function NotificationsCount() {
    $.ajax({
        url: '../ajax/notifications.ajax.php',
        type: 'POST',
        data: {
            action: 'notifictionCount'
        },
        success: function (count) {
            let notiCount = JSON.parse(count);

            let noti = $('#noti-text-count').find('.noti-badge');
            noti.text(notiCount);
            // $('#noti-alert')[0].play();
        }
    });
}

function updateNotification() {
    $.ajax({
        url: '../ajax/notifications.ajax.php',
        type: 'POST',
        data: {
            action: 'updateNoti'
        },
        success: function (count) {
            let notiCount = JSON.parse(count);

            let noti = $('#noti-text-count').find('.noti-badge');
            noti.text(parseInt(notiCount.notification));
        }
    });
}


$('#noti_Button').click(function () {
  // TOGGLE (SHOW OR HIDE) NOTIFICATION WINDOW.
  $('#notifications').fadeToggle('fast', 'linear', function () {
      $('#notifications').is(':hidden');
  });
  return false;
});

// HIDE NOTIFICATIONS WHEN CLICKED ANYWHERE ON THE PAGE.
$(document).click(function () {
  $('#notifications').hide();

//   // CHECK IF NOTIFICATIaON COUNTER IS HIDDEN.
//   if ($('#noti_Counter').is(':hidden')) {
//       // CHANGE BACKGROUND COLOR OF THE BUTTON.
//       $('#noti_Button').css('background-color', '#2E467C');
//   }
});
