<?php
	function generateDeleteCode($mail) {
		return md5($mail . time());
	}
	
	function sendConfirmationMail($mail, $deleteCode) {
		// mehrere Empfänger
		$empfaenger  = '$mail';
		
		// Betreff
		$betreff = 'SERS - Bestätigung Anmeldung für Skydive-Event';
		
		// Nachricht
		$nachricht = '
		<html>
		<head>
		  <title>SERS - Bestätigung Anmeldung für Skydive-Event</title>
		</head>
		<body>
		  <p>Code zum Abmelden: $deleteCode</p>
		  <table>
			<tr>
			  <th>Person</th><th>Tag</th><th>Monat</th><th>Jahr</th>
			</tr>
			<tr>
			  <td>Julia</td><td>3.</td><td>August</td><td>1970</td>
			</tr>
			<tr>
			  <td>Tom</td><td>17.</td><td>August</td><td>1973</td>
			</tr>
		  </table>
		</body>
		</html>
		';
		
		// für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// zusätzliche Header
		$header .= 'To: $mail' . "\r\n";
		$header .= 'From: SERS - <info@produxtion.ch>' . "\r\n";
		$header .= 'Bcc: info@produxion.ch' . "\r\n";
				
		// verschicke die E-Mail
		mail($empfaenger, $betreff, $nachricht, $header);
	}
	
?>