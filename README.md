<h1>Web app Twitter</h1>
<p>Piccola web app realizzata con laravel e vue.js che permette di pubblicare e pianificare la pubblicazione dei tweet</p>
<br>
<h3>Installazione e configurazione (In locale)</h3>
Creare una database e collegarlo tramite il file .env al backend realizzato in laravel, dopo di che lanciare il comando da bash "php artisan migrate", verranno così create le varie tabelle.
<br>
Settare nel file .env i vari codici per collegarsi alle api di twitter (TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET).
Lanciare il server ed eseguire il comando "php artisan schedule:work" che ci permetterà in locale di usufruire dello scheduler.
<br>
Collegarsi al server alla pagina ../twitter( es. http://localhost:8000/twitter qualora il server venga aperto nella porta 8000) e da qui si avrà accesso a tutti i post pubblicati dall'utente loggato tramite api e si potranno pubblicare e pianificare nuovi tweet.

