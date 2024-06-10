<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCESSO AL DATABASE</title>
</head>
<body>
    <h1>Inserisci i dati di accesso</h1>
    <form action="login.php" method="post">
        <label for="utente">Nome utente:</label>
        <input type="text" id="utente" name="utente" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <br>
        <input type="submit" value="Entra">
    </form>
</body>
</html>
