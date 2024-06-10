<?php
// Stabilire la connessione al database db_utenti
$dbhost = "sql7.freemysqlhosting.net";
$dbuser = "sql7711971";
$dbpass = "siy4A76jQY";
$dbname = "sql7711971";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Controllare la connessione
if ($conn->connect_error) 
{
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Recupera i dati inviati dal form
$username = $_POST["utente"];
$password = $_POST["password"];



// Utilizza prepared statements per evitare SQL injection
$stmt = $conn->prepare("SELECT token FROM utenti WHERE utente = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$risultatoquery = $stmt->get_result();




if ($risultatoquery->num_rows > 0)     //se la query restituisce almeno un risultato allora esistono credenziali corrette
{
    $row = $risultatoquery->fetch_assoc();
    echo "Credenziali corrette! Token: " . $row["token"];
} 
else 
{
    echo "Credenziali di accesso errate.";
}






// Chiudi la connessione al database
$stmt->close();
$conn->close();
?>
