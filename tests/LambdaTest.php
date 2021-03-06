<?php

require 'vendor/autoload.php';

$GLOBALS['LT_USERNAME'] = getenv('LT_USERNAME');
if(!$GLOBALS['LT_USERNAME']) $GLOBALS['LT_USERNAME'] = "************************************";

$GLOBALS['LT_APPKEY'] = getenv('LT_APPKEY');
if(!$GLOBALS['LT_APPKEY']) $GLOBALS['LT_APPKEY'] = "*****************************************";

$GLOBALS['LT_BROWSER'] = getenv('LT_BROWSER');
if(!$GLOBALS['LT_BROWSER']) $GLOBALS['LT_BROWSER'] = "chrome";

$GLOBALS['LT_BROWSER_VERSION'] = getenv('LT_BROWSER_VERSION');
if(!$GLOBALS['LT_BROWSER_VERSION']) $GLOBALS['LT_BROWSER_VERSION'] ="67.0";

$GLOBALS['LT_OPERATING_SYSTEM'] = getenv('LT_OPERATING_SYSTEM');
if(!$GLOBALS['LT_OPERATING_SYSTEM']) $GLOBALS['LT_OPERATING_SYSTEM'] = "win10";


$GLOBALS['LT_TUNNEL_IDENTIFIER'] = getenv('LT_TUNNEL_IDENTIFIER'); 

class LambdaTest{
	
   protected static $driver;

   public function testAdd() {		
		
		$url = "https://". $GLOBALS['LT_USERNAME'] .":" . $GLOBALS['LT_APPKEY'] ."@beta-hub.lambdatest.com/wd/hub";		
		$desired_capabilities = new DesiredCapabilities();
		$desired_capabilities->setCapability('browserName',$GLOBALS['LT_BROWSER']);
		$desired_capabilities->setCapability('version', $GLOBALS['LT_BROWSER_VERSION']);
		$desired_capabilities->setCapability('platform', $GLOBALS['LT_OPERATING_SYSTEM']);
		$desired_capabilities->setCapability('name', "PHP Sample Demo");
		$desired_capabilities->setCapability('build', "LambdaTest Demo Sample");
		$desired_capabilities->setCapability('network', true);
		$desired_capabilities->setCapability('visual', true);
		$desired_capabilities->setCapability('video ', true);
		$desired_capabilities->setCapability('console', true);
		$url = "https://4dvanceboy.github.io/lambdatest/lambdasampleapp.html";

		if(!empty($GLOBALS['LT_TUNNEL_IDENTIFIER'])){
			$url = "http://localhost:2000/";
			echo "Initializing remote web driver,  tunnel Identifier : ".$GLOBALS['LT_TUNNEL_IDENTIFIER']."\n";
			$desired_capabilities->setCapability('tunnel', true);
			$desired_capabilities->setCapability('tunnelIdentifier', $GLOBALS['LT_TUNNEL_IDENTIFIER']);
		}else{
			echo "Initializing remote web driver.\n";
		}
		
		self::$driver = RemoteWebDriver::create($url, $desired_capabilities); 		
				
		$itemName = 'Yey, Lets add it to list';
		sleep(10);

        self::$driver->get($url);
        $element1 = self::$driver->findElement(WebDriverBy::name("li1"));
		$element1->click();
			
            
		$element2 = self::$driver->findElement(WebDriverBy::name("li2"));
        $element2->click();
			
		$element3 = self::$driver->findElement(WebDriverBy::id("sampletodotext"));
		$element3->sendKeys($itemName);
			
		$element4 = self::$driver->findElement(WebDriverBy::id("addbutton"));			
		$element4->click();
			
        self::$driver->wait(10, 500)->until(function($driver) {
           $elements = $driver->findElements(WebDriverBy::cssSelector("[class='list-unstyled'] li:nth-child(6) span"));
           return count($elements) > 0;
        });
		
		self::$driver->quit();
    }
			
}

  $lambdaTest = new LambdaTest();
  $lambdaTest->testAdd();
  

?>

