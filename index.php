<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Live Metal and Bitcoin Prices</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: black;
    }

    #price {
      text-align: center;
      background-color: lightgray;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 42px;
      margin-bottom: 20px;
    }

    p {
      font-size: 24px;
      margin: 10px 0;
    }
  </style>
</head>
<body>
  <div id="price">
    <h1>Live Bitcoin, Gull og sølv Priser</h1>
    <?php


      // API endpoint for bitcoin
      $endpoint = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=nok';
      // Make the request
      $response = file_get_contents($endpoint);
  
      // Decode the JSON data
      $data = json_decode($response, true);
      
      // Extract the bitcoin price in NOK
      $price = $data['bitcoin']['nok'];
  
      // Output the price
      echo "<p> Prisen for 1 bitcoin er $price.kr";
      echo "<br>";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://live-metal-prices.p.rapidapi.com/v1/latest/XAU,XAG/NOK",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: live-metal-prices.p.rapidapi.com",
        "X-RapidAPI-Key: 1251d355e6msh9365e2b10ead630p104139jsndb9a0a3d16c3"
    ],
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $result = json_decode($response, true);

    if ($result["success"]) {
      $xau_price = $result["rates"]["XAU"];
      $xau_price_per_gram = $xau_price / 28.35;
      $xag_price = $result["rates"]["XAG"];
      $xag_price_per_gram = $xag_price / 28.35;
  
      echo "<p> Prisen av gull er $xau_price_per_gram.kr per gram.";
      echo "<br>";
      echo "<p> Prisen av sølv er $xag_price_per_gram.kr per gram.";
      echo "<br>";
  } else {
      echo "An error occurred while retrieving the metal prices";
      echo "<br>";
  }
}
    ?>
  </div>
</body>
</html>