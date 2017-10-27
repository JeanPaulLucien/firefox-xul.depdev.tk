<?php
// не забыть сменить /en-US/ на /en-US/ в ссылках

$startURL = 'https://addons.mozilla.org/en-US/firefox/extensions/?sort=users&page='; // страница - начало сканирования (самые популярные)
$startPageNum = 1; // первая, начальная страница
$endPageNum = 3; // страница окончания

//Statistics
$countAddons = 0;

$weNeed2Parse = array (
	'addonTitle' => '/alt="">(.*?)<\/a>/',
	'iconURL' => '/<img src="(.*?)" alt="">/',
	'shortDesc' => '/<p class="desc">(.*?)<\/p>/',
	'addonURL' => ''); // для парсинга с начальной страницы и последующих (1, 2, 3...)
	
$countSomething = array (
	'addonTitle' => 0,
	'iconURL' => 0,
	'shortDesc' => 0,
	'addonURL' => 0); // считает, сколько напарсено

for ($i = $startPageNum; $i <= $endPageNum; $i++)
{
	$result = getpage($startURL.$i);
	
	for ($j = 0; $j < count($weNeed2Parse); $j++)
	{
		switch ($j) 
		{
			case 0: $fileName = 'addonTitles.txt'; break;
			case 1: $fileName = 'iconURLs.txt'; break;
			case 2: $fileName = 'shortDescs.txt'; break;
			case 3: $fileName = 'addonURLs.txt'; break;
		}
		echo $weNeed2Parse[$j], $result, $countSomething[$j], $fileName;
		$countSomething[$j] = parseMe($weNeed2Parse[$j], $result, $countSomething[$j], $fileName); //lol
	}
}
echo '<br>We have parsed: ';
foreach ($countSomething as $key=>$number)
{
	echo $number.' ';
}
echo '.<br>';
	
echo 'This is not end! Let\'s parse addon pages<br>';

$manyAddonPages = parseAddonPages('addonURLs.txt');

function parseAddonPages($fileName)
{
	saveFile(NULL, $fileName, 'IwannaDataRead'); //здесь нечего записывать
	
	/*
		<span class="version-number" itemprop="version">2.9.1</span>
		<a href="/ru/firefox/user/Wladimir-Palant/" title="Wladimir Palant">Wladimir Palant</a>
		<img src="https://addons.cdn.mozilla.net/user-media/previews/thumbs/137/137084.png?modified=1401935427" alt="Скриншот дополнения #1">
		
  <ul class="links">
          <li><a class="home" href="https://outgoing.prod.mozaws.net/v1/2f8fd06eee0a941576427f8e1225c490287cdd4f3176e383d15b77bf1e7053c9/http%3A//adblockplus.org/">
        Домашняя страница дополнения</a></li>
              <li><a class="support" href="https://outgoing.prod.mozaws.net/v1/a97a28c0b336b92743b60d9bc6b39d40ce0d16f21e2590ce4cdd5323831ffc47/http%3A//adblockplus.org/forum/">Сайт поддержки</a></li>
          </ul>
      <ul>
      <li>Версия 2.9.1 <a class="scrollto" href="#detail-relnotes">Информация</a></li>
      <li>Последнее обновление: June  7, 2017</li>
      <li class="source-license">Выпущено под
    </ul>
	
	<div id="addon-description" class="prose">полное описание<a rel="nofollow" href="https://outgoing.prod.mozaws.net/v1/c75d40f48427cb5e0da45d2d75745ca8c7b01c46cf9bf12365ec0ace4ed28688/http%3A//adblockplus.org/ru/acceptable-ads">Дополнительная информация</a></div>
	
	<aside id="related" class="secondary metadata c">
            <h3>Связанные категории</h3>
      <ul>
                <li>
          <a href="/ru/firefox/extensions/privacy-security/">
            Приватность и защита
          </a>
        </li>
              </ul>
        <div class="clearboth">
  <h3 class="compact-bottom">Метки</h3>

  <div id="tagbox">
    
  <ul class="addon-tags nojs" id="addonid-1865">
          <li id="taglink-6647" class="tag">
      <a href="/ru/firefox/tag/abp" class="tagitem">
      abp
    </a>
  </li>
          <li id="taglink-3443" class="tag">
      <a href="/ru/firefox/tag/ad" class="tagitem">
      ad
    </a>
  </li>
          <li id="taglink-121" class="tag">
      <a href="/ru/firefox/tag/ad%20blocking" class="tagitem">
      ad blocking
    </a>
  </li>
          <li id="taglink-23" class="tag">
      <a href="/ru/firefox/tag/adblock" class="tagitem">
      adblock
    </a>
  </li>
          <li id="taglink-2355" class="tag">
      <a href="/ru/firefox/tag/adblock%20plus" class="tagitem">
      adblock plus
    </a>
  </li>
          <li id="taglink-26336" class="tag">
      <a href="/ru/firefox/tag/adblockplus" class="tagitem">
      adblockplus
    </a>
  </li>
          <li id="taglink-40" class="tag">
      <a href="/ru/firefox/tag/ads" class="tagitem">
      ads
    </a>
  </li>
          <li id="taglink-1407" class="tag">
      <a href="/ru/firefox/tag/anuncios" class="tagitem">
      anuncios
    </a>
  </li>
          <li id="taglink-26357" class="tag">
      <a href="/ru/firefox/tag/anzeigen%20blocken" class="tagitem">
      anzeigen blocken
    </a>
  </li>
          <li id="taglink-1248" class="tag">
      <a href="/ru/firefox/tag/banners" class="tagitem">
      banners
    </a>
  </li>
          <li id="taglink-2183" class="tag">
      <a href="/ru/firefox/tag/block" class="tagitem">
      block
    </a>
  </li>
          <li id="taglink-1244" class="tag">
      <a href="/ru/firefox/tag/filter" class="tagitem">
      filter
    </a>
  </li>
          <li id="taglink-17457" class="tag">
      <a href="/ru/firefox/tag/propagandas" class="tagitem">
      propagandas
    </a>
  </li>
          <li id="taglink-1406" class="tag">
      <a href="/ru/firefox/tag/publi" class="tagitem">
      publi
    </a>
  </li>
          <li id="taglink-1405" class="tag">
      <a href="/ru/firefox/tag/publicidad" class="tagitem">
      publicidad
    </a>
  </li>
          <li id="taglink-27604" class="tag">
      <a href="/ru/firefox/tag/restartless" class="tagitem">
      restartless
    </a>
  </li>
          <li id="taglink-2270" class="tag">
      <a href="/ru/firefox/tag/werbung" class="tagitem">
      werbung
    </a>
  </li>
      </ul>

  </div>
</div>

</aside>
 */

}


function parseMe($regexp, $result, $counter, $fileName)
{
	if(!preg_match_all ($regexp, $result, $found))
	{
		echo '<br>Found nothing!';
		break;
	}
	//preg_match_all ('', $result, $iconURL);
	//preg_match_all ('', $result, $shortDesc);
	else
	{
		foreach ($found[1] as $key=>$string)
		{
			saveToFile($string, $fileName, NULL);
			$counter++;
		}	
	}
	return $counter;
}	

// Чистый и рабочий код //
function getpage($url)
{
	echo '<br>I visited: '.$url.'<br>';
	sleep(3);
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); //агент которым мы представимся
    curl_setopt($ch, CURLOPT_TIMEOUT, 60 ); // таймаут
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($ch);
	
	curl_close($ch); // завершает сеанс и освобождает ресурсы. Обязательно!
	
	return $result;
}

function saveToFile($someInfo, $fileName, $heWantRead)
{
	$fd = fopen ('./data/'.$fileName,  'a+') or die('Can\'t open, boss.');
	if($heWantRead == NULL)
	{
		while(!feof($fd))
		{
			$str = fgets($fd);
			if (preg_match('/'.$someInfo.'/', $str))
			{
				$thereIsSame = true;
				break;
			}
			else
			{
				$thereIsSame = false;
				break;
			}
		}
		if ($thereIsSame == false)
		{
			switch($fileName)
			{
				case 'addonURLs.txt': fwrite($fd, $someInfo .PHP_EOL); break; //не нужны ;
				default: fwrite($fd, $someInfo.';'.PHP_EOL);
			}
		}
	}
	else
	{
		while(!feof($fd))
		{
			$addonURL = fgets($fd);
			$result = getPage($url);
			parseMe('addonPages', $result, NULL, $fileName); //здесь нужна функция, вызывающая регулярки, вызывающая 
		}		
		return $addonURL;
	}
	fclose($fd);
}

//$<p class="num">Страница <a href="/en-US/firefox/extensions/?sort=users&amp;page=1">1</a> из <a href="/firefox/extensions/?sort=users&amp;page=1053">1053</a>    </p>

/* Конец чистого и рабочего кода
Начало апокалипсиса */


//$queryStr = '/api/v3/...';
// создание нового ресурса cURL


//var_dump($ch);

// установка URL и других необходимых параметров

//curl_setopt($ch, CURLOPT_HEADER, 'Content-type: application/json');
// загрузка страницы и выдача её браузеру
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_TIMEOUT, 3);

//$content = trim(curl_exec($ch));

//print $content;

// Спасибо ShipCode
// Сделать функцию для скачивания файлов, в том числе иконок
/*set_time_limit(0);
// Адрес файла, который необходимо скачать
$url = 'http://www.php.ru/images/logo.gif';
$pi = pathinfo($url);
$ext = $pi['extension'];
$name = $pi['filename'];
 
$ch = curl_init();
 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
$opt = curl_exec($ch);
 
curl_close($ch);
 
$saveFile = $name.'.'.$ext;
if(preg_match("/[^0-9a-z\.\_\-]/i", $saveFile))
    $saveFile = md5(microtime(true)).'.'.$ext;
 
$handle = fopen($saveFile, 'wb');
fwrite($handle, $opt);
fclose($handle);*/

?>
