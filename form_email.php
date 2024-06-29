<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes || Formulir email</title>
</head>
<body>
    <form action="send.php" method="post">
        Email : <input type="email" name="email" required><br>
        Subject : <input type="text" name="subject" required><br>
        Message : <input type="text" name="message" required><br>
        <button type="submit" name="kirim_email">Send</button>
    </form>
</body>
</html>