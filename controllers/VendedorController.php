<?php
namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController{
    public function index(Router $router){
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;
        $router->render('vendedores/index',['vendedores'=>$vendedores,'resultado'=>$resultado]);
    }
    public function crear(Router $router){
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;
        //Este codigo se ejecuta cuando se intenta guadar un vendedor
        if ($_SERVER['REQUEST_METHOD'==='POST']) {
            //CREAMOS UNA NUEVA INSTANCIA DE VENDEDOR
            $vendedor = new Vendedor($_POST['vendedor']);
            //validar
            $errores = $vendedor->validar();

            if (empty($errores)) {
                //Si no hay errores guardamos los datos en la db
                $resultado = $vendedor->guardar();
                if ($resultado) {
                    header('location: /vendedores');
                }
            }
        }

        $router->render('vendedores/crear',['errores'=>$errores,'vendedor '=>$vendedor]);

    }
    public function actualizar(Router $router){
        $id = validarORedireccionar('/admin');
        //Obtener los datos de la propiedad
        $vendedor = Vendedor::find($id);
        //arreglo de mensajes
        $errores = Vendedor::getErrores();
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            //ASIGNAR LOS ATRIBUTOS
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);
            //validacion
            $errores = $vendedor->validar();
            if (empty($errores)) {
                header('location: /admin');
            }
        }
    }
    public function eliminar(){
        if ($_SERVER['REQUEST_METHOD']==='POST') {
        
            
            //validacion
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            
            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
    
            }
        }
    }
}