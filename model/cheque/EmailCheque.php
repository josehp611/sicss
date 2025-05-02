<?php

require_once dirname(__FILE__).'/../../class/PHPMailer/PHPMailerAutoload.php';

class EmailCheque{
    private $email;
    private $error;

    public function __construct(){
        $this->email=new PHPMailer;
        $this->email->SMTPDebug = 0;
        $this->email->isSMTP();
        $this->email->Host = '192.168.43.130';
        $this->email->isHTML(true);
		$this->email->addBCC('dsistemas@impressa.com','Seguimiento SC');
    }

    public function notificar_solicitud_creada($cheque){
        
        $body = "<p>".$cheque->usuario." le ha enviado la solicitud de cheque #".$cheque->id." para su autorizacion.</p>";
        $this->email->Subject = "Solicitud de cheque para autorizacion #".$cheque->id.".";
        $this->email->Body    = $body;

        if(!$this->email->send()) {
            $this->error=$this->email->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
    
    public function notificar_solicitud($email,$state,$status,$id_solicitud,$perfil){
        $msj = array();
        $id_solicitud=str_pad($id_solicitud, 6,'0',STR_PAD_LEFT);
        $correo_from = "solicitud@impressa.com";
        $body="";
        if($state=='send'){
            if($status=='N1' || $status=='N2' || $status=='N3'){
                $body = "<p><b>".$perfil->nombre."</b> le ha enviado la solicitud de cheque <b>#".$id_solicitud."</b> para su autorizacion.</p>";
                $this->email->Subject = "Solicitud de cheque para autorización #".$id_solicitud.".";
            }else if($status=='N4'){
                $body = "<p><b>Se ha autorizado solicitud de cheque <b>#".$id_solicitud."</b>.</p>";
                $this->email->Subject = "Solicitud de cheque autorizada #".$id_solicitud.".";
            }
            $this->email->Body = $body;
            $this->email->setFrom($correo_from, 'Solicitud de Cheque'); //Utilizar correo para enviar solicitud de cheque
            if($status=='N1' || $status=='N2' || $status=='N4'){
                foreach ($email as $correo) {
                    $this->email->addAddress($correo->email, $correo->nombre);
                    echo "\n * email: ".$correo->email." de: ".$correo->nombre;
                }
                echo "Result ".$this->email->send();
            }else if($status=='N3'){
                $this->email->addAddress($email->email, $email->nombre);
                echo "\n - email: ".$email->email." de: ".$email->nombre;
                echo "Result ".$this->email->send();
            }
        }else if($state=='fail'){
            $body = "<p><b>".$perfil->nombre."</b> ha desistido la solicitud de cheque <b>#".$id_solicitud."</b>.</p>";
            $this->email->Subject = "Solicitud de cheque desistida #".$id_solicitud.".";
            $this->email->Body = $body;
            $this->email->setFrom($correo_from, 'Solicitud de Cheque');
            $this->email->addAddress($email->email, $email->nombre);
            echo "\n D email: ".$email->email." de: ".$email->nombre;
            echo "Result ".$this->email->send();
        }
    }

    public function send_email($msg){
        $id_solicitud=str_pad($msg['id_solicitud'], 6,'0',STR_PAD_LEFT);
        $this->email->setFrom('solicitud@impressa.com', 'Solicitud de Cheque');
        if($msg['avance']!='N5' && ($msg['status']=='R' || $msg['status']=='Z')){
            $this->email->Subject = "Solicitud de cheque para autorización #".$id_solicitud.".";
        }else if($msg['avance']=='N5' && $msg['status']=='R'){
            $this->email->Subject = "Solicitud de cheque autorizada #".$id_solicitud.".";
        }else{
            $this->email->Subject = "Solicitud de cheque desistida #".$id_solicitud.".";
        }
        $this->email->Body = utf8_decode($msg['body']);

        $conta = 0;
        foreach ($msg['para_usuario'] as $persona) {
            $this->email->addAddress($persona['correo'], utf8_decode($persona['nombre']));
            echo "\n * email: ".$persona['correo']." de: ".$persona['nombre'];
            $conta++;
        }
        if($conta>0){
            echo "\nResult ".$this->email->send();
        }else{
            echo "\nNo hay destinatarios para enviar correo";
        }
    }

    public function notificar_solicitud_5k($email,$state,$status,$id_solicitud,$perfil){
        $msj = array();
        $id_solicitud=str_pad($id_solicitud, 6,'0',STR_PAD_LEFT);
        $correo_from = "solicitud@impressa.com";
        $body="";
        if($state=='send'){

            $body = "<p><b>".$perfil->nombre."</b> le ha enviado la solicitud de cheque <b>#".$id_solicitud."</b> para su autorizacion.</p>";
            $this->email->Subject = "Solicitud de cheque para autorización #".$id_solicitud.".";

            $this->email->Body = $body;
            $this->email->setFrom($correo_from, 'Solicitud de Cheque'); //Utilizar correo para enviar solicitud de cheque

            foreach ($email as $correo) {
                $this->email->addAddress($correo->email, $correo->nombre);
                echo "\n * email: ".$correo->email." de: ".$correo->nombre;
            }
            echo "\nResult ".$this->email->send();

        }else if($state=='fail'){
            $body = "<p><b>".$perfil->nombre."</b> ha desistido la solicitud de cheque <b>#".$id_solicitud."</b>.</p>";
            $this->email->Subject = "Solicitud de cheque desistida #".$id_solicitud.".";
            $this->email->Body = $body;
            $this->email->setFrom($correo_from, 'Solicitud de Cheque');
            $this->email->addAddress($email->email, $email->nombre);
            echo "\n D email: ".$email->email." de: ".$email->nombre;
            echo "\nResult ".$this->email->send();
        }
    }

    public function getError(){
        return $this->error;
    }
}

?>