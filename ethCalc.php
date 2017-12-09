<!--Written by Braden Rucinski-->
<html>

<head> 

<title> ETH Calculator </title>    
    
<style>
    #lost{
        color: red;
    }
    #won{
        color: green;
    }
    
</style>    
    
</head>    
    
<body>

<h1> Little ETH Calculator </h1>
        
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Amount USD paid (NO FEES): <input type= "text" name="USDnoFees"><br>
Fees USD paid: <input type= "text" name= "fees"><br>   
Amount ETH received:   <input type= "text" name= "ETHbought"><br>
<br>
<input type="submit">    

    </form>
<?php
//define variables and set to empty values
    $ethStartPrice = $ETHbought= $USDnoFees = $fees = $gender = $comment = $website ="";

    $myfile = fopen("priceETH.txt", "r") or die("Unable to open file!");
    $ethPriceNow= fread($myfile,filesize("priceETH.txt"));
    fclose($myfile);
    $ethPriceNow = (float)$ethPriceNow;
    
    echo "Up to date ETH price is " . $ethPriceNow . "<br><br>";
    //store variables after sanitizing POST inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ETHbought = test_input($_POST["ETHbought"]); //sanitize the POST data called name first, then store it in our php variable called name
    $USDnoFees = test_input($_POST["USDnoFees"]);
    $fees = test_input($_POST["fees"]);
   // $comment = test_input($_POST["comment"]);
    //$gender = test_input($_POST["gender"]);
    $ethStartPrice= calculate_start_price_ETH((float)$USDnoFees, (float)$ETHbought);
    $moneyChange= calculate_gains_losses($ethStartPrice, $USDnoFees, $fees, $ethPriceNow);
    
    echo "You bought " . $ETHbought . " for " . $USDnoFees . " plus " . $fees . " in fees<br>";
    echo "This means the ETH price was " . $ethStartPrice . " when you bought it <br><br>";
    
    if($moneyChange<=0){ //if money is negative== lost
     echo "<p1 id= 'lost'> Darnit! After paying " . $fees . " dollars in fees, you have lost " . $moneyChange . " dollars USD </p1> <br>";
    }
    else{ //if results are positive
        echo "<p1 id= 'won'> Congrats! After paying " . $fees . " dollars in fees, you have made " . $moneyChange . " dollars USD </p1><br>";
    }
    
    
    }
function test_input($data) {
    $data= trim($data); //predefined PHP functions
    $data = stripslashes($data);
    $data = htmlspecialchars ($data);
    return $data; //return sanitized data
}
function calculate_start_price_ETH ($USDnoFees, $ETHbought){    
    $result = $USDnoFees/$ETHbought;
    return $result;
}
function calculate_gains_losses($ethStartPrice, $USDNoFees, $fees, $ethPriceNow){
$ethChange = $ethPriceNow - $ethStartPrice;
$ethChangePercent = $ethChange/$ethStartPrice; $usdChange= $ethChangePercent * $USDNoFees;
$moneyChange= $usdChange - $fees; 
    return $moneyChange;
}
    
?>
    
</body>
</html>
