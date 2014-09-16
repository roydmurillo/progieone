 <?php
// #########################################################################
// September 09, 2012
// Real time PHP currency converter function with quotes from Yahoo Finance
// Written by Leonard Whistler
// lwhistler@gmail.com
// #########################################################################

function currencyExchange($amount,$baseCurrency,$quoteCurrency) {
$open = fopen("http://quote.yahoo.com/d/quotes.csv?s=$baseCurrency[0]$quoteCurrency[0]=X&f=sl1d1t1c1ohgv&e=.csv", "r");
$exchangeRate = fread($open, 2000);
fclose($open);
$exchangeRate = str_replace("\"", "", $exchangeRate);
$exchangeRate = explode(",", $exchangeRate);
$results = ($exchangeRate[1]*$amount);
$results = number_format ($results, 2);
$amount = number_format ($amount);
$timeStamp = strtotime($exchangeRate[2]);
$timeStamp = date('F d, Y', $timeStamp);
$timeStamp = "$timeStamp $exchangeRate[3]";

echo "$timeStamp EST<br>";
echo "The $baseCurrency[0]/$quoteCurrency[0] exchange rate is $exchangeRate[1]<br>\n";
echo "$amount $baseCurrency[1] will buy $results $quoteCurrency[1]<br><br>\n";
}

// for additional currency ticker symbols visit: http://finance.yahoo.com/currency-converter
$usd = array('USD','US Dollars');
$eur = array('EUR','Euro');
$jpy = array('JPY','Japanese Yen');
$gbp = array('GBP','British Pounds');
$aud = array('AUD','Australian Dollars');
$chf = array('CHF','Swiss Francs');
$cad = array('CAD','Canadian Dollars');

// amount, base currency, quote currency.
currencyExchange("120",$usd,$eur);
currencyExchange("250",$cad,$gbp);
currencyExchange("440",$usd,$jpy);
currencyExchange("40000",$jpy,$gbp); 
?> 