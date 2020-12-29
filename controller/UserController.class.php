<?php
class UserController extends Controller
{
    public $view = 'user';
    public $title = 'Вход';
    public $description = 'Описание страницы';
    public $longtitle = 'Вход';
    
    public function logout(){
        if (User::alreadyLoggedIn($_SESSION['user'] ?? false)) {
            User::logOut();
        }

        return ['newView' => 'login'];
    }

    public function login() {
        $result = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData = User::authWithCredentials(
                $_POST['login'],
                $_POST['password'],
            );

            if (empty($userData)) {
                $result['authError'] = 'Неверный логин или пароль';
            } else {
                $_SESSION['user'] = $userData;
                header('Location: /');
            }
        }
        if (User::alreadyLoggedIn($_SESSION['user'] ?? false)) {
            $result['tasks'] = Task::getMany();
            $result['newView'] = 'index';
        }

        return $result;
    }
}