require('./bootstrap');

import Echo from "laravel-echo"

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});


window.Echo.join('online')
    .here((users) => {
        let userId = $('meta[name=user-id]').attr('content');
        users.forEach(function (user) {
            if (user.id == userId) {
                return;
            }
            $('#online-users').append(`<li id="user-${user.id}">${user.name}</li>`);
        });
        console.log(users);
    })
    .joining((user) => {
        $('#online-users').append(`<li id="user-${user.id}">${user.name}</li>`);
        console.log(user.name);
    })
    .leaving((user) => {
        $('#user-' + user.id).remove();
        console.log(user.name);
    });


$('#chat-text').keypress(function (e) {
    if (e.which == 13) {
        e.preventDefault();
        let body = $(this).val();
        let url = $(this).data('url');
        $(this).val('');
        $('#chat').append(`<p>${body}</p>`);
        let data = {
            '_token': $('meta[name=csrf-token]').attr('content'),
            body: body,
        }
        $.ajax({
            url: url,
            method: 'post',
            data: data
        });
    }
});

window.Echo.channel('laravel_database_chat-group').listen('MessageDelivered', (e) => {
    console.log(e.message.body);
    $('#chat').append(`<p>${e.message.body}</p>`);

});