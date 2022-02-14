<html>

<head>
    <title>APEXG4</title>
</head>

<body>
    <?php
	{
		//API Key
		$header = array(
            "TRN-Api-Key:68d170ab-9295-46e3-9dba-7e8230e24c0f"
		);
		 
		//user情報取得
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"https://public-api.tracker.gg/v2/apex/standard/profile/psn/SuperSaiyajinOne");//菊地のオンラインID
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		 
		$response = curl_exec($ch);
		$profile = json_decode($response, true);
		 
		$tk = ($profile['data']['segments'][1]['stats']['kills']['value']);//現在の合計キル数(敵を倒した数)をapiから読み込む
		$td = ($profile["data"]["segments"][1]["stats"]["damage"]["value"]);現在の合計ダメージをapiから読み込む
		 
    curl_close($ch);
    }
 
	{
		// JSON化したスプレッドシートを読み込む
        $data = "https://spreadsheets.google.com/feeds/list/1l6snb6y0Y0Y8xDH9aTFaBYPU1kZJJW8Y4PpWuPDnRp4/od6/public/values?alt=json";
		$json = file_get_contents($data);
		$json_decode = json_decode($json);
 
		// JSONデータ内の『entry』部分を複数取得して、postsに格納(スプレッドシートをjsonに変換して、そこから読みこむ作業)
		$posts = $json_decode->feed->entry;
 
		foreach ($posts as $post) {
		    $ytk[] = $post->{'gsx$kills'}->{'$t'};
		}
		foreach ($posts as $post) {
		    $ytd[] = $post->{'gsx$damages'}->{'$t'};
		}
		$i=0;
		$todaykills = $tk - $ytk[$i];
		$todaydamage = $td - $ytd[$i];
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">

    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
        <title>Apex Stats</title>
    </head>

    <body>
        <header>
        </header>
        <main>
            <div class="apex_stats">
                <h1>Apex Stats</h1>
                <?php
        //出力
 
        echo '<p><span class="title">Total Kills : </span><span class="value">';
        echo number_format($tk);//合計キル数の表示
        echo "</span></p>";
 
        echo '<p><span class="title">Today&#39;s Kills : </span><span class="value">';
        echo number_format($todaykills);//今日のキル数
        echo "</span></p>";
 
        echo '<p><span class="title">Total Damage : </span><span class="value">';
        echo number_format($td);//合計ダメージの表示
        echo "</span></p>";
 
        echo '<p><span class="title">Today&#39;s Damage : </span><span class="value">';
        echo number_format($todaydamage);//今日のダメージ
        echo "</span></p>";
    }
 
    ?>
            </div>
            <footer>
            </footer>
        </main>
    </body>

    </html>
