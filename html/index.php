<?php
spl_autoload_register(function ($classname) {
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
        . $classname . '.php';
});
$utils = new \utils\utils();
session_name("ChocolateChipSessionCookie");
$_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1' ? session_set_cookie_params(0, '/', '', false, true) : session_set_cookie_params(0, '/', '', true, true);
$utils->headers();
session_start();
$utils->RememberMe();
$_SESSION['current'] = '';
try {
    $_SESSION['csrf_guest'] = bin2hex(random_bytes(16));
} catch (\Random\RandomException $e) {
}
$urlParse = explode('/', $_SERVER['REQUEST_URI']);
if (isset($urlParse[1]) && isset($urlParse[2])) {
    $classname = '\Controllers\\' . ucfirst($urlParse[1]) . 'Controller';
    if (class_exists($classname)) {
        $controller = new $classname;
        $action = $urlParse[2];
        if (isset($urlParse[3]) && $urlParse[2] == 'modify') {
            $controller->modify($urlParse[3]);
        } else if (method_exists($controller, $action)) {
            $_SESSION['current'] = $action;
            $controller->$action();
        } else if (str_contains($urlParse[2], "change?token=")) {
            $action = 'change';
            $_SESSION['current'] = 'change';
            $controller->$action();
        } else if (str_contains($urlParse[2], "activate?token=")) {
            $action = 'activate';
            $_SESSION['current'] = 'activate';
            $controller->$action();
        }
    }
} else {
    $controllerName = '\Controllers\HomeController';
    $controller = new $controllerName;
    $actionName = 'home';
    $_SESSION['current'] = 'home';
    $controller->$actionName();
}
