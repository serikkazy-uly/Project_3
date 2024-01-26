<?php

namespace App\controllers;

use App\exceptions\AccountIsBlockedException;
use App\exceptions\NotEnoughMoneyException;
use App\QueryBuilder;
use Exception;   
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;
use function Tamtamchik\SimpleFlash\flash;

class HomeController
{

    private $templates;
    private $flash;  
    public function __construct()
    {
        $this->templates = new Engine('../app/views');
        $this->flash = new Flash();
    }
    public function index($vars)
    {
        
        // d($vars);die;
        $db = new QueryBuilder();
        $posts = $db->getAll('posts');
        // Render a template
        echo $this->templates->render('homepage', ['postsInView' => $posts]);
        // d($vars);exit;
    }

    public function about($vars)
    {
        try {
            $this->withdraw($vars['amount']);
            // exit;
            // d($vars);die;
        } catch (NotEnoughMoneyException $exception) {
            flash()->message("Недостаточно средств");
            // d(flash()->message());
            // echo $exception->getMessage();
        } catch (AccountIsBlockedException $exception) {
            flash()->message("Вы заблокированы");
        }
        echo $this->templates->render('about', ['name' => 'Page about Jonathan', 'flash' => $this->flash]);
    }
    
    
    // Exception - для пользователей обр ошибок согласно логике проекта
    public function withdraw($amount = 1)
    {
        $total = 10;
        // throw new AccountIsBlockedException("Your accaunt is b  locked");
        if ($amount > $total) {
            throw new NotEnoughMoneyException("Not enough money");
            // d($amount);die;
            // d($total);die;
        }
    }
}
