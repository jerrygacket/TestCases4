<?php

class User {
    public static $table = 'users';

    public static function alreadyLoggedIn($userData) {
        return ($userData['id'] ?? false);
    }

    public static function logOut() {
        session_destroy();
        header('Location: /user/?action=login');
    }

    /**
     * авторизация через логин и пароль
     */
    public static function authWithCredentials($username = '', $password = '')
    {
        $sql = 'SELECT id,username,passwordHash,isAdmin FROM users WHERE username = :username';

        $userData = db::getInstance()->Query($sql, ['username' => $username], true);

        if ($userData) {
            if (password_verify($password,$userData['passwordHash']) && ($userData['isAdmin'] == 1)) {
                return $userData;
            }
        }

        return [];
    }

    public static function checkLogin($userData) {
        if (self::alreadyLoggedIn($userData)) {
            $result = [
                'login' => true,
                'text' => 'Выход ('.$userData['username'].')',
                'link' => 'logout',
            ];
        } else {
            $result = [
                'login' => false,
                'text' => 'Вход',
                'link' => 'login',
            ];
        }

        return $result;
    }

    public static function isAdmin($id = false) {
        if (!$id) {
            return false;
        }
        $sql = 'SELECT isAdmin FROM users WHERE id=:id';
        $result = db::getInstance()->Query($sql, ['id' => $id], true);

        return ($result['isAdmin'] ?? false);
    }
}
