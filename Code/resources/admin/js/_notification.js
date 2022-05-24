jQuery(function($){
    "use strict"
    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('div[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('.notification-icon');
    var notificationsCount     = parseInt(notificationsCountElem.html());
    var notifications          = notificationsWrapper.find('ul.dropdown-list-items');


    $(document).on("click",".markAsRead",function(e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $(this).data('id');
        var url = $(this).attr('href');
        $.ajax({
            url: superio.markAsRead,
            data: {'id' : id },
            method: "post",
            success:function (res) {
                window.location.href = url;
            }
        })
    });

    $(document).on("click",".markAllAsRead",function(e) {
        e.stopPropagation();
        e.preventDefault();
        $.ajax({
            url: superio.markAllAsRead,
            method: "post",
            success:function (res) {
                $('.dropdown-notifications').find('li.notification').removeClass('active');
                notificationsCountElem.text(0);
                notificationsWrapper.find('.notif-count').text(0);
            }
        })
    });

    if(superio.pusher_api_key && superio.pusher_cluster){
        var pusher = new Pusher(superio.pusher_api_key, {
            encrypted: true,
            cluster: superio.pusher_cluster
        });
    }

    var callback = function(data) {
        var existingNotifications = notifications.html();
        var newNotificationHtml = '<li class="notification active">'
            +'<div class="media">'
            +'    <div class="media-left">'
            +'      <div class="media-object">'
            +  data.avatar
            +'      </div>'
            +'    </div>'
            +'    <div class="media-body">'
            +'      <a class="markAsRead" data-id="'+data.idNotification+'" href="'+data.link+'">'+data.message+'</a>'
            +'      <div class="notification-meta">'
            +'        <small class="timestamp">about a few seconds ago</small>'
            +'      </div>'
            +'    </div>'
            +'  </div>'
            +'</li>';
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.text(notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
    };

    if(superio.isAdmin > 0 && superio.pusher_api_key){
        var channel = pusher.subscribe('admin-channel');
        channel.bind('App\\Events\\PusherNotificationAdminEvent', callback);
    }

    if(superio.currentUser > 0 && superio.pusher_api_key){
        var channelPrivate = pusher.subscribe('user-channel-'+superio.currentUser);
        channelPrivate.bind('App\\Events\\PusherNotificationPrivateEvent', callback);
    }






});
