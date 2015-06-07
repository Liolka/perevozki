<?php
header('Content-Type: text/html; charset=utf-8');

// https://maps.googleapis.com/maps/api/place/autocomplete/json?input=Гоме&types=(cities)&language=ru_RU&components=country:by&key=AIzaSyA1mi5FQDkimCEvKq5XZnR-Ladfn_jiGkE
function abi_get_url_object($url, $user_agent=null)
{
  define('ABI_URL_STATUS_UNSUPPORTED', 100);
  define('ABI_URL_STATUS_OK', 200);
  define('ABI_URL_STATUS_REDIRECT_301', 301);
  define('ABI_URL_STATUS_REDIRECT_302', 302);
  define('ABI_URL_STATUS_NOT_FOUND', 404);
  define('MAX_REDIRECTS_NUM', 4);
  $TIME_START = explode(' ', microtime());
  $TRY_ID = 0;
  $URL_RESULT = false;
  do
  {
    //--- parse URL ---
    $URL_PARTS = @parse_url($url);
    if( !is_array($URL_PARTS))
    {
      break;
    };
    $URL_SCHEME = ( isset($URL_PARTS['scheme']))?$URL_PARTS['scheme']:'http';
    $URL_HOST = ( isset($URL_PARTS['host']))?$URL_PARTS['host']:'';
    $URL_PATH = ( isset($URL_PARTS['path']))?$URL_PARTS['path']:'/';
    $URL_PORT = ( isset($URL_PARTS['port']))?intval($URL_PARTS['port']):80;
    if( isset($URL_PARTS['query']) && $URL_PARTS['query']!='' )
    {
      $URL_PATH .= '?'.$URL_PARTS['query'];
    };
    $URL_PORT_REQUEST = ( $URL_PORT == 80 )?'':":$URL_PORT";
    //--- build GET request ---
    $USER_AGENT = ( $user_agent == null )?'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)':strval($user_agent);
    $GET_REQUEST = "GET $URL_PATH HTTP/1.0\r\n"
    ."Host: $URL_HOST$URL_PORT_REQUEST\r\n"
    ."Accept: text/plain\r\n"
    ."Accept-Encoding: identity\r\n"
    ."User-Agent: $USER_AGENT\r\n\r\n";
    //--- open socket ---
    $SOCKET_TIME_OUT = 30;
    $SOCKET = @fsockopen($URL_HOST, $URL_PORT, $ERROR_NO, $ERROR_STR, $SOCKET_TIME_OUT);
    if( $SOCKET )
    {
     if( fputs($SOCKET, $GET_REQUEST))
     {
      socket_set_timeout($SOCKET, $SOCKET_TIME_OUT);
      //--- read header ---
      $header = '';
      $SOCKET_STATUS = socket_get_status($SOCKET);
      while( !feof($SOCKET) && !$SOCKET_STATUS['timed_out'] )
      {
        $temp = fgets($SOCKET, 128);
        if( trim($temp) == '' ) break;
        $header .= $temp;
        $SOCKET_STATUS = socket_get_status($SOCKET);
      };
      //--- get server code ---
      if( preg_match('~HTTP\/(\d+\.\d+)\s+(\d+)\s+(.*)\s*\\r\\n~si', $header, $res))
       $SERVER_CODE = $res[2];
      else
       break;
      if( $SERVER_CODE == ABI_URL_STATUS_OK )
      {
        //--- read content ---
        $content = '';
        $SOCKET_STATUS = socket_get_status($SOCKET);
        while( !feof($SOCKET) && !$SOCKET_STATUS['timed_out'] )
        {
          $content .= fgets($SOCKET, 1024*8);
          $SOCKET_STATUS = socket_get_status($SOCKET);
        };
        //--- time results ---
        $TIME_END = explode(' ', microtime());
        $TIME_TOTAL = ($TIME_END[0]+$TIME_END[1])-($TIME_START[0]+$TIME_START[1]);
        //--- output ---
        $URL_RESULT['header'] = $header;
        $URL_RESULT['content'] = $content;
        $URL_RESULT['time'] = $TIME_TOTAL;
        $URL_RESULT['description'] = '';
        $URL_RESULT['keywords'] = '';
        //--- title ---
        $URL_RESULT['title'] =( preg_match('~<title>(.*)<\/title>~U', $content, $res))?strval($res[1]):'';
        //--- meta tags ---
        if( preg_match_all('~<meta\s+name\s*=\s*["\']?([^"\']+)["\']?\s+content\s*=["\']?([^"\']+)["\']?[^>]+>~', $content, $res, PREG_SET_ORDER) > 0 )
        {
         foreach($res as $meta)
          $URL_RESULT[strtolower($meta[1])] = $meta[2];
        };
      }
      elseif( $SERVER_CODE == ABI_URL_STATUS_REDIRECT_301 || $SERVER_CODE == ABI_URL_STATUS_REDIRECT_302 )
      {
        if( preg_match('~location\:\s*(.*?)\\r\\n~si', $header, $res))
        {
         $REDIRECT_URL = rtrim($res[1]);
         $URL_PARTS = @parse_url($REDIRECT_URL);
         if( isset($URL_PARTS['scheme'])&& isset($URL_PARTS['host']))
          $url = $REDIRECT_URL;
         else
          $url = $URL_SCHEME.'://'.$URL_HOST.'/'.ltrim($REDIRECT_URL, '/');
        }
        else
        {
         break;
        };
      };
     };// GET request is OK
     fclose($SOCKET);
    }// socket open is OK
    else
    {
     break;
    };
    $TRY_ID++;
  }
  while( $TRY_ID <= MAX_REDIRECTS_NUM && $URL_RESULT === false );
  return $URL_RESULT;
};

$input_str = isset($_GET['input']) ? $_GET['input'] : '';
//if($input_str)	{
	$url1 = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';
	$params = ('?input='.$input_str.'&types=(cities)&language=ru_RU&components=country:by&key=AIzaSyA1mi5FQDkimCEvKq5XZnR-Ladfn_jiGkE');
	//$params = ('?input='.$input_str.'&types=(cities)&language=ru_RU&key=AIzaSyA1mi5FQDkimCEvKq5XZnR-Ladfn_jiGkE');
	
	$response = file_get_contents($url1 . $params);

	echo ( $response);
//}

/*
$url = $url1 . $params;
$user_agent = 'MySuperBot 1.02';
$URL_OBJ = abi_get_url_object($url, $user_agent);
if( $URL_OBJ )
{
  $CONTENT = $URL_OBJ['content'];
  $HEADER = $URL_OBJ['header'];
  $TITLE = $URL_OBJ['title'];
  $DESCRIPTION = $URL_OBJ['description'];
  $KEYWORDS = $URL_OBJ['keywords'];
  $TIME_REQUEST = $URL_OBJ['time'];
}
else
  print 'Запрашиваемая страница недоступна.';


echo $CONTENT;
*/

?>
