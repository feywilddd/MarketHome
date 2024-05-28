<?php

namespace Controllers;

use utils\utils;

class AuthController
{
    public function login()
    {
        $utils = new utils();
        $loggedIn = true;
        $repo = new \repositories\UserRepository();
        $userClient = new \models\User();
        $user = new \models\User();
        $username = false;
        $firstLogin = true;
        if (!isset($_SESSION['csrf_login'])) {
            $csrf_token = $utils->hacherCSRF('login');
            $_SESSION['csrf_login'] = $csrf_token;
        }
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_login']) {
            if ($_POST['UsernameInput'] == '') {
                $error = 'Veuiller entrer un nom';
            } else if ($_POST['PasswordInput'] == '') {
                $error = 'Veuiller entrer un mot de passe';
                $username = $_POST['UsernameInput'];
            } else {
                $userClient->username = $_POST['UsernameInput'];
                $userClient->password = $_POST['PasswordInput'];
                if (!($repo->searchUser($userClient))) {
                    $error = 'Nom d\'utilisateur ou mot de passe invalide';
                    $username = $_POST['UsernameInput'];
                } else {
                    $user = $repo->searchUser($userClient)[0];
                    if (!password_verify($userClient->password, $user->password)) {
                        $error = 'Nom d\'utilisateur ou mot de passe invalide';
                        $username = $_POST['UsernameInput'];
                    } else if (!$user->isValid) {
                        if ($user->tokenTime > time()) {
                            $error = 'Compte non-actif, vous pouvez aller activer votre compte à l\'aide du courriel envoyé précédemment.';
                            $username = $_POST['UsernameInput'];
                        } else {
                            $error = 'Compte non-actif, un courriel d\'activation a été envoyé à cette adresse.';
                            $username = $_POST['UsernameInput'];
                            $activationToken = bin2hex(random_bytes(16));
                            $activationLink = "http://localhost/auth/activate?token=$activationToken";
                            $utils->Activate($activationLink, $user->username);
                            $repo->addToken($user, $activationToken);
                        }
                    } else {
                        if (isset($_POST['RememberMe'])) {
                            $token = bin2hex(random_bytes(12));
                            $expiry = time() + (86400 * 7);
                            $data = (object)array("token" => $token);
                            setcookie('RememberMe', json_encode($data), $expiry, "/");
                            $user->RememberMeTime = $expiry;
                            $repo->setRememberMe($user, $token);
                        }
                        $user->password = "";
                        $_SESSION['user'] = $user;
                        $_SESSION['1login'] = $firstLogin;
                        $_SESSION['nbItems'] = 0;
                        session_regenerate_id(true);
                        header('Location: /home/home');
                        die();
                    }
                }
            }
        }
        if (!isset($_SESSION['user'])) {
            require_once '../views/_navAnonymous.php';
            require_once '../views/auth/login.php';
        } else {
            header('Location: ../home/home');
            die();
        }


    }

    public function forgot()
    {
        $utils = new utils();
        $loggedIn = true;
        $repo = new \repositories\UserRepository();
        $userClient = new \models\User();
        $user = new \models\User();
        $username = false;
        $firstLogin = true;
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['UsernameInput'] == '') {
                $error = 'Veuiller entrer un nom';
            } else {
                $userClient->username = $_POST['UsernameInput'];
                if (!($repo->searchUser($userClient))) {
                    $error = 'Nom d\'utilisateur invalide';
                    $username = $_POST['UsernameInput'];
                } elseif (!filter_var($_POST['UsernameInput'], FILTER_VALIDATE_EMAIL)) {
                    $error = 'Veuiller entrer une adresse couriel valide';
                } else {
                    $success = 'Un courriel a été envoyé à cette adresse avec succès!';
                    $activationToken = bin2hex(random_bytes(16));
                    $activationLink = "http://localhost/auth/change?token=$activationToken";
                    $utils->Forgot($activationLink, $_POST['UsernameInput']);
                    $userClient = $repo->searchUser($userClient)[0];
                    $repo->addToken($userClient, $activationToken);
                }
            }
        }

        if (!isset($_SESSION['user'])) {
            require_once '../views/_navAnonymous.php';
            require_once '../views/auth/forgot.php';
        } else {
            header('Location: ../home/home');
            die();
        }
    }

    public function change()
    {
        $utils = new utils();
        $repo = new \repositories\UserRepository();
        $user = new \models\User();
        $username = false;
        $firstLogin = true;
        $error = '';
        $success = '';

        if (!isset($_SESSION['csrf_change'])) {
            $csrf_token = $utils->hacherCSRF('change');
            $_SESSION['csrf_change'] = $csrf_token;
        }

        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            if (!($repo->getUserByToken($token))) {
                header('Location: ../home/home');
                die();
            }
        } else {
            header('Location: ../home/home');
            die();
        }
        $user = $repo->getUserByToken($token)[0];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_change']) {
            if (empty($_POST['newPassword']) || empty($_POST['confirmPassword'])) {
                $error = 'Veuillez remplir tous les champs';
            } elseif ($_POST['newPassword'] !== $_POST['confirmPassword']) {
                $error = 'Les nouveaux mots de passe ne correspondent pas';
            } elseif (strlen($_POST['newPassword']) < 8) {
                $error = 'Veuiller entrer un mot de passe de plus de 8 caractères';
            } else {
                $hashedPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
                $repo->updatePassword($user->id, $hashedPassword);
                $success = 'Votre mot de passe à bien été modifier';
            }
            require_once '../views/_navAnonymous.php';
            require_once '../views/auth/change.php';
        }
        require_once '../views/_navAnonymous.php';
        require_once '../views/auth/change.php';
    }


    public function register()
    {
        $utils = new utils();
        $repo = new \repositories\UserRepository();
        $user = new \models\User();
        $username = false;
        if (!isset($_SESSION['csrf_register'])) {
            $csrf_token = $utils->hacherCSRF('register');
            $_SESSION['csrf_register'] = $csrf_token;
        }
        $error = '';
        $success = '';
        $firstLogin = true;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_register']) {
            if ($_POST['UsernameInput'] == '') {
                $error = 'Veuiller entrer un nom';
            } else if ($_POST['PasswordInput'] == '') {
                $error = 'Veuiller entrer un mot de passe';
                $username = $_POST['UsernameInput'];
            } else if ($_POST['PasswordConfirmationInput'] == '') {
                $error = 'Veuiller entrer une confirmation de votre mot de passe';
                $username = $_POST['UsernameInput'];
            } else if ($_POST['PasswordConfirmationInput'] != $_POST['PasswordInput']) {
                $error = 'Veuiller entrer une confirmation identique à votre mot de passe';
                $username = $_POST['UsernameInput'];
            } else if (strlen($_POST['PasswordInput']) < 8) {
                $error = 'Veuiller entrer un mot de passe de plus de 8 caractères';
                $username = $_POST['UsernameInput'];
            } else {
                $user->username = $_POST['UsernameInput'];
                $user->password = password_hash($_POST['PasswordInput'], PASSWORD_DEFAULT);
                if (isset($repo->searchUser($user)[0])) {
                    $success = 'Un courriel a bien été envoyé, cliquez sur le lien reçu pour activer votre compte. Vous pouvez fermer cet onglet.';
                    $username = $_POST['UsernameInput'];
                } elseif (!filter_var($_POST['UsernameInput'], FILTER_VALIDATE_EMAIL)) {
                    $error = 'Veuiller entrer une adresse couriel valide';
                } else {
                    $jeton = bin2hex(random_bytes(12));
                    $echeance = time() + 3600;
                    $user->restToken = $jeton;
                    $user->tokenTime = $echeance;
                    $repo->createUser($user);
                    $utils->Activate("http://localhost/auth/activate?token=$jeton", $user->username);
                    $success = 'Un courriel a bien été envoyé, cliquez sur le lien reçu pour activer votre compte. Vous pouvez fermer cet onglet.';
                }
            }
        }
        if (!isset($_SESSION['user'])) {
            require_once '../views/_navAnonymous.php';
            require_once '../views/auth/register.php';
        } else {
            header('Location: ../home/home');
            die();
        }
    }

    public function activate()
    {
        $utils = new utils();
        $repo = new \repositories\UserRepository();
        $user = new \models\User();
        $username = false;
        $firstLogin = true;
        $error = '';
        $success = '';

        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            if (!($repo->getUserByToken($token))) {
                header('Location: ../home/home');
                die();
            }
        }
        $token = $_GET['token'];
        $user = $repo->getUserByToken($token)[0];
        if ($user->tokenTime < time()) {
            header('Location: ../home/home');
            $_SESSION['errorMessage'] = 'Votre courriel d\'activation était échue, un nouveau courriel vous à été envoyer';
            $user->tokenTime = time() + 3600;
            $repo->setTokenTime($user);
            $utils->Activate("http://localhost/auth/activate?token=$token", $user->username);
            die();
        }
        $repo->setValid($user);
        $user->password = "";
        $_SESSION['user'] = $user;
        $_SESSION['1login'] = $firstLogin;
        $_SESSION['nbItems'] = 0;
        session_regenerate_id(true);
        header('Location: /home/home');
        die();
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        $expiry = time() - 3600;
        $data = (object)array("expiry" => $expiry);
        setcookie('RememberMe', json_encode($data), $expiry, "/");
        header("Location: ../home/home");
        die();
    }
}