<?php

	function generateDeleteCode($mail) {
		return md5($mail . time());
	}
	
	function sendConfirmationMail($mail, $deleteCode) {
		// mehrere Empf�nger
		$empfaenger  = $mail . ', '; // beachten Sie das Komma
		$empfaenger .= 'info@fun-island.ch';
		
		$betreff = 'SERS - Anmeldung';
		
		// Nachricht
		$nachricht = '
		<html>
		<head>
		  <title>SERS - Anmeldung</title>
		</head>
		<body>
		  <p>Danke f&uuml;r deine Anmeldung.</p>
		  <p>Um dich abzumelden gehe auf folgende <a href="http://sers.produxion.ch">Seite</a> und benutze folgenden Code: ' . $deleteCode . '</p>
		</body>
		</html>
		';
		
		// f�r HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= 'From: info@produxion.ch' . "\r\n";
		$header .= 'Reply-To: info@produxion.ch' . "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion();

		mail($empfaenger, $betreff, $nachricht, $header);
	}
	
?>