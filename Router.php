<?php
namespace MVC;
class Router{
    //DEFINIMOS LAS RUTAS GET Y POST
    public $rutasGET = [];
    public $rutasPOST = [];
    public function get($url,$fn){//toma la url actual y la funcion asociada a esa url
        $this->rutasGET[$url] = $fn; // inicializamos rutas get y al la url es igual a la funcion
    }
    public function post($url,$fn){//toma la url actual y la funcion asociada a esa url
        $this->rutasPOST[$url] = $fn; // inicializamos rutas get y al la url es igual a la funcion
    }
    public function comprobarRutas()
    {   //areglo de rutas protegidas
        session_start();
        $auth = $_SESSION['login'] ?? null;
        $rutas_protegidas = [
            '/admin','/propiedades/crear','/propiedades/actualizar','/propiedades/eliminar',
            '/vendedores/crear','/vendedores/actualizar','/vendedores/eliminar'
        ];
        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        //$urlActual = $_SERVER['PATH_INFO'] ?? '/';//Obtenemos la url
        $method = $_SERVER['REQUEST_METHOD'];//OBTENEMOS EL METODO DE LA PETICION
        if ($method ==='GET') {//Leemos la funcion asociada a la url
            $fn = $this->rutasGET[$urlActual] ?? null;
        }else{
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }
        //Proteger las rutas
        if (in_array($urlActual,$rutas_protegidas) && !$auth) {
            header('Location: /');
        }
        if ($fn) {
            //La url existe y hay una funcion
            call_user_func($fn,$this);//permite llamar una funcion cuando no sabemos como se llama
        }else {
            echo "Pagina no encontrada";
        }
    }
    //Mostrar una vista pasada como argumento
    public function render($vista,$datos=[]){//Este metodos se llama desde los controladores para renderizar una vista
        //Recorrer el array asoc pasado como datos para las vistas
        foreach($datos as $key => $value){
            $$key = $value;
        }
        ob_start();//Inicia un alamcenamiento en memoria
        include __DIR__."/views/$vista.php";
        $contenido = ob_get_clean();
        include __DIR__."/views/layout.php";
    }
}