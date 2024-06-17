<?php

class UserController
{
    public function userListAction()
    {
        ## Userdaten einlesen

        $users = User::findAll();

        // neues Array mit den deutschen Spaltenbezeichnern
        $columnNamesDe = [
            'id' => 'Id',
            'firstname' => 'Vorname',
            'lastname' => 'Nachname',
            'email' => 'E-Mail',
            // 'password' => 'Passwort',
            'role' => 'Rolle',
            'created_at' => 'registriert seit',
            'updated_at' => 'geändert am',
        ];

        // require APP_ROOT . '/src/templates/user_list.tpl.php';
        $template = 'user_list.tpl.php';

/*         return [
            'users' => $users,
            'columnNamesDe' => $columnNamesDe,
            'template' => $template,
        ]; */
        $this->render([
            'users' => $users,
            'columnNamesDe' => $columnNamesDe,
            'template' => $template,
        ]);
    }


    public function userEditAction()
    {
        // einen User anhand seiner Id heraussuchen

        // $id = 99;
        $id = 25;

        $user = User::find($id) ?? exit("kein User mit der Id = $id gefunden!");

        // require APP_ROOT . '/src/templates/user_edit.tpl.php';
        $template = 'user_edit.tpl.php';

/*         return [
            'user' => $user,
            'template' => $template,
        ]; */
        $this->render([
            'user' => $user,
            'template' => $template,
        ]);

        // alternativ

        // return compact('user', 'template');
    }

    public function registerAction()
    {

        // wir haben die Logik noch nicht implementiert

        // require APP_ROOT . '/src/templates/user_register.tpl.php';
        $template =  'user_register.tpl.php';

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
