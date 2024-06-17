<?php

class LoginController
{
    public function loginAction()
    {
        if ($_POST) {
            $user = User::findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user->password)) {
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $user->firstname;

                // aus Sicherheitsgründen neue Session-Id vergeben
                session_regenerate_id();
                header('Location: ' . APP_URL . '/loggedin', TRUE, 307);
                exit;
            } else {
                $message = 'Die Kombination Benutzername und Kennwort stimmen nicht überein!';
            }
        }

        // require APP_ROOT . '/src/templates/user_login.tpl.php';
        $template =  'user_login.tpl.php';

/*         return [
            'user' => $user ?? NULL,
            'message' => $message ?? NULL,
            'template' => $template,
        ]; */
        $this->render([
            'user' => $user ?? NULL,
            'message' => $message ?? NULL,
            'template' => $template,
        ]);
    }

    public function logoutAction()
    {
        ## Session zurücksetzen
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {  // Auslesen aus php.ini, ob die Session Cookie-basiert arbeitet
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header('Location: ' . APP_URL . '/login', TRUE, 307); // Location angepasst

    }

    public function loggedinAction()
    {
        if (empty($_SESSION['loggedin'])) {
            header('Location: ' . APP_URL . '/login', TRUE, 307); // Location angepasst
            exit;
        }

        // require APP_ROOT . '/src/templates/loggedin.tpl.php';
        $template = 'loggedin.tpl.php';

/*         return [
            'template' => $template,
        ]; */
        $this->render([
            'template' => $template,
        ]);
    }

    protected function render(array $data = [])
    {
        extract($data);
        require APP_ROOT . '/src/templates/' . $template; 
    }
}
