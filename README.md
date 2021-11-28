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

## 1. PHP 
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

## 2. Ratchet Websocket 
WebSockets are a bi-directional, full-duplex, persistent connection from a web browser to a server. Once a WebSocket connection is established the connection stays open until the client or server decides to close this connection. With this open connection, the client or server can send a message at any given time to the other. This makes web programming entirely event driven, not (just) user initiated. It is stateful. As well, at this time, a single running server application is aware of all connections, allowing you to communicate with any number of open connections at any given time. 

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
## 3. MySQL 
## 4. PHP Mailer 
## 5. Interface Design - HTML , CSS , Javascript 

# Challenges faced 

# Scope Of Improvement 

# References 


