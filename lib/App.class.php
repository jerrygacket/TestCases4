<?php

class App
{
    public static function Init()
    {
        date_default_timezone_set('Europe/Moscow');
        if (isset($_POST['asAjax']) && $_POST['asAjax']) {
            $controllerName = ucfirst($_POST['element']) . 'Controller';
            $methodName = isset($_POST['action']) ? $_POST['action'] : 'index';
            $controller = new $controllerName();
            echo json_encode(['result' => $controller->$methodName($_POST)]);
            return true;
        }

        if (php_sapi_name() !== 'cli' && isset($_SERVER) && isset($_GET)) {
            self::web($_SERVER['REQUEST_URI']);
        }

        return false;
    }

    protected static function web($url)
    {
        $url = explode("/", $url);

        $_GET['page'] = (!empty($url[1]) ? $url[1] : 'Index');

        if (isset($_GET['page'])) {
            $controllerName = ucfirst($_GET['page']) . 'Controller';
            $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
            $controller = new $controllerName(strtolower($_GET['page']));
            $data = [
                'content_data' => $controller->$methodName($_GET),
                'page' => $controller->getPageInfo(),
                'login' => User::checkLogin($_SESSION['user'] ?? false),
                'site' => Config::get('site'),
            ];

            if (isset($data['content_data']['newView'])) {
                $newView = explode("/", $data['content_data']['newView']);
                $view = ($newView[1] ? $newView[1] : $controller->view) . '/' . $data['content_data']['newView'] . '.html';
            } else {
                $view = $controller->view . '/' . $methodName . '.html';
            }

            if (!isset($_GET['asAjax'])) {
                $loader = new \Twig\Loader\FilesystemLoader(Config::get('path_templates'));
                $twig = new \Twig\Environment($loader);
                $template = $twig->loadTemplate($view);
                echo $template->render($data);
            }
        }
    }
}
