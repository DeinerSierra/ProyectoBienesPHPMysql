<?php
namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{
    public static function index(Router $router){
        $propiedades = Propiedad::get(3);
        $inicio = true;
        $router->render('paginas/index',['propiedades'=>$propiedades, 'inicio'=>$inicio]);
    }
    public static function nosotros(Router $router){
        $router->render('paginas/nosotros',[]);
    }
    public static function propiedades(Router $router){
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades',['propiedades'=>$propiedades]);
    }
    public static function propiedad(Router $router){
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad',['propiedad'=>$propiedad]);
    }
    public static function blog(Router $router){
        $router->render('paginas/blog',[]);
    }
    public static function entrada(Router $router){
        $router->render('paginas/entrada',[]);
    }
    public static function contacto(Router $router){
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $respuestas = $_POST['contacto'];
            //Crear una instancia de phpmailer
            $mail = new PHPMailer();
            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host =$_ENV['EMAIL_HOST'] ;
            $mail->SMTPAuth = true;
            $mail->Port =$_ENV['EMAIL_PORT'] ;
            $mail->Username =$_ENV['EMAIL_USER'] ;
            $mail->Password =$_ENV['EMAIL_PASS'] ;
            $mail->SMTPSecure = 'tls';
            //Configuracion del contenido del email
            $mail->setFrom('admin@bienes.com');
            $mail->addAddress('admin@bienes.com','BienesImmuebles.com');
            $mail->Subject ='Tienes un nuevo mensaje';
            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: '. $respuestas['nombre'] .'</p>';
            
            //enviar de forma condicional email o telefono
            if ($respuestas['contacto']==='telefono') {
                $contenido .='<p>Eligio ser contactado por telefono</p>';
                $contenido .= '<p>Telefono: '. $respuestas['telefono'] .'</p>';
                $contenido .= '<p>Fecha contactado: '. $respuestas['fecha'] .'</p>';
                $contenido .= '<p>Hora contactado: '. $respuestas['hora'] .'</p>';
            }else {
                $contenido .='<p>Eligio ser contactado por email</p>';
                $contenido .= '<p>Email: '. $respuestas['email'] .'</p>';
            }
            
            $contenido .= '<p>Mensaje: '. $respuestas['mensaje'] .'</p>';
            $contenido .= '<p>Vende o Compra: '. $respuestas['tipo'] .'</p>';
            $contenido .= '<p>Precio o Presupuesto: $'. $respuestas['precio'] .'</p>';
            $contenido .= '<p>Prefiere ser contactado por: '. $respuestas['contacto'] .'</p>';
            
            $contenido .= '</html>';
            $mail->Body = $contenido;
            //Enviar el email
            if ($mail->send()) {
                $mensaje = 'Mensaje enviado correctamente';
            } else {
                $mensaje = 'Hubo un error';
            }
            
        }
        $router->render('paginas/contacto',['mensaje'=>$mensaje]);
    }
}