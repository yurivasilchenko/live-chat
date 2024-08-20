<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<div class="chat">


    <div class="top">
        <img src="https://media.npr.org/assets/img/2024/04/29/spongebobsquarepants_key_art_custom-3ce5c431ab9bbe048686fd56a6e535dbf7b41cf5.jpg" alt="Avatar">
        <div>
            <p>Spongi Bobi</p>
            <small>Online</small>
        </div>

    </div>

    <div class="messages">
        @include('receive', ['message'=>"Hey wasup"])

    </div>

    <div class="bottom">
        <form method="POST" action="/broadcast">
            @csrf
            <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
            <button type="submit"></button>
        </form>

    </div>
</div>
</body>

<script>
    // Initialize Pusher
    const pusher = new Pusher('dadeb61cd324e3416186', {
        cluster: 'eu'
    });

    // Subscribe to the 'public' channel
    const channel = pusher.subscribe('public');
    channel.bind('chat', function(data) {
        console.log('Received message:', data.message);
    });

    // Listen for the 'chat' event
    channel.bind('chat', function(data) {
        // Append the received message to the chat window
        const newMessage = `<div class="left message"><p>${data.message}</p></div>`;
        $(".messages").append(newMessage);

        // Scroll to the bottom of the chat
        $(document).scrollTop($(document).height());
    });

    // Broadcast messages
    $("form").submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: "/broadcast",
            method: 'POST',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data: {
                _token: '{{ csrf_token() }}',
                message: $("form #message").val(),
            }
        }).done(function(res) {
            // Display your own message
            $(".messages").append(`<div class="right message"><p>${$("form #message").val()}</p></div>`);
            $("form #message").val('');
            $(document).scrollTop($(document).height());
        });
    });
</script>

</html>
