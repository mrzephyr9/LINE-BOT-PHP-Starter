<?php
$proxy = 'http://fixie:AHw2NimN7t5EsSh@velodrome.usefixie.com:80';
$proxyauth = 'prawit.boonthue@gmail.com:tstcfsteA1';

$access_token = 'AToSRdI67TV4soIwl2L1HlT7jGBLx4vIf1RmocOt8rJG9/n7afVpD8psgm6VUNbfEvR+LYQOMQ88xa3YTeh00zGOU68TJ5PlZ7koYVIn3cuI94605PLoQu5RFT59FY1za6iOzL9wR3Iy+HjejULbrAdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
  // Loop through each event
  foreach ($events['events'] as $event) {
    // Reply only when message sent is in 'text' format
    if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
      // Get text sent
      $text = $event['message']['text'];
      // Get replyToken
      $replyToken = $event['replyToken'];

      // Split a string by colon
      $sentences = explode(":", $text);
      // Forecast the weather
      if ($sentences[0] == "อากาศ" || $sentences[0] == "weather") {
        $url_weather = "http://api.wunderground.com/api/152abfcd8a423756/geolookup/conditions/q/Thailand/" . str_replace(' ', '%20', $sentences[1]) . '.json';
        $json_weather = file_get_contents($url_weather);
        $parsed_weather = json_decode($json_weather, true);
        $location = $parsed_weather->{'location'}->{'city'};
        $temp_c = $parsed_weather->{'current_observation'}->{'temp_c'};

        $text = "Current temperature in " . $location . " is: " . $temp_c;
        // $text = (isset($location)) ? "Current temperature in " . $location . " is: " . $temp_c : "ไม่พบข้อมูล ลองป้อนชื่อเมืองเป็นภาษาอังกฤษค่ะ";
      }

      // Build message to reply back
      $messages = [
        'type' => 'text',
        'text' => '[bot] ' . $text
      ];

      // Make a Post Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/reply';
      $data = [
        'replyToken' => $replyToken,
        'messages' => [$messages],
      ];
      $post = json_encode($data);
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_PROXY, $proxy);
      curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $result . "\r\n";
    }
  }
}
echo "OK";
