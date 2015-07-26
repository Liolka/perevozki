<? 

function isQuickly($date)
{
    $datetime1 = new DateTime($date);
    $datetime2 = new DateTime(date('Y-m-d'));
    $interval = $datetime2->diff($datetime1);
	//echo'<pre>';print_r($interval);echo'</pre>';
	if($interval->days <= 2 || $interval->invert == 1)	{
		$res = true;
	}	else	{
		$res = false;
	}
	return $res;
}

// получает часть текста указанной длины. Не разбивает слова.
function getIntroText($maxchar, $text)
{
	$text_intro = '';
	if(strlen($text) > $maxchar)	{
		$words = explode(' ', $text);
		foreach ($words as $word)	{
			if (strlen($text_intro . ' ' . $word) < $maxchar)	{
				$text_intro .= ' '.$word; 
			} else	{
				$text_intro .= '';
				break;
			}
		}
		$text_intro .= '...';
	}	else	{
		$text_intro = $text;
	}
	return $text_intro;
}

function processPageRequest($param = 'page')
{
	if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
		$_GET[$param] = Yii::app()->request->getPost($param);
}

/**
 * Переводим TIMESTAMP в формат вида: 5 дн. назад
 * или 1 мин. назад и тп.
 *
 * @param unknown_type $date_time
 * @return unknown
 */

function getTimeAgo($date_time)
{
	$timeAgo = time() - strtotime($date_time);
	//var_dump	( $timeAgo);
	$timePer = array(
		'day' 	=> array(3600 * 24, 'дн.'),
		'hour' 	=> array(3600, ''),
		'min' 	=> array(60, 'мин.'),
		'sek' 	=> array(1, 'сек.'),
		);
	
	if($timeAgo <= 0) return 'сегодня';
	
	foreach ($timePer as $type =>  $tp) {
		$tpn = floor($timeAgo / $tp[0]);
		if ($tpn){

			switch ($type) {
				case 'hour':
					if (in_array($tpn, array(1, 21))){
						$tp[1] = 'час';
					}elseif (in_array($tpn, array(2, 3, 4, 22, 23)) ) {
						$tp[1] = 'часa';
					}else {
						$tp[1] = 'часов';
					}
					break;
			}
			return $tpn.' '.$tp[1].' назад';
		}
	}
}

function prepareArray($rows, $keyFld)
{
	$res = array();
	if(count($rows))	{
		foreach($rows as $row)	{
			$res[$row[$keyFld]]	= $row;
		}
	}
	
	return $res;
}


function sendMail($email, $tmplEmail = 'emailTpl', $data = array()) 
{
	//echo'$email1121<pre>';print_r($email,0);echo'</pre>';die;
	
	Yii::app()->dpsMailer->sendByView(
		array($email), // определяем кому отправляется письмо
		$tmplEmail, // view шаблона письма
		$data
	);
}

//обновляет время последней активности пользователя
function UpdateLastActivity(&$app, &$connection)
{
	if(!$app->user->isGuest)	{
		$user_id = $app->user->id;
		$sql = "UPDATE {{users}} SET `last_activity` = '".date('Y-m-d H:i:s', time())."' WHERE `id` = $user_id";
		$command = $connection->createCommand($sql);
		//$command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		//$command->bindParam(":last_activity", date('Y-m-d H:i:s', time()), PDO::PARAM_STR);
		$command->execute();
	}
	return true;
}

//возвращает статус он-лайн
function isOnline(&$app, $last_activity)
{
	$res = false;
	if($last_activity !== '0000-00-00 00:00:00')	{
		//$d1 = date('Y-m-d H:i:s', strtotime("-10 minutes"));
//		$d0 = date('Y-m-d H:i:s');
//		$d1 = date('Y-m-d H:i:s', strtotime("-".$app->params['LastActivityInterval']." minute"));
//		echo'$d0<pre>';print_r($d0,0);echo'</pre>';//die;
//		echo'$d1<pre>';print_r($d1,0);echo'</pre>';//die;
//		echo'$last_activity<pre>';print_r($last_activity,0);echo'</pre>';//die;

	
		//$datetime1 = new DateTime(date('Y-m-d H:i:s'));
		$datetime1 = new DateTime(date('Y-m-d H:i:s'));
		$datetime2 = new DateTime($last_activity);

		$interval = $datetime2->diff($datetime1);
//		echo'$datetime1<pre>';print_r($datetime1);echo'</pre>';
//		echo'$datetime2<pre>';print_r($datetime2);echo'</pre>';
//		echo'<pre>';print_r($interval);echo'</pre>';
		if($interval->y == 0 && $interval->m == 0 && $interval->d == 0 && $interval->h == 0 && $interval->i <= $app->params['LastActivityInterval'] )
			$res = true;
	}	
	
	return $res;
}


?>