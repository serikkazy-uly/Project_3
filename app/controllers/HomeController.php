<?php

namespace App\controllers;

use App\exceptions\AccountIsBlockedException;
use App\exceptions\NotEnoughMoneyException;
use App\QueryBuilder;
use Exception;
use function Tamtamchik\SimpleFlash\flash;
use League\Plates\Engine;
use PDO;
use Tamtamchik\SimpleFlash\Flash;

class HomeController
{

    private $templates;
    private $flash;
    private $auth;
    public function __construct()
    {
        $this->templates = new Engine('../app/views');
        $this->flash = new Flash();
        $db = new PDO("mysql:host=mysql; dbname=laravel;charset=utf8;", "user", "secret");
        $this->auth = new \Delight\Auth\Auth($db);
    }
    public function index($vars)
    {
        // var_dump($this->auth->admin()->addRoleForUserById(1, \Delight\Auth\Role::ADMIN));
        d($this->auth->getRoles());
        die;
        // d($this->auth->isLoggedIn());die; 
        // $this->auth->login('dana@gmail.com', '123');die;
        try {
            $this->auth->admin()->addRoleForUserById(1, \Delight\Auth\Role::ADMIN);
        } catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown user ID');
        }
        die;

        $db = new QueryBuilder();
        $posts = $db->getAll('posts');
        // Render a template
        echo $this->templates->render('homepage', ['postsInView' => $posts]);
        // d($vars);exit;
    }

    public function user()
    {
        try {
            $userId = $this->auth->register('dana@gmail.com', '123', 'Dana', function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        // echo $this->templates->render('user', ['name' => 'Page user Jonathan', 'flash' => $this->flash]);
    }


    // Exception - для пользователей обр ошибок согласно логике проекта
    public function email_verification()
    {
        try {
            $this->auth->confirmEmail('Lc6isy6HG1F4Vi34', 'YoCN5sAVfqBP1g6J');

            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function login()
    {
        try {
            $this->auth->login('dana@gmail.com', '123');

            echo 'User is logged in';
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}
