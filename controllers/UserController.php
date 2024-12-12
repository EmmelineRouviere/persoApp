<?php 

class UserController {

    public function displayFormConnexion(){


        include './views/User/connexion.php';
    }

    public function logIn()
    {
        try {
            $model = new UserModel();
            $user = $model->connexion();
            if($user)
            {
                $_SESSION[APP_TAG]['user'] = [
                    'id' => $user['use_id'],
                    'login' => $user['use_login'],
                    'role' => $user['rol_id'],
                    'power' => $user['rol_power'],
                    'firstname' => $user['use_firstname'],
                    'lastname' => $user['use_lastname'],
                    'company' => $user['use_company']
                ];
               
                header('Location: ?connexion=success');
                exit();

            }
            else
            {
                header('Location: ?connexion=error');
                exit();
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function connected(){
        $_SESSION['page'] = 'Profile'; 
        include './views/User/profile.php';
    }

    public function logout()
    {
        if(isset($_GET['action']) && $_GET['action'] == 'logout')
        {
            unset($_SESSION[APP_TAG]['connected']);
            session_destroy(); 
            header('Location: index.php?ctrl=user&action=index');
            exit;
        }
        
    }

    public function registration(){

        $modelObjectif = new ObjectifModel;
        $dataObjectives = $modelObjectif->getAllObjectif();
        
        foreach ($dataObjectives as $data) {
            $objectives[] = new Objectif($data);
        }
        
        include './views/User/registration.php';
    }

}