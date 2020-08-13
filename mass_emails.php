<?php 
include 'lib/PHPMailer/PHPMailer/PHPMailerAutoload.php';

  //function to connect to the database'
  function dbconnect(){

      $sql = "localhost"; 
      $username = "root";
      $password = "";
      $conn = mysqli_connect($sql, $username, $password) or 
      die("Unable to connect to the database");
      $databse = mysqli_select_db($conn, "emails");

      // Return from the function 
      return $conn; 
  }

function sendEmailsToJobSeekers(){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT name, email FROM employers WHERE status=?");
    $stmt->bind_param('i',$status);
    $status=0;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $myemail);
    while($stmt->fetch()){
       
    $email = $myemail;
    $email2='nyasha@ipcconsultants.com';


    $subject = "RE: Peformance Management System Offer";

    $message = "<html>
            <body style='color:#175ea8;'>
              <p>Good day ".ucfirst($name).", </p>
              <p align='justify'>

We hope this email finds you well. As Industrial Psychology Consultants (IPC), we have developed a Performance Management System (Iperform) which we offer to you and your organisation. Iperform implements the standard balanced scorecard which was developed by Professor Robert Kaplan and David Norton in the 1990s. The system offers an objective performance management criteria. </p>

<b>Highlights on Key Functionality:</b>
<ol>
<li>  Connection of Organisational Strategy and Performance Management.</li>
<li>  Organisational wide Strategy evaluation.</li>
<li>  Projects Management embedded.</li>
<li>  Events Management. </li>
<li> Instant Communication (reminders, messaging).</li>
<li>  Organisational Strategy Cascading.</li>
<li> Detailed Reporting with more visualisation.</li>
<li>  Performance highlights towards each review period.</li>
</ol>

<p><i><b>We offer free demos if you are interested. For Inquiries you can send an email to bis@ipcconsultants.com or call our offices at (0242) 481946-48/50 or 08677102638 or 08677108090 asking for Nyasha, Tapiwa, Jerry or Kudzai.</i></b></p>
              
<p>Regards,</p>
<p>Admin @ IPCIperform</p>
          </html>";

 email($email,$subject,$message);
 email($email2,$subject,$message);

      }
    $stmt->close();

    $conn->close();


}

function email($email,$subject,$message){
   $conn=dbconnect();
 //use php mailer to send emails
  // include '../lib/PHPMailer/PHPMailer/PHPMailerAutoload.php';

  //Create a new PHPMailer instance
  $mail = new PHPMailer;


    //send email to client
      $mail->IsSMTP();
      $mail->Host = "mail.ipcconsultants.com";

      // optional 
      $mail->SMTPAuth = true;
      $mail->Username = 'jobevaluation';
      $mail->Password = 'Redweb2019#';

      //Set who the message is to be sent from
      $mail->setFrom('jobevaluation@ipcconsultants.com', 'IPC Iperform');
      //$mail->AddBCC($email2, 'IPC Iperform');
   
      
      //Set who the message is to be sent to
      $mail->addAddress($email, $subject); 
      $mail->Subject = $subject;

      $mail->IsHTML(true);
      $mail->Body  = $message;
      $mail->AltBody = $message;

      //send the message, check for errors
      if (!$mail->send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
      } else {
          //do nothing after sending email
      } 

      $mail->ClearAllRecipients(); 
      $mail->ClearAttachments();  

    $conn->close();
}


sendEmailsToJobSeekers();

?>