<?php
namespace Controllers;
use MVC\Router;
use Model\Admin;
class LoginController{
    public static function login(Router $router){
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);
            //validar los errores
            $errores = $auth->validar();
            //Si esta vacio el arreglo de errores continuamos con la autenticacion
            if (empty($errores)) {
                //Verificar que exista el usuario
                $resultado = $auth->existeUsuario();
                if (!$resultado) {
                    $errores = Admin::getErrores();
                }else{
                    //Verificar el password
                    $autenticado = $auth->verificarPassword($auth->password);
                    if ($autenticado) {
                        //autenticar
                        $auth->autenticar();
                    }else{
                        $errores = Admin::getErrores();
                    }
                }
                
            }
        }
        $router->render('auth/login',['errores'=>$errores]);
    }
    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
}