<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Client</title>
</head>
<body>
    <div align="center">
        <form method="post">
            <table>
                <tr>
                    <td>
                        <label>Enter the message</label>
                        <input type="text" name="txtMessage" required value="<?php echo isset($_POST['txtMessage']) ? htmlspecialchars($_POST['txtMessage']) : ''; ?>">
                        <input type="submit" name="btnSend" value="Send">
                    </td>
                </tr>
                <?php
                    $host = "127.0.0.1";
                    $port = 8080;
                    $reply = '';

                    if (isset($_POST['btnSend'])) {
                        $msg = $_POST['txtMessage'];
                        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                        if (!$sock) {
                            die("Socket creation failed: " . socket_strerror(socket_last_error()));
                        }
                        
                        $result = socket_connect($sock, $host, $port);
                        if (!$result) {
                            die("Socket connection failed: " . socket_strerror(socket_last_error($sock)));
                        }
                        
                        socket_write($sock, $msg, strlen($msg));
                        $reply = socket_read($sock, 1924);
                        if ($reply === false) {
                            $reply = "Socket read failed: " . socket_strerror(socket_last_error($sock));
                        } else {
                            $reply = trim($reply);
                            $reply = "Server says: " . $reply;
                        }
                        
                        socket_close($sock);
                    }
                ?>
                <tr>
                    <td>
                        <textarea cols="30" rows="10"><?php echo htmlspecialchars($reply) ?></textarea>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
