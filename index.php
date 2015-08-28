<?php


require 'vendor/autoload.php';
date_default_timezone_set('Africa/Harare');

use Monolog\Logger; 
use Monolog\Handler\StreamHandler;


// function phpAlert($msg_error) {
//     echo '<script type="text/javascript">alert("' . $msg_error . '")</script>';
//     // echo  '<a href="javascript:history.go(-1)"</a>';
   
// } 

//$log = new Logger('name');
//$log->pushHandler(new StreamHandler('app.txt', Logger::WARNING));
//$log->addWarning('Foo');

$app = new \Slim\Slim( array(
  'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$view->parserOptions = array(
    'debug' => true
);
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

$app->get('/', function() use($app){
  $app->render('home.twig');
})->name('home');

$app->get('/Tourism_Sites_in_Zimbabwe', function() use($app){
  $app->render('Tourism_Sites_in_Zimbabwe.twig');
})->name('resorts');

$app->get('/Tourism_Sites_in_Egypt', function() use($app){
  $app->render('Tourism_Sites_in_Egypt.twig');
})->name('resorts');

$app->get('/Tourism_Sites_in_South_Africa', function() use($app){
  $app->render('Tourism_Sites_in_South_Africa.twig');
})->name('resorts');

$app->get('/Tourism_Sites_in_Madgasca', function() use($app){
  $app->render('Tourism_Sites_in_Madgasca.twig');
})->name('resorts');

$app->get('/Tourism_Sites_in_Tunisia', function() use($app){
  $app->render('Tourism_Sites_in_Tunisia.twig');
})->name('resorts');

$app->get('/Tourism_Sites_in_Tanzania', function() use($app){
  $app->render('Tourism_Sites_in_Tanzania.twig');
})->name('resorts');

$app->get('/contact', function() use($app){
  $app->render('contact.twig');
})->name('contact');

$app->get('/about_us', function() use($app){
  $app->render('about_us.twig');
})->name('about');

$app->get('/search', function() use($app){
  $app->render('search.twig');
  
})->name('search');

  
 $app->post('/contact', function() use($app){
  $name= $app->request->post('name');
  $age=$app->request->post('age');
  $email=$app->request->post('email');
  $expected_date=$app->request->post('expected_date');
  $country_to_visit=$app->request->post('country_to_visit');
  $reason_for_visit=$app->request->post('reason_for_visit');
  $payment_method=$app->request->post('payment_method');
  $msg=$app->request->post('msg');

  if(!empty($name) && !empty($email) && !empty($msg)) {
    $cleanName = filter_var($name, FILTER_SANITIZE_STRING);
    $cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    $cleanMsg = filter_var($msg, FILTER_SANITIZE_STRING);
  } else {



echo "<script>
window.location.href='/project_2/contact';
alert('All the fields are needed. Please fill all fields and send again');
</script>";
	// phpAlert(   "All the fields are needed. Please fill all fields and send again"   );
  
 //  exit;
  }
  // $app->redirect('/project_2/contact');



  $transport = Swift_MailTransport::newInstance('/usr/sbin/sendmail -bs');
  $mailer = \Swift_Mailer::newInstance($transport);

  $message= \Swift_Message::newInstance();
  $message->setSubject('Email From Our Website');
  $message->setFrom(array($cleanEmail=>$cleanName));
  $message->setTo(array('resorts_africa@localhost'));
  $message->setBody($cleanMsg);

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "resorts_africa";

   // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 

  $sql = "INSERT INTO resortsafrica (name, age, email, reason_for_visit, country_to_visit, payment_method, msg)
  VALUES ('$name', '$age', '$email', '$reason_for_visit', '$country_to_visit', '$payment_method', '$msg')";

  if ($conn->query($sql) === TRUE) {
      // echo "Message sent successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

  $result = $mailer->send($message);
  if($result > 0){


echo "<script>
window.location.href='/project_2/';
alert('Thank you for contacting us. We will get to you soon.');
</script>";
	// phpAlert(   "Thank you for contacting us. We will get to you soon."   ); 
  
	// exit;
 //  $app->redirect('/project_2/');

  } else{

  echo "<script>
window.location.href='/project_2/contact';
alert('There was an error sending the message. Try again later.');
</script>";
	// phpAlert(   "There was an error sending the message. Try again later."   ); 
  
	// exit;
 //  $app->redirect('/project_2/contact');
  }
  	
});

$app->run();


?>