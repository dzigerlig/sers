<?php

	function generateDeleteCode($mail) {
		return md5($mail . time());
	}
	
	function sendConfirmationMail($mail, $deleteCode) {
		// mehrere EmpfŠnger
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
		  <p>Danke f&uuml;r deine Anmeldung.</p><br>
		  <p>Falls du dich abmelden m&ouml;chtest (nur bis zum angegebenen Datum m&ouml;glich) kannst du dies Ÿber die Teilnehmerliste des jeweiligen <a href="http://sers.produxion.ch" target="_blank">Events</a> machen.</p><br>
		  <p>Daf&uuml;r ben&ouml;tigst du folgenden Code: ' . $deleteCode . '</p><br>
		  <p>Blue Sky from the SERS-Team</p>
		</body>
		</html>
		';
		
		// fŸr HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= 'From: SERS@produxion.ch' . "\r\n";
		$header .= 'Reply-To: SERS@produxion.ch' . "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion();

		mail($empfaenger, $betreff, $nachricht, $header);
	}
	
?>