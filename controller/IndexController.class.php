<?php

class IndexController extends Controller
{
    public $view = 'index';
    public $title = 'Главная';
    public $description = 'Описание страницы';
    public $longtitle = 'Главная';

    public function index($data)
    {
        $tasks = Task::getMany();

        return [
            'tasks' => $tasks,
            'admin' => User::isAdmin(
                User::alreadyLoggedIn(
                    $_SESSION['user'] ?? false
                )
            )
        ];
    }
}