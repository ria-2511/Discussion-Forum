# Discussion-Forum
A Virtual Discussion Platform for Students and Teachers where they all can Chat and Submit/Evaluate assignments as per the need. 

# Description 
The Forum is built with a user friendly interface where students can sign up and register themselves. They can then participate ion group chats of different subjects they have chosen and also submit assignments to various teachers using the Teacher's ID. 
The Teachers can also register to the same platform and can pariticpate in group chats for their particular subject and evaluate the assignments that have been submitted to the by the student. I have used a PHP Ratchet Websocket the implement the Group Chat Feature. The Socket is explained in detail below. 

## Output Demo 
I have created a Demo video for this software and here is the link to see the proper working of this project - https://www.youtube.com/watch?v=4I1mk851kLY

## StepWise Working of the project 
Here are the Various steps a user takes to use this software - 
1. Register themselves either as a Teacher/Student (Functionalities will differ later for both)
2. A verification email with the Login Link is sent to the registered email ID. 
3. Click on the Link sent and a Login Page will show. Login using the same registered credential and Viola! You are in! 
4. For Students - They can choose the subject for whose Group Chat they want to participate into 
5. For Teachers - They can either participate in the group chat of their subject or choose to evaluate the assignments being submitted to them. 
6. If they both choose Chat option then they can chat using the group chat feature and all the other users that are online. 
7. The Students can also submit assignments using the same Interface. The assignements have a restriction to be uploaded in PDF Format Only. 
8. If the teacher chooses the evaluate assignment option then she can check all the assignments that have been submitted to only her and not of other teachers.
9. Both can also Edit their profiles (usernames , Profile pictures , emails , Passwords) using the "edit profile" button on their interface. 
10. They can Logout using the Logout button on their interface and then login again using the login link in their emails been registered. 

# Technology being used 

## 1. XAMPP
I Used XAMPP to run my PHP programs on my browser. XAMPP is a free and open-source cross-platform web server solution stack package developed by Apache Friends, consisting mainly of the Apache HTTP Server, MariaDB database, and interpreters for scripts written in the PHP and Perl programming languages.
It already had a server (apache) and MYSQL as the database and I would highly recommend using it as you have don't have to install servers and databases seperately.
Here is the Link to Dowload it https://www.apachefriends.org/download.html
you can watch this video to set it up https://www.youtube.com/watch?v=-f8N4FEQWyY

## 2. PHP 
PHP (Hypertext Preprocessor) is known as a general-purpose scripting language that can be used to develop dynamic and interactive websites. It was among the first server-side languages that could be embedded into HTML, making it easier to add functionality to web pages without needing to call external files for data. PHP started out as a small open source project that evolved as more and more people found out how useful it was. Rasmus Lerdorf unleashed the first version of PHP way back in 1994. 

PHP is one of the most widely used language over the web. I'm going to list few of them here:

* PHP performs system functions, i.e. from files on a system it can create, open, read, write, and close them.
* PHP can handle forms, i.e. gather data from files, save data to a file, through email you can send data, return data to the user.
* You add, delete, modify elements within your database through PHP.
* Access cookies variables and set cookies.
* Using PHP, you can restrict users to access some pages of your website.
* It can encrypt data.

Some Resources to learn PHP are as follows :
* https://www.tutorialspoint.com/php/index.htm
* https://www.php.net/
* https://www.w3schools.com/php/

## 3. Ratchet Websocket 
WebSockets are a bi-directional, full-duplex, persistent connection from a web browser to a server. Once a WebSocket connection is established the connection stays open until the client or server decides to close this connection. With this open connection, the client or server can send a message at any given time to the other. This makes web programming entirely event driven, not (just) user initiated. It is stateful. As well, at this time, a single running server application is aware of all connections, allowing you to communicate with any number of open connections at any given time. 

The official Documentation and Installation details can be found on http://socketo.me/docs/

A quick example is below : 

```php
<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

    // Make sure composer dependencies have been installed
    require __DIR__ . '/vendor/autoload.php';

/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class MyChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

    // Run the server application through the WebSocket protocol on port 8080
    $app = new Ratchet\App('localhost', 8080);
    $app->route('/chat', new MyChat, array('*'));
    $app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
    $app->run();
```

Some other sources to learn about the Websocket are as follows (they helped me a lot!) 
* http://socketo.me/docs/
* https://medium.com/@winni4eva/php-websockets-with-ratchet-5e76bacd7548
* https://github.com/ratchetphp/Ratchet

## 4. MySQL (phpMyadmin)
MySQL is a relational database management system based on SQL – Structured Query Language. The application is used for a wide range of purposes, including data warehousing, e-commerce, and logging applications. The most common use for mySQL however, is for the purpose of a web database. It can be used to store anything from a single record of information to an entire inventory of available products for an online store.

In association with a scripting language such as PHP or Perl (both offered on our hosting accounts) it is possible to create websites which will interact in real-time with a mySQL database to rapidly display categorised and searchable information to a website user. Here are a few resources for you to learn MySQL :
* https://dev.mysql.com/doc/
* https://www.w3schools.com/mySQl/default.asp

I used PHPMyadmin to process MySQL databases and tables for my project. 

### PHPMyadmin 
phpMyAdmin is a free software tool written in PHP, intended to handle the administration of MySQL over the Web. phpMyAdmin supports a wide range of operations on MySQL and MariaDB. Frequently used operations (managing databases, tables, columns, relations, indexes, users, permissions, etc) can be performed via the user interface, while you still have the ability to directly execute any SQL statement. 
You can find everything about PHPMyadmin on their official website - https://www.phpmyadmin.net/

## 5. PHP Mailer 
Many PHP developers need to send email from their code. The only PHP function that supports this directly is mail(). However, it does not provide any assistance for making use of popular features such as encryption, authentication, HTML messages, and attachments.

Formatting email correctly is surprisingly difficult. There are myriad overlapping (and conflicting) standards, requiring tight adherence to horribly complicated formatting and encoding rules – the vast majority of code that you'll find online that uses the mail() function directly is just plain wrong, if not unsafe!

The PHP mail() function usually sends via a local mail server, typically fronted by a sendmail binary on Linux, BSD, and macOS platforms, however, Windows usually doesn't include a local mail server; PHPMailer's integrated SMTP client allows email sending on all platforms without needing a local mail server. Be aware though, that the mail() function should be avoided when possible; it's both faster and safer to use SMTP to localhost.
You can find more about on its official repository - https://github.com/PHPMailer/PHPMailer

### Installation Details :
PHPMailer is available on Packagist (using semantic versioning), and installation via Composer is the recommended way to install PHPMailer. Just add this line to your composer.json file:
```
"phpmailer/phpmailer": "^6.5"
```

or run
```
composer require phpmailer/phpmailer
```

It will generate 2 files named VENDOR AND VENDOR/Autoload in your current directly and is ready for use. 

A simple example of the code is below - 
``` php
<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

```

# Challenges faced 

# Scope Of Improvement 

# References 


