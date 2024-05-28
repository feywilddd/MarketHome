<?php

namespace utils;

use Couchbase\User;
use PHPMailer\PHPMailer\PHPMailer;

class utils
{
    public static function headers()
    {
        header("X-Frame-Options: DENY");
        header("Content-Security-Policy: default-src 'self' cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css  https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff  https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff2 cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js; frame-ancestors 'none'", false);
        header_remove('x-powered-by');
    }

    public static function xss_safe(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public static function calculateSubTotal(array $products): float
    {
        $total = 0;
        foreach ($products as $product) {
            $total += ($product[0]->price * $product[1]);
        }
        return $total;
    }

    public function calculateTPS(float $subTotal): float
    {
        return round($subTotal * 0.05, 2);
    }

    function calculateTVQ(float $subTotal): float
    {
        return round($subTotal * 0.0975, 2);
    }

    function calculateTotal(float $subTotal, float $tvq, float $tps): float
    {

        return $subTotal + $tvq + $tps;
    }

    function calculateGains(float $subTotal, int $quantity): float
    {
        return $subTotal * 0.98 - ($quantity * 0.10);
    }

    public function hacherCSRF(string $id_formulaire)
    {
        if (isset($_SESSION['csrf_user']))
            $hashage = $_SESSION['csrf_user'] . $id_formulaire;
        else
            $hashage = $_SESSION['csrf_guest'] . $id_formulaire;

        return hash('sha256', $hashage);
    }

    public function estExpireToken(int $temps)
    {
        return time() < $temps;
    }

    public function RememberMe()
    {
        if (isset($_SESSION['user']))
            return;
        if (isset($_COOKIE['RememberMe'])) {
            $cookie = json_decode($_COOKIE['RememberMe']);
            $repo = new \repositories\UserRepository();
            if ($repo->getUserByRememberMe($cookie->token)) {
                $user = $repo->getUserByRememberMe($cookie->token)[0];
                if ($this->estExpireToken(intval($user->RememberMeTime))) {
                    $user->password = "";
                    $_SESSION['user'] = $user;
                    $_SESSION['1login'] = true;
                    $_SESSION['nbItems'] = 0;
                }
            }
        }
    }

    public function Activate(string $link, string $user)
    {
        include_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        include_once '../vendor/phpmailer/phpmailer/src/SMTP.php';
        include_once '../vendor/phpmailer/phpmailer/src/Exception.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '3ef01e1f8c8e92';
            $mail->Password = '9e21903da3a7b2';

            $mail->setFrom('jaclev34@gmail.com', 'MarketHome');

            $mail->addAddress($user);

            $mail->isHTML(true);
            $mail->Subject = 'Activer Votre compte MarketHome';
            $mail->Body = "Afin d\'activer votre compte MarketHome, cliquez sur le lien suivant : <br> <a href=\"$link\">Activer!</a>>";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function Forgot(string $link, string $user)
    {
        include_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        include_once '../vendor/phpmailer/phpmailer/src/SMTP.php';
        include_once '../vendor/phpmailer/phpmailer/src/Exception.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '3ef01e1f8c8e92';
            $mail->Password = '9e21903da3a7b2';

            $mail->setFrom('jaclev34@gmail.com', 'MarketHome');

            $mail->addAddress($user);

            $mail->isHTML(true);
            $mail->Subject = 'Changer le mot de passe de compte MarketHome';
            $mail->Body = "Afin de changer votre mot de passe, cliquez sur le lien suivant : <br><a href=\"$link\">Changer mon mot de passe!</a>";
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}