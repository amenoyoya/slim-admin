<?php

namespace Slim\Framework;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// login inner api
Application::cmd('post', CONFIG['endpoints']['login'], function (Request $request, Response $response, array $args, array $json) {
    if (!isset($json['username']) || !isset($json['password'])) {
        return ['auth' => false, 'message' => 'Invalid parameters'];
    }
    $users = Model\User::find('all', ['conditions' => ['name' => $json['username']]]);
    if (count($users) > 0 && password_verify($json['password'], $users[0]->password)) {
        // tokenを発行しセッションに保存
        $authToken = bin2hex(openssl_random_pseudo_bytes(16));
        $_SESSION['auth_token'] = $authToken;
        $_SESSION['auth_username'] = $users[0]->name;
        // tokenとログインユーザー名を返す
        return ['login' => true, 'token' => $authToken, 'username' => $users[0]->name, 'message' => 'Login as admin'];
    }
    return ['login' => false, 'message' => 'Invalid username or password'];
});

// login confirm inner api
Application::cmd('post', CONFIG['endpoints']['auth'], function (Request $request, Response $response, array $args, array $json) {
    if (!isset($_SESSION['auth_token']) || empty($json['auth_token'])) {
        return ['auth' => false, 'message' => 'Not authenticated yet'];
    }
    if ($_SESSION['auth_token'] !== $json['auth_token']) {
        return ['auth' => false, 'message' => 'Authentication timed out'];
    }
    return ['auth' => true, 'message' => 'Authenticated'];
});

// get session login info inner api
Application::cmd('post', CONFIG['endpoints']['auth_session'], function (Request $request, Response $response, array $args, array $json) {
    if (isset($_SESSION['auth_token']) && isset($_SESSION['auth_username'])) {
        return ['token' => $_SESSION['auth_token'], 'username' => $_SESSION['auth_username']];
    }
    // 基本的に一回しか実行しないように、セッション保存がない場合は適当な token を返す
    return ['token' => 'null', 'username' => ''];
});

// log out inner api
Application::cmd('post', CONFIG['endpoints']['logout'], function (Request $request, Response $response, array $args, array $json) {
    if (isset($_SESSION['auth_token'])) {
        unset($_SESSION['auth_token']);
    }
    if (isset($_SESSION['auth_username'])) {
        unset($_SESSION['auth_username']);
    }
    return ['token' => 'null', 'username' => ''];
});

// sign up inner api
Application::cmd('post', CONFIG['endpoints']['signup'], function (Request $request, Response $response, array $args, array $json) {
    if (!isset($json['username']) || !isset($json['password'])
        || strlen($json['username']) > 15 || strlen($json['password']) > 30
    ) {
        return ['reg' => false, 'message' => 'Invalid parameters'];
    }
    $users = Model\User::find('all', ['conditions' => ['name' => $json['username']]]);
    if (count($users) > 0) {
        return ['reg' => false, 'message' => "User '{$json['username']}' already exists"];
    }
    // register
    $date = new \DateTime();
    $user = new Model\User();
    $user->name = $json['username'];
    $user->password = password_hash($json['password'], PASSWORD_BCRYPT);
    if ($user->save()) {
        return ['reg' => true, 'message' => "User '{$user->name}' registered"];
    }
    return ['reg' => false, 'message' => 'Database error occured'];
});

/**
 * mail test
 */
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

Application::get('/mail/', function (Request $request, Response $response, array $args) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'mailhog';                              // Specify main and backup SMTP servers
        // $mail->SMTPAuth   = false;
        // $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 1025;                                   // TCP port to connect to

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('to@example.net', 'Joe User');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $response->getBody()->write('Message has been sent');
        return $response;
    } catch (Exception $e) {
        $response->getBody()->write("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return $response;
    }
});
