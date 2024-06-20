<?php
$host = "127.0.0.1";
$port = 8080;


$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!$sock) {
    die("Socket creation failed: " . socket_strerror(socket_last_error()));
}


$result = socket_bind($sock, $host, $port);
if (!$result) {
    die("Socket bind failed: " . socket_strerror(socket_last_error($sock)));
}


$result = socket_listen($sock, 3);
if (!$result) {
    die("Socket listen failed: " . socket_strerror(socket_last_error($sock)));
}
echo "Server is listening for connections...\n";

do {

    $accept = socket_accept($sock);
    if (!$accept) {
        echo "Socket accept failed: " . socket_strerror(socket_last_error($sock)) . "\n";
        continue;
    }


    $msg = socket_read($accept, 1024);
    if ($msg === false) {
        echo "Socket read failed: " . socket_strerror(socket_last_error($accept)) . "\n";
    } else {
        $msg = trim($msg);
        echo "Client: $msg\n";


        if ($msg == "Hello") {
            $reply = "Hello, client!";
        } elseif ($msg == "How are you?") {
            $reply = "I'm fine, thank you!";
        } else {

            echo "Enter your reply: ";
            $reply = rtrim(fgets(STDIN)); 
        }

  
        socket_write($accept, $reply, strlen($reply));
    }


    socket_close($accept);
} while (true);


socket_close($sock);
?>
