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
        $msg['text'] .= '/instituciones Lista las instituciones' . PHP_EOL;
        $msg['text'] .= '/instituciones-region-sanitaria:{id}' . PHP_EOL;
        $msg['text'] .= '/help Muestra esta ayuda';
        $msg['reply_to_message_id'] = null;
        break;

 
    case '/instituciones':
        $cmd_params = explode(" ", $cmd_params);
        $informacion = file_get_contents("https://grupo2.proyecto2018.linti.unlp.edu.ar/api/index.php/instituciones",false);
        $informacion = json_decode($informacion,true);
        echo $informacion->nombre;
        $msg['text']  = $informacion->nombre; //file_get_contents("https://grupo2.proyecto2018.linti.unlp.edu.ar/api/index.php/instituciones",false);
        break;

    case '/instituciones-region-sanitaria':
        $cmd_params = explode(" ", $cmd_params);
        $msg['text']  = file_get_contents("https://grupo2.proyecto2018.linti.unlp.edu.ar/api/index.php/instituciones/region-sanitaria/".$cmd_params[1],false);
        break;
 
    default:
        $msg['text']  = 'Lo siento ' . $response['message']['from']['first_name'] . ', pero [' . $cmd . '] no es un comando válido.' . PHP_EOL;
        $msg['text'] .= 'Prueba /help para ver la lista de comandos disponibles';
        
        break;
}

//Descomentar para ver todo lo que envía telegram
/////////////$msg['text']= json_encode($response);



//Realizamos el envío
$url = 'https://api.telegram.org/bot733229952:AAHPHl4rhawU1jX_nSnhGlAjTAykj6MnACs/sendMessage';

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
