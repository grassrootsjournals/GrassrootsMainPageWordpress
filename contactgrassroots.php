<?php /* Contact page: contactgrassroots */ 

	/* Sanitize POST data (safety) */ 
	// Radio button for the contact type.
	$checkedGeneral = "checked";
	$checkedJournal = "";
	$contactType = $_POST['contactType'];
	if( strcmp($contactType, "general") != 0 and strcmp($contactType, "newJournal") != 0) {
		$contactType = "general";
		// echo("ContactType changed to default value " . $contactType . "<br>");
	}
	if( $contactType ===  "general" )  {
		$checkedGeneral = "checked";
	}
	if( $contactType ===  "newJournal"  ) {
		$checkedJournal = "checked";
	}

	// Check first name
	$firstName = $_POST['firstName'];
	$firstName = sanitize_text_field($firstName);
	wp_trim_words($firstName, 100);

	// Check last name
	$lastName = $_POST['lastName'];
	$lastName = sanitize_text_field($lastName);
	wp_trim_words($lastName, 100);

	// Check email
	$email = $_POST['email'];
	$email = sanitize_email($email);
	wp_trim_words($email, 100);

	if( $contactType === "newJournal") {
		$academicHomepage = $_POST['academicHomepage'];
		$academicHomepage = sanitize_text_field($academicHomepage);
		wp_trim_words($academicHomepage, 100);

		$journalName = $_POST['journalName'];
		$journalName = sanitize_text_field($journalName);
		wp_trim_words($journalName, 100);

		$URL = $_POST['URL'];
		$URL = sanitize_text_field($URL);
		wp_trim_words($URL, 100);

		$messageExpertise = $_POST['messageExpertise'];
		$messageExpertise = sanitize_textarea_field($messageExpertise);
		wp_trim_words($messageExpertise, 1000);

	} else {
		$messageComment = $_POST['messageComment'];
		$messageComment = sanitize_textarea_field($messageComment);
		wp_trim_words($messageComment, 1000);
	}

	$messageHuman = intval($_POST['messageHuman']);
	if ( strlen( $messageHuman ) > 5 ) {
		$messageHuman = substr( $messageHuman, 0, 5 );
	}

	$submittedGrassroots = intval($_POST['submittedGrassroots']);
	if ( strlen( $submittedGrassroots ) > 1 ) {
		$submittedGrassroots = substr( $submittedGrassroots, 0, 1 );
	}

	/* Check whether the POST data makes sense for me */ 
	$errorFound = FALSE;
	$errorMessage = "";

	/*
	if ( strlen( $firstName ) == 0 ) {
		$errorFound = TRUE;
		$errorMessage .= "Your first name is missing.<br>";
		$errorClassFirstName = "errorfield";
	} else {
		$errorClassFirstName = "";
	}

	if ( strlen( $lastName ) == 0 ) {
		$errorFound = TRUE;
		$errorMessage .= "Your last name is missing.<br>" ;
		$errorClassLastName = "errorfield";
	} else {
		$errorClassLastName = "";
	}
	*/

	if ( is_email( $email ) == FALSE ) {
		$errorFound = TRUE;
		$errorMessage .= "Your email address is wrong.<br>" ;
		$errorClassEmail = "errorfield";
	} else {
		$errorClassEmail = "";
	}

	if( $contactType === "newJournal") {
		$academicHomepage = esc_url($academicHomepage);
		if (strlen($URL) > 0 and wp_http_validate_url($academicHomepage) == FALSE ) {
			$errorFound = TRUE;
			$errorMessage .= "Your academic homepage URL is wrong.<br>" ;
			$errorClassHomepage = "errorfield";
		} else {
			$errorClassHomepage = "";
		}

		// journalName. Cannot think of a limitation beyond length, checked above. Not required.

		// URL. Not required so string lenght 0 is okay.
		// Allowed in a domain name are: [A-Za-z0-9_.\-~], I would prefer to limit a subdomain to: [a-z0-9_-]
		$URL = strtolower( $URL );
		if( strlen($URL) > 0 and preg_match('/^[a-z0-9_-]+$/', $URL) == FALSE ) {
			$errorFound = TRUE;
			$errorMessage .= 'Your journal subdomain name contains illegal characters, only a-z and 0-9, as well as "-" and "_" are allowed.<br>' ;
			$errorClassURL = "errorfield";
		} else {
			$errorClassURL = "";
		}


		// messageExpertise, was already sanitized and checked for lenght
		if ( strlen( $messageExpertise ) == 0 ) {
			$errorFound = TRUE;
			$errorMessage .= "A description of the expertise of your team is missing.<br>" ;
			$errorClassExpertise = "errorfield";
		} else {
			$errorClassExpertise = "";
		}
	} else { // if contactType is general
		// messageComment, was already sanitized and checked for lenght
		if ( strlen( $messageComment ) == 0 ) {
			$errorFound = TRUE;
			$errorMessage .= "Your message is missing.<br>" ;
			$errorClassComment = "errorfield";
		} else {
			$errorClassComment = "";
		}		
	} // Endif contactType

	if ( $messageHuman != 2 ) {
		$errorFound = TRUE;
		$errorMessage .= "Your answer to the robot check is false. Please try again.<br>" ;
		$errorClassHuman = "errorfield";
	}

	/* Send an email with the information */
	//php mailer variables
  	$to       = get_option('admin_email');
  	$subject  = "Someone sent a " . $contactType . " message from " . get_bloginfo('name');
  	$headers  = 'From: '     . $email . PHP_EOL .
    		    'Reply-To: ' . $email . PHP_EOL;
   	$mailBody = 'ContactType: '      . $contactType           . PHP_EOL . 
   	            'FirstName: '        . $firstName             . PHP_EOL . 
   	            'LastName: '         . $lastName              . PHP_EOL .  
   	            'Name: '             . $firstName . $lastName . PHP_EOL . 
   	            'Email: '            . $email                 . PHP_EOL . 
   	            'AcademicHomepage: ' . $academicHomepage      . PHP_EOL . 
   	            'JournalName: '      . $journalName           . PHP_EOL . 
   	            'URL: '              . $URL                   . PHP_EOL . 
			   	'Expertise: '        . $messageExpertise      . PHP_EOL . 
			   	'Comment:'           . $messageComment        . PHP_EOL .  
			   	'Human: '            . $messageHuman          . PHP_EOL .  
			   	'Submitted: '        . $submittedGrassroots   . PHP_EOL;
	/*
   	echo("To: "     . $to       . "<br>");
   	echo("Subject:" . $subject  . "<br>");
   	echo("Headers:" . $headers  . "<br>");
	echo("Body:"    . $mailBody . "<br>");
	*/

	$operational = FALSE;
	if ( $operational ) { // Bool to shut of sending mails during development.
		$sent = wp_mail($to, $subject, strip_tags($mailBody), $headers);
	} else {
		$sent = TRUE;
	}

    if ( $sent == FALSE ) {
    	$errorFound = TRUE;
    	$errorMessage .= "Message could not be sent. Please try again or send an email.<br>";
    }

    /* Prepare message if all checks were successful */
	if ( $errorFound == FALSE ) {
		if ( $operational ) {
			$errorMessage = "Thank you!<br>Your message has been sent.";
		} else {
			$errorMessage = "Sending email has been turned off. Contact site administrator by email.<br>";
		}
	}

    get_header(); 
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        	<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php twentyseventeen_edit_link( get_the_ID() ); ?>
				</header>

				<?php
				
				if ($errorFound) {
					echo("<div class='error'>{$errorMessage}</div>");					
				} else {
					echo("<div class='success'>{$errorMessage}</div>");
				}

				/*
			    echo($_POST['contactType'] . " ");
			    echo($_POST['firstName'] . " ");
			    echo($_POST['lastName'] . " ");
			    echo($_POST['email'] . " ");
			    echo($_POST['academicHomepage'] . " ");
			    echo($_POST['journalName'] . " ");
			    echo($_POST['URL'] . " ");
			    echo($_POST['messageExpertise'] . " ");
			    echo($_POST['messageComment'] . " ");
			    echo($_POST['messageHuman'] . " ");
			    echo($_POST['submittedGrassroots'] . " ");
			    echo(the_permalink());
			    */

			    ?>

				<div class="entry-content">
					<?php echo $response; ?>
					<form action="<?php the_permalink(); ?>" method="post">
						<p><label>Purpose:</label><br>
						<input type="radio" name="contactType" id="typeGeneral" value="general" <?php echo($checkedGeneral) ?>> <label for="typeGeneral">General comment (feel free to send <a href="mailto:victor.venema@grassroots.is?subject=Grassroots%20Journals%20Feedback&body=Dear%20Victor,">an email</a>).</label><br>
		  				<input type="radio" name="contactType" id="typeJournal" value="newJournal" <?php echo($checkedJournal) ?>><label for="typeJournal">Apply for a new Grassroots Journal.</label><br>
		  				<input type="radio" name="contactType" id="typeNews" value="news" <?php echo($checkedNews) ?>><label for="typeNews">Subscribe to our newsletter.</label> (Stay in touch and be informed about progress. At most one mail per month and only when it is important. Promise!)</p>
						
						<p><label for="firstName">First name: </label><br>
		  				<input type="text" name="firstName" id="firstName" maxlength="100" placeholder="Your given name" value="<?php echo($_POST['firstName']) ?>" class="<?php echo($errorClassFirstName) ?>" ></p>
		  				
		  				<p><label for="lastName">Last name: </label><br>
		  				<input type="text" name="lastName" id="lastName" maxlength="100" placeholder="Your family name" value="<?php echo($_POST['lastName']) ?>"  class="<?php echo($errorClassLastName) ?>" ></p>

		  				<p><label for="email">Email: <span>*</span></label><br>
		  				<input type="text" name="email" id="email" maxlength="100" placeholder="Your email address"  value="<?php echo($_POST['email']) ?>" class="<?php echo($errorClassEmail) ?>" ></p>
						
		  				<div class="visible-journal"><p><label for="academicHomepage">Academic homepage:</label><br>
		  				<input type="text" name="academicHomepage" id="academicHomepage" maxlength="100" placeholder="URL of your homepage" value="<?php echo($academicHomepage); ?>" class="<?php echo($errorClassHomepage) ?>"></p></div>

		  				<div class="visible-journal"><p><label for="journalName">Journal name:<br>
		  				<input type="text" name="journalName" id="journalName" maxlength="100" placeholder="Name of the journal used in headline" value="<?php echo($_POST['journalName']) ?>"></label></p></div>
						
						<div class="visible-journal"><p><label for="URL">Journal URL:</label><br>
		  				<input type="text" name="URL" id="URL"  maxlength="40" placeholder="Journal subdomain" value="<?php echo($_POST['URL']) ?>" class="<?php echo($errorClassURL) ?>">&nbsp;.grassroots.is</p></div>
		  				
						<div class="visible-journal"><p><label for="messageExpertise">Expertise of your editorial team:</span><br>
		  				<textarea name="messageExpertise" id="comment" maxlength="1000" rows="10" cols="30" class="<?php echo($errorClassExpertise) ?>"><?php echo($_POST['messageExpertise']) ?></textarea></label></p></div>
						
						<div class="visible-general"><p><label for="messageComment">Comment:<br>
		  				<textarea name="messageComment" id="comment" maxlength="1000" rows="10" cols="30" class="<?php echo($errorClassComment) ?>"><?php echo($_POST['errorClassHuman']) ?></textarea></label></p></div>
		  				
		  				<p><label for="messageHuman">Human Verification: <span>*</span><br>
		  					<input type="text"  maxlength="10" style="width: 60px;" name="messageHuman" value="<?php echo($_POST['messageHuman']) ?>"  class="<?php echo($errorClassHuman) ?>"> + 3 = 5</label></p>
		                <input type="hidden" name="submittedGrassroots" value="1">
		  				<p><input type="submit" value="Submit"></p>
					</form> 
				</div>
			</article>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();