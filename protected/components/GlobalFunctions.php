<?
/*
	function hasCookie($name)
	{
		return !empty(Yii::app()->request->cookies[$name]->value);
	}

	function getCookie($name)
	{
		return Yii::app()->request->cookies[$name]->value;
	}

	
	function setCookie($name, $value)
	{
		$cookie = new CHttpCookie($name,$value);
		Yii::app()->request->cookies[$name] = $cookie;
	}
	

	function removeCookie($name)
	{
		unset(Yii::app()->request->cookies[$name]);
	}	
*/

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


?>