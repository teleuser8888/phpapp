Nuova sede operativa. Edificio a unico piano suddiviso in vari uffici con 100 postazioni cablate. Sarà necessaria una rete Wi-Fi che copra tutto l’edificio e che vada poi a permettere l’uso di dipendenti mobili, stampanti e tablet. 
Server dedicato interno alla sede che dovrà gestire servizi cloud interni. I dipendenti devono potervi accedere. L’azienda ha già acquistato il domino tech solution, che vorrebbero utilizzare per fornire i propri servizi via web. 

In particolare il portale metterà a disposizione della clientela delle FAq riferite a richieste tipiche di manutenzione in relazione ai servizi che l’azienda offre al pubblico. 

Requisiti di Progetto: 
- Rappresentare architettura tramite schema di rete evidenziando i dispostivi di rete utilizzati e i dispositivi aziendali 
- Fornire un piano di indirizzamento per la rete locale indicando modalità di assegnazione automatica o statica. 
- Descrivere come avverrà ala connessione alla rete pubblica e quali tecniche per l’accesso dall'esterno come NAT, port forwarding e DNS. 
- Descrivere le soluzioni di sicurezza (firewall, DMZ, Https, SSL).

- Descrivere componenti principali di un portale web pubblicato verso l’esterno in relazione allo stack di svilupppo più congeniale giustificando le scelte proposte. 

Webserver: cms. sito con le faq. XAMPP è un esempio di stack in uso. Commentare uso frontend, backend, dbms etc. 
Springboot è un’altra soluzione, che sempre riprende architettura FE, BE etc. Come pure un load balancer, anche se e solo se viene inserito un vincolo progettuale lo si presenta. 

- Implementare un DBMS in un container definendo la struttura dati opportuna (In questo caso si sta ancora trattando unicamente delle faq) e riempiere le caselle con dati di esempio. 

quindi descrivere lo schema. Poi creare il container stanziando un’immagine che lo abbia in pancia. Definire poi le istruzioni con inizializzazione del database, una che crea il db e la tabella secondo lo schema definito e poi si ha inserimento. 
Due opzioni: iniezione script SQL oppure inserendosi manualmente nella CLI del container e dando i dati manualmente. 

- opzionale: realizzare un micro servizio di visualizzazione di tutte le FAQ presenti nel dbms visualizzandole su una pagina web. 

Quindi un container con istanza Di server web, con pagine php che faranno select e print. Docker compose permette di mettere insieme nell’ordine corretto tutto l’insieme.

vediamo che quindi servirà un container con db, un container che si occupi del frontend e uno del BE. In certi contesti in cui si ha riduzione di banda e simili si limitino le risposte HTTP. Ricordiamo che rispettiamo lo standard APIrest ma nulla è nella pietra e bisogna calare la cosa sul contesto in cui si trova. 

# Definiamo lo schema 

Tabella unica? Teniamo conto la necessità di normalizzazione del db. Per cui si progetta sin dall’inizio. Ci sono dati duplicati?! Mai devono esserci. 
Tabella di ciò che vorrei rappresentare con tutti i campi. Valori di esempio. 

Id con autoincrement chiave principale. 
Domanda 
Risposta 
Email soggetto che scrive la risposta in modo da poterlo contattare. 

Le email diventano un dato che si ripete spesso, quindi una sua tabella in cui sono indicate le mail dei tecnici sarebbe possibile inserirla. Ma di solito si fa se ci sono almeno due entità che siano appartenenti a un singolo allora conviene. 
# Instanziamo il container 

Che usiamo? Usiamo in relazione a quello che abbiamo indicato inizialmente come stack. 

Istruzioni di istanziazione su docker hub. 
`docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mysql:latest`

## Inserire i file manualmente 

`docker exec -it some-mysql bash`

E poi via con la cli. Quindi: 
`mysql -u root -p`  e poi password. 
`create database nome;`
`use nome;`
`Create table nometabella` 
Specificare quindi le entità:
`create table fag (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, domanda VARCHAR(255), risposta VARCHAR(255), email VARCHAR(255));`

E inserire i dati:
`insert into faq (domanda, risposta,email) VALUES ("il tue prof preferito?", "Zapini" "10@me.it";)`

`Describe nome tabella` per vederla benino. 

# Pubblicare i file 

Nota, se si usa il container con il volume condiviso tramite la variabile -v, la cartella che si usa deve avere i permessi. 

## File PHP 


