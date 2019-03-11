<?php /* Contact page: contactgrassroots */ 

	/* Sanitize POST data (safety) */ 
	// Radio button for the contact type.
	// Default radio button setting
	$checkedGeneral = "checked";
	$checkedJournal = "";
	$checkedNews    = "";

	// Radio button setting determined by link
	$initialContactType = $_GET['initial_state'];
	if( $initialContactType === "general" ) {
		$checkedGeneral = "checked";  // Sets the check mark
		$contactType    = "general";  // Ensure that JS shows the right fields
	}
	if( $initialContactType === "newJournal" ) {
		$checkedJournal = "checked";
		$contactType    = "newJournal";
	}
	if( $initialContactType === "newsletter" ) {
		$checkedNews = "checked";
		$contactType = "newsletter";
	}

	// Radio button setting of the returned form
	$contactTypeSubmitted = $_POST['contactType'];

	/*
	$contactTypeSubmitted = $_POST['contactType'];
	if( ($_POST['submittedGrassroots'] == 1) and 
		(strcmp($contactTypeSubmitted, "general")    != 0) and 
		(strcmp($contactTypeSubmitted, "newJournal") != 0) and 
		(strcmp($contactTypeSubmitted, "newsletter") != 0) ) {
		$contactType = "general";
		// echo("ContactType changed to default value " . $contactType . "<br>");
		// $post_slug = $post->post_name;
	}
	*/
	// Keep state after submit
	if( $contactTypeSubmitted ===  "general" )  {
		$checkedGeneral = "checked";
		$contactType    = "general";
	}
	if( $contactTypeSubmitted ===  "newJournal"  ) {
		$checkedJournal = "checked";
		$contactType    = "newJournal";
	}
	if( $contactTypeSubmitted ===  "newsletter"  ) {
		$checkedNews = "checked";
		$contactType = "newsletter";
	}
	if ( isset($contactType) == FALSE ) {
		$checkedGeneral = "checked";
		$contactType    = "general";
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
	} 

	if( $contactType === "general" or $contactType === "newJournal") {
		$messageComment = $_POST['messageComment'];
		$messageComment = sanitize_textarea_field($messageComment);
		wp_trim_words($messageComment, 1000);
	}

	$messageHuman = $_POST['messageHuman'];
	if ( strlen( $messageHuman ) > 5 ) {
		$messageHuman = substr( $messageHuman, 0, 5 );
	}

	$submittedGrassroots = intval($_POST['submittedGrassroots']);
	if ( strlen( $submittedGrassroots ) > 1 ) {
		$submittedGrassroots = substr( $submittedGrassroots, 0, 1 );
	}

	if ( $submittedGrassroots == 1 ) {
		/* Check whether the POST data makes sense for me */ 
		$errorFound = FALSE;
		$errorMessage = "";

		/*
		// Commented out. No name is allowed.
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

			// URL. Not required so string length 0 is okay.
			// Allowed in a domain name are: [A-Za-z0-9_.\-~], I would prefer to limit a subdomain to: [a-z0-9_-]
			$URL = strtolower( $URL );
			if( strlen($URL) > 0 and preg_match('/^[a-z0-9_-]+$/', $URL) == FALSE ) {
				$errorFound = TRUE;
				$errorMessage .= 'Your journal subdomain name contains illegal characters, only a-z and 0-9, as well as "-" and "_" are allowed.<br>' ;
				$errorClassURL = "errorfield";
			} else {
				$errorClassURL = "";
			}

		} 

		// messageComment, was already sanitized and checked for length. Should contain something. Is required.
		if( $contactType === "general" or $contactType === "newJournal") {
			if ( strlen( $messageComment ) == 0 ) {
				$errorFound = TRUE;		
				if( $contactType === "newJournal") {
					$errorMessage .= "A description of the expertise of your team is missing.<br>" ;
				} else {
					$errorMessage .= "Your message is missing.<br>" ;
				}
				$errorClassComment = "errorfield";
			} else {
				$errorClassComment = "";
			}		
		}

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
		if( $contactType === "general") {    		    
		   	$mailBody = 'ContactType: '      . $contactType           . PHP_EOL . 
		   	            'FirstName: '        . $firstName             . PHP_EOL . 
		   	            'LastName: '         . $lastName              . PHP_EOL .  
		   	            'Name: '             . $firstName . $lastName . PHP_EOL . 
		   	            'Email: '            . $email                 . PHP_EOL . 
					   	'Comment:'           . $messageComment        . PHP_EOL .  
					   	'Human: '            . $messageHuman          . PHP_EOL .  
					   	'Submitted: '        . $submittedGrassroots   . PHP_EOL;
	    }
		if( $contactType === "newJournal") {    		    
		   	$mailBody = 'ContactType: '      . $contactType           . PHP_EOL . 
		   	            'FirstName: '        . $firstName             . PHP_EOL . 
		   	            'LastName: '         . $lastName              . PHP_EOL .  
		   	            'Name: '             . $firstName . $lastName . PHP_EOL . 
		   	            'Email: '            . $email                 . PHP_EOL . 
		   	            'AcademicHomepage: ' . $academicHomepage      . PHP_EOL . 
		   	            'JournalName: '      . $journalName           . PHP_EOL . 
		   	            'URL: '              . $URL                   . PHP_EOL . 			  
					   	'Comment:'           . $messageComment        . PHP_EOL .  
					   	'Human: '            . $messageHuman          . PHP_EOL .  
					   	'Submitted: '        . $submittedGrassroots   . PHP_EOL;
	    }
		if( $contactType === "newsletter" ) {    		    
		   	$mailBody = 'ContactType: '      . $contactType           . PHP_EOL . 
		   	            'FirstName: '        . $firstName             . PHP_EOL . 
		   	            'LastName: '         . $lastName              . PHP_EOL .  
		   	            'Name: '             . $firstName . $lastName . PHP_EOL . 
		   	            'Email: '            . $email                 . PHP_EOL . 
					   	'Human: '            . $messageHuman          . PHP_EOL .  
					   	'Submitted: '        . $submittedGrassroots   . PHP_EOL;
	    }

		/*
	   	echo("To: "     . $to       . "<br>");
	   	echo("Subject:" . $subject  . "<br>");
	   	echo("Headers:" . $headers  . "<br>");
		echo("Body:"    . $mailBody . "<br>");
		*/

		$operational = TRUE;
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
	} // if submitted

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
					if ( $submittedGrassroots == 1 ) {
						if ($errorFound) {
							echo("<div class='error'>{$errorMessage}</div>");					
						} else {
							echo("<div class='success'>{$errorMessage}</div>");
						}
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
					<?php the_post(); ?>
					<?php the_content(); ?>
					<form action="<?php the_permalink(); ?>" method="post">						
						<p><label>Purpose:</label><br>
						<input type="radio" name="contactType" id="typeGeneral" value="general" <?php echo($checkedGeneral) ?> onclick="selectGeneral()"> <label for="typeGeneral">General comment (feel free to send <a href="mailto:victor.venema@grassroots.is?subject=Grassroots%20Journals%20Feedback&body=Dear%20Victor,">an email</a>).</label><br>
		  				<input type="radio" name="contactType" id="typeJournal" value="newJournal" <?php echo($checkedJournal) ?> onclick="selectJournal()"><label for="typeJournal">Apply for a new Grassroots Journal.</label><br>
		  				<input type="radio" name="contactType" id="typeNews" value="newsletter" <?php echo($checkedNews) ?> onclick="selectNewsletter()"><label for="typeNews">Subscribe to our newsletter. (Stay in touch and be informed about progress. At most one mail per month and only when it is important. Promise!)</label></p>
						
						<p><label for="firstName">First name: </label><br>
		  				<input type="text" name="firstName" id="firstName" maxlength="100" placeholder="Your given name" value="<?php echo($firstName) ?>" class="<?php echo($errorClassFirstName) ?>" ></p>
		  				
		  				<p><label for="lastName">Last name: </label><br>
		  				<input type="text" name="lastName" id="lastName" maxlength="100" placeholder="Your family name" value="<?php echo($lastName) ?>"  class="<?php echo($errorClassLastName) ?>" ></p>

		  				<p><label for="email">Email: <span class="requiredfield">*</span></label><br>
		  				<input type="text" name="email" id="email" maxlength="100" placeholder="Your email address"  value="<?php echo($email) ?>" class="<?php echo($errorClassEmail) ?>" ></p>
						
						<div id="journalquestions">
			  				<div class="visible-journal"><p><label for="academicHomepage">Academic homepage:</label><br>
			  				<input type="text" name="academicHomepage" id="academicHomepage" maxlength="100" placeholder="URL of your homepage" value="<?php echo($academicHomepage); ?>" class="<?php echo($errorClassHomepage) ?>"></p></div>

			  				<div class="visible-journal"><p><label for="journalName">Journal name:<br>
			  				<input type="text" name="journalName" id="journalName" maxlength="100" placeholder="Name of the journal used in headline" value="<?php echo($journalName) ?>"></label></p></div>
							
							<div class="visible-journal"><p><label for="URL">Journal URL:</label><br>
			  				<input type="text" name="URL" id="URL"  maxlength="40" placeholder="Journal subdomain" value="<?php echo($URL) ?>" class="<?php echo($errorClassURL) ?>">&nbsp;.grassroots.is</p></div>
						</div>

						<div id="commentbox">
							<div class="visible-general"><p><label for="messageComment"><span id="commenttext">Comment: </span><span class="requiredfield">*</span><br>
			  				<textarea name="messageComment" id="comment" maxlength="1000" rows="10" cols="30" class="<?php echo($errorClassComment) ?>"><?php echo($messageComment) ?></textarea></label></p></div>
						</div>

		  				<p><label for="messageHuman">Human Verification: <span class="requiredfield">*</span><br>
		  					<input type="text"  maxlength="10" style="width: 60px;" name="messageHuman" value="<?php echo($messageHuman) ?>"  class="<?php echo($errorClassHuman) ?>"> + 3 = 5</label></p>
		                <input type="hidden" name="submittedGrassroots" value="1">
		  				<p><input type="submit" value="Submit"></p>
					</form> 
				</div> <!-- content -->
			</article>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->


<script>
	function selectGeneral() {
		document.getElementById("commenttext").innerHTML = "Comment:";
		document.getElementById("journalquestions").style.display = "none";
		document.getElementById("commentbox").style.display = "block";
	}
	function selectJournal() {
		document.getElementById("commenttext").innerHTML = "Expertise of your editorial team:";
		document.getElementById("journalquestions").style.display = "block";
		document.getElementById("commentbox").style.display = "block";
	}
	function selectNewsletter() {		
		document.getElementById("journalquestions").style.display = "none";
		document.getElementById("commentbox").style.display = "none";
	}
	
	selectGeneral();
	<?php 
		// if ( $submittedGrassroots == 1 ) {
			if( $contactType === "general") { 
				echo("selectGeneral();");
			}
			if( $contactType === "newJournal") {    
				echo("selectJournal() ");
			}
			if( $contactType === "newsletter" ) {   
				echo("selectNewsletter() ");
			}	
		// }
	?>
</script>

<?php
	get_footer();
