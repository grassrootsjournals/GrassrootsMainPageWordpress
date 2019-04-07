<label for="expertise">Expertise of your editorial team:</label><br>
		  				<textarea rows="10" cols="30" name="expertise" id="expertise" placeholder="Please provide information that allows an outsider to assess your expertise and that of the other people on your editorial team. For example, roles your community trusted your with, links to publication records, etc. Early career researchers are welcome, but some members of the editorial team should be among the leaders in your field."></textarea><br>
		  				<label for="comment">Comment:</label><br>
		  				<textarea rows="10" cols="30" name="comment" id="comment" placeholder="Any comments"></textarea><br> 
		  				<label for="message_human">Human Verification: <span>*</span><br>
		  					<input type="text" style="width: 60px;" name="message_human"> + 3 = 5</label><br>
		                <input type="hidden" name="submitted" value="1">



		                https://viven.org/contactgrassroots/?contactType=General&FirstName=Victor3&LastName=Venema3&email=Victor.Venema%40grassroots.is&AcademicHomepage=https%3A%2F%2Fgrassroots.is&JournalName=Homogenization+Journal&URL=homo3

e6a5072509
e6a5072509


		                		  				<p><label for="URL">Journal URL:</label><br>
		  				<input type="text" name="URL" id="URL"  placeholder="Journal subdomain">&nbsp;.grassroots.is</p>




						<p><label for="comment"><span class="visible-journal">Expertise of your editorial team:</span><span class="visible-general">Comment:</span><br>
		  				<textarea name="comment" id="comment" rows="10" cols="30"><?php echo($_POST['comment']) ?></textarea></label></p>




  $response = "";

  //function to generate response
  function my_contact_form_generate_response($type, $message){

    global $response;

    if($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";

  }

  //response messages
  $not_human       = "Human verification incorrect.";
  $missing_content = "Please supply all information.";
  $email_invalid   = "Email Address Invalid.";
  $message_unsent  = "Message was not sent. Please try Again.";
  $message_sent    = "Thank you! Your message has been sent.";

  //user posted variables
  $name    = $_POST['message_name'];
  $email   = $_POST['message_email'];
  $message = $_POST['message_text'];
  $human   = $_POST['message_human'];

  //php mailer variables
  $to      = get_option('admin_email');
  $subject = "Someone sent a message from ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 2) my_contact_form_generate_response("error", $not_human); //not human!
    else {

      //validate email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
      else //email is valid
      {
        //validate presence of name and message
        if(empty($name) || empty($message)){
          my_contact_form_generate_response("error", $missing_content);
        }
        else //ready to go!
        {
          $sent = wp_mail($to, $subject, strip_tags($message), $headers);
          if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
          else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
      }
    }
  }
  else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);


There is <a href="/to-do-list/">still a lot to do</a>, if you would like to <a href="https://viven.org/contactgrassroots?initial_state=journal">start a Grassroots Journal please fill in this form</a>, the <a href="https://github.com/grassrootsjournals">code for this site is on GitHub,</a> if you are interested in exploring the possibilities of grassroots publishing together <a href="https://viven.org/contactgrassroots?initial_state=general">please contact me</a>. To stay informed about progress with an occasional mail  you can <a href="https://viven.org/contactgrassroots?initial_state=newsletter">join our newsletter</a>.  




//response generation function

  $response = "";

  //function to generate response
  function my_contact_form_generate_response($type, $message){
    global $response;

    if($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";
  }

  //response messages
  $not_human       = "Human verification incorrect.";
  $missing_content = "Please supply all information.";
  $email_invalid   = "Email Address Invalid.";
  $message_unsent  = "Message was not sent. Please try Again.";
  $message_sent    = "Thank you! Your message has been sent.";

  //user posted variables
  $name    = $_POST['FirstName'];
  $email   = $_POST['email'];
  $message = $_POST['comment'];
  $human   = $_POST['message_human'];
/*
name="contactType"
name="FirstName"
name="LastName" 
name="email" 
name="AcademicHomepage"
name="JournalName" 
name="URL" 
name="expertise"
for="comment"
*/

  //php mailer variables
  $to      = get_option('admin_email');
  $subject = "Someone sent a message from ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 2) my_contact_form_generate_response("error", $not_human); //not human!
    else {

      //validate email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
      else //email is valid
      {
        //validate presence of name and message
        if(empty($name) || empty($message)){
          my_contact_form_generate_response("error", $missing_content);
        }
        else //ready to go!
        {
          $sent = wp_mail($to, $subject, strip_tags($message), $headers);
          if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
          else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
      }
    }
  }
  else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);



<div class="visible-journal"><p><label for="messageExpertise">Expertise of your editorial team:</span><br>
	<textarea name="messageExpertise" id="comment" maxlength="1000" rows="10" cols="30" class="<?php echo($errorClassExpertise) ?>"><?php echo($_POST['messageExpertise']) ?></textarea></label></p></div>


		  				










					<form action="<?php the_permalink(); ?>" method="post" id="newAssessment">		
						<p><label for="doi">DOI: </label><br>
		  				<input type="text" name="doi" id="doi" maxlength="100" placeholder="Digital Object Identifier"></p>

						<p><label for="initiator">Initiator: </label><br>
		  				<input type="text" name="initiator" id="initiator" maxlength="100" placeholder="Name of initiator" value="<?php
		  				$userName echo() ?>" readonly>></p>

						<p><label for="editors1">Editors: </label><br>
						<select name="editors" form="newAssessment">
						  <option value="editor1">Editor 1</option>
						  <option value="editor1">Editor 2</option>
						  <option value="editor1">Editor 3</option>
						  <option value="editor1">Editor 4</option>
						</select>

						<p><label for="editors1">Editors: </label><br>
						<select name="editors" form="newAssessment">
						  <option value="editor1">Editor 1</option>
						  <option value="editor1">Editor 2</option>
						  <option value="editor1">Editor 3</option>
						  <option value="editor1">Editor 4</option>
						</select>
						<!-- <p>An assessment typically has two editors. To reinforce this fact this section should initiatlize with two visible editors. But more editors are possible, so when filling in the last editor and additional dropdown menu should appear. I will add code later that this field is only visible for users with an editor role. Normal users do not have to fill this in. Editors can also be added later, so zero or one editors is all fine.</p> -->

						<p><label for="title">Title: </label><br> <span class="requiredfield">*</span>
		  				<input type="text" name="title" id="title" maxlength="1000" placeholder="Title of the study"></p>

						<div id="referenceBox">
							<p><label for="reference"><span id="reference">Reference: </span><span class="requiredfield">*</span><br>
			  				<textarea name="reference" id="reference" maxlength="10000" rows="10" cols="50">Please cite the study as completely as possible. Authors, title, journal/publisher, year, pages, ...</textarea></label></p></div>
						</div>
						<!-- <p>Different fields of science have different formats for the reference. In climatology the most common format is: $LastName1, $Initials1, $Initials2 $LastName2, (if more than 50 authors, the rest is et al.) $Year: $Title. <i>$Journal</i>, <b>Volume</b>, pp. $firstPage-$lastPage. https://doi.org/$doi
						
						Later it would be good if the editors can specify a format in the backend. How would one pass this to the JavaScript on the front end? Write it in the JS code using PHP? Or have JS read a hidden form field?

						If we cannot find the DOI we could also guess the information below from the hand written reference in this box. Thus it would probably be good to store whether this reference was machine generated or manual (and may thus contain errors).
						</p> -->

						<div id="abstractBox">
							<p><label for="messageComment"><span id="commenttext">Abstract: </span><br>
			  				<textarea name="messageComment" id="comment" maxlength="10000" rows="10" cols="60"></textarea></label></p></div>
						</div>

						<fieldset>
							<b>Authors: </b>
							<p><label for="author1">Given name or initials: </label><br>
		  					<input type="text" name="givenNameauthor1" id="givenNameauthor1" maxlength="100" placeholder="Given name of author">
							<label for="author1">Family name: </label><br>
		  					<input type="text" name="familyNameauthor1" id="familyNameauthor1" maxlength="100" placeholder="Family name of author"></p>
		  					<!-- <p>Each time a name is filled in a next row for the next name should appear. Best store ORCID ID and affiliation as well, if available. That can help later to make pages per author.</p> -->

							<p><label for="title">Title: </label><br>
		  					<input type="text" name="title" id="title" maxlength="1000" placeholder="Title of the study"></p>
							<!-- <p>Do this double to have all information complete here, or is that confusing. Can simply copy the above entry.</p> -->

							<p><label for="fullJournalName">Full journal name: </label><br>
		  					<input type="text" name="fullJournalName" id="fullJournalName" maxlength="1000" placeholder="Name of the journal written out."></p>
							<!-- <p>Called container-title in the CrossRef API.</p> -->

							<p><label for="shortJournalName">Short journal name: </label><br>
		  					<input type="text" name="shortJournalName" id="shortJournalName" maxlength="1000" placeholder="Typical abbreviation for this journal as used to cite it."></p>
							<!-- <p>Called short-container-title in the CrossRef API.</p> -->

							<p><label for="volume">Journal volume: </label><br>
		  					<input type="text" name="volume" id="volume" maxlength="1000" placeholder="Volume of the journal."></p>
							
							<p><label for="pages">Pages: </label><br>
		  					<input type="text" name="pages" id="pages" maxlength="1000" placeholder="FirstPage-LastPage"></p>
							<!-- <p>Called page in the CrossRef API.</p>
page
container-title	
							Reference details
In case that makes a difference for how the code is organized: There are more services than CrossRef. For example, DataCite is sometimes used for manuscripts (it is cheaper). And there are databases with OpenAccess journals that may (or may not) contain more information. Maybe also unpaywall could be added to see if there are any open copies of the article, if not we could ask the user if they know of an open copy.

https://datacite.org/							
https://search.datacite.org/api?q=10.1002%2Fjoc.5458&fl=doi,creator,title,publisher,publicationYear,datacentre&fq=is_active:true&fq=has_metadata:true&rows=10&wt=json&indent=true

https://api.crossref.org/v1/works/{$doi}
For example:
https://api.crossref.org/v1/works/10.1002/joc.5458

short-container-title	
0	"Int. J. Climatol"

container-title	
0	"International Journal of Climatology"

published-print	
date-parts	
0	
0	2018
1	5
DOI	"10.1002/joc.5458"
type	"journal-article"

page	"2760-2774"

title	
0	"Towards a global land surface climate fiducial reference measurements network"

volume	"38"

author	
0	
ORCID	"http://orcid.org/0000-0003-0485-9798"
authenticated-orcid	false
given	"P. W."
family	"Thorne"
sequence	"first"
affiliation	
0	
name	"Irish Climate Analysis and Research Unit, Department of Geography; Maynooth University; Maynooth Ireland"

1	
given	"H. J."
family	"Diamond"
sequence	"additional"
affiliation	
0	
name	"National Oceanic and Atmospheric Administration's Air Resources Laboratory; Silver Spring Maryland"
-->

						</fieldset>


		  				<p><label for="messageHuman">Human Verification: <span class="requiredfield">*</span><br>
		  					<input type="text"  maxlength="10" style="width: 60px;" name="messageHuman" value="<?php echo($messageHuman) ?>"  class="<?php echo($errorClassHuman) ?>"> + 3 = 5</label></p>
		  				<p>A better method to protect against bots is important. We do not want to annoy the editors with spam contributions. However, I would prefer not to use anything that acts as a third party tracker, such as Google's reCaptcha. Do you know of an alternative that could run on our own server?</p>
		                <input type="hidden" name="submittedGrassroots" value="1">
		  				<p><input type="submit" value="Submit"></p>
					</form> 






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


							  				