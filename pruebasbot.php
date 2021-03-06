<?php
  
$returnArray = true;
$rawData = file_get_contents('php://input');
$response = json_decode($rawData, $returnArray);
$id_del_chat = $response['message']['chat']['id'];

 
// Obtener comando (y sus posibles parametros)
$regExp = '#^(\/[a-zA-Z0-9\/]+?)(\ .*?)$#i';


$tmp = preg_match($regExp, $response['message']['text'], $aResults);

if (isset($aResults[1])) {
    $cmd = trim($aResults[1]);
    $cmd_params = trim($aResults[2]);
} else {
    $cmd = trim($response['message']['text']);
    $cmd_params = '';
}
 
// Mensaje de respuesta
$msg = array();
$msg['chat_id'] = $response['message']['chat']['id'];
$msg['text'] = null;
$msg['disable_web_page_preview'] = true;
$msg['reply_to_message_id'] = (int)$response['message']['message_id'];
$msg['reply_markup'] = null;
 
// Comandos
switch ($cmd) {
    case '/start':
        $msg['text']  = 'Hola ' . $response['message']['from']['first_name'] . " Usuario: " . $response['message']['from']['username'] . '!' . PHP_EOL;
        $msg['text'] .= '¿Como puedo ayudarte? Puedes ver una lista de las opciones disponibles con el comando /help';
        $msg['reply_to_message_id'] = null;
        break;
 
    case '/help':
        $msg['text']  = 'Los comandos disponibles son estos:' . PHP_EOL;
        //$msg['text'] .= '/start Inicializa el bot' . PHP_EOL;
        $msg['text'] .= '/instituciones, lista las instituciones' . PHP_EOL;
        $msg['text'] .= '/instituciones id, devuelve la institución' . PHP_EOL;
        $msg['text'] .= '/instituciones/regionsanitaria id, devuelve las instituciones según la región sanitaria' . PHP_EOL;
        $msg['text'] .= '/help Muestra esta ayuda';
        $msg['reply_to_message_id'] = null;
        break;

    case '/instituciones':
        if($cmd_params == ''){
            $informacion = file_get_contents("https://grupo2.proyecto2018.linti.unlp.edu.ar/api/index.php/instituciones",false);
        }
        else{
             $informacion = file_get_contents("https://grupo2.proyecto2018.linti.unlp.edu.ar/api/index.php/instituciones/".$cmd_params,false);
        }
        $informacion = json_decode($informacion);
        $msg['text']  = '';
        foreach ($informacion as $i)
            $msg['text'] = $msg['text'].$i->nombre.PHP_EOL;
        break;
    
    case '/instituciones/regionsanitaria':
        if($cmd_params == ''){
            $msg['text']  = 'Debe ingresar un id de región sanitaria';
        }
        else{
            $informacion  = file_get_contents("https://grupo2.proyecto2018.linti.unlp.edu.ar/api/index.php/instituciones/region-sanitaria/".$cmd_params,false);
            $informacion = json_decode($informacion);
            $msg['text']  = '';
            foreach ($informacion as $i)
                $msg['text'] = $msg['text'].$i->nombre.PHP_EOL;
        }
        break;
 
    default:
        $msg['text']  = 'Lo siento ' . $response['message']['from']['first_name'] . ', pero [' . $cmd . '] no es un comando válido.' . PHP_EOL;
        $msg['text'] .= 'Prueba /help para ver la lista de comandos disponibles';
        
        break;
}

//Descomentar para ver todo lo que envía telegram
/////////////$msg['text']= json_encode($response);
    
//Realizamos el envío
$url = '';

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($msg)
    )
);
            
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
 
exit(0);
 
?>
