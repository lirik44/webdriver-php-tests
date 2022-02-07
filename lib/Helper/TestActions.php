<?php

namespace lib\Helper;

use Facebook\WebDriver\Exception\NoSuchAlertException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Remote\RemoteWebDriver as RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverSelect;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class TestActions
{
    /**
     * @var RemoteWebDriver
     */
    public $webDriver;

    public function __construct()
    {
        $this->webDriver = $GLOBALS['webDriver'];
    }

    public function setupSeleniumSession($testName)
    {
        if (BROWSER == 'chrome') {//Set parameters for chrome session
            $GLOBALS['webDriver'] = RemoteWebDriver::create(LINK_SELENIUM,
                array(
                    "browserName"=>"chrome",
                    "browserVersion"=>"latest",
                    "w3c"=>true,
                    "name"=>$testName,
                    "enableVNC"=>true,
                    "enableVideo"=>false,
                    "videoName"=>"date('Y_m_d_H_i_s', time()).\"_\".$testName.\"_.mp4"
                ));
        } elseif (BROWSER == 'firefox') {//Set parameters for firefox session
            $GLOBALS['webDriver'] = RemoteWebDriver::create(LINK_SELENIUM,
                array(
                    "browserName"=>"firefox",
                    "browserVersion"=>"latest",
                    "w3c"=>true,
                    "name"=>$testName,
                    "enableVNC"=>true,
                    "enableVideo"=>false,
                    "videoName"=>"date('Y_m_d_H_i_s', time()).\"_\".$testName.\"_.mp4"
                ));
        }
        $GLOBALS['webDriver']->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(1920,1080));
        $GLOBALS['webDriver']->manage()->timeouts()->implicitlyWait(10);
        //avoid risky test notification
        $stack = [];
        assertEquals(0, count($stack));
    }

    public function getErrorScreenshot($testName)
    {
        //get date and time when failed
        $errorTime = date('Y_m_d_H_i_s', time());
        //name of error screenshot
        $strerror=$testName."_".$errorTime."_.png";
        //get folder for error screenshots
        $dir = __DIR__ . '/../../../report/screenshots';
        //take screenshot and put to folder
        $this->webDriver->takeScreenshot("$dir//$strerror");
    }

    public function isAlertPresentTypeAccept()
    {
        try {
            $this->waitAlertIsPresent(5);
            $this->webDriver->switchTo()->alert()->accept();
            return true;
        } catch (NoSuchAlertException $Ex) {
            return false;
        }
    }

    public function isAlertPresentTypeDismiss()
    {
        try {
            $this->waitAlertIsPresent(5);
            $this->webDriver->switchTo()->alert()->dismiss();
            return true;
        } catch (NoSuchAlertException $Ex) {
            return false;
        }
    }

    public function waitElementToAppearByCssSelector($timeToWait, $cssSelector)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector($cssSelector)));
    }

    public function waitElementToDisappearByCssSelector($timeToWait, $cssSelector)
    {
        $this->webDriver->manage()->timeouts()->implicitlyWait(0);
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::cssSelector($cssSelector)));
    }

    public function waitElementToDisappearByID($timeToWait, $id)
    {
        $this->webDriver->manage()->timeouts()->implicitlyWait(0);
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id($id)));
    }

    public function waitElementToDisappearByXpath($timeToWait, $xpath)
    {
        $this->webDriver->manage()->timeouts()->implicitlyWait(0);
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::xpath($xpath)));
    }

    public function waitElementToAppearByID($timeToWait, $id)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id($id)));
    }

    public function waitElementToAppearByName($timeToWait, $name)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name($name)));
    }

    public function waitElementToAppearByXpath($timeToWait, $xpath)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath($xpath)));
    }

    public function waitElementToAppearByLinkText($timeToWait, $linkText)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::linkText($linkText)));
    }

    public function waitElementToAppearByClass($timeToWait, $className)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::className($className)));
    }

    public function waitElementToDisappearByClass($timeToWait, $className)
    {
        $this->webDriver->manage()->timeouts()->implicitlyWait(3);
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::className($className)));
    }

    public function waitElementUntilClickableByXpath($timeToWait, $xpath)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath($xpath)));
    }

    public function waitElementUntilClickableByClass($timeToWait, $className)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className($className)));
    }

    public function waitElementUntilClickableById($timeToWait, $id)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id($id)));
    }

    public function waitAlertIsPresent($timeToWait)
    {
        $this->webDriver->wait($timeToWait, 1000)->until(
            WebDriverExpectedCondition::alertIsPresent());
    }

    public function typeInAlertAndAccept($timeToWait, $alertText)
    {
        $this->webDriver->wait($timeToWait, 200)->until(
            WebDriverExpectedCondition::alertIsPresent());
        $this->webDriver->switchTo()->alert()->sendKeys($alertText);
        $this->webDriver->switchTo()->alert()->accept();
    }
    public function waitAlertAndAuth()
    {
        $this->webDriver->switchTo()->alert()->sendKeys(STAGING_USER);
        $this->webDriver->switchTo()->alert()->sendKeys(WebDriverKeys::TAB);
        $this->webDriver->switchTo()->alert()->sendKeys(STAGING_PASS);
        $this->webDriver->switchTo()->alert()->accept();
    }

    public function typeByID($id, $text)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id($id)));
        $this->webDriver->findElement(WebDriverBy::id($id))->click();
        $this->webDriver->findElement(WebDriverBy::id($id))->clear();
        $this->webDriver->findElement(WebDriverBy::id($id))->sendKeys($text);
    }

    public function typeByName($name, $text)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::name($name)));
        $this->webDriver->findElement(WebDriverBy::name($name))->click();
        $this->webDriver->findElement(WebDriverBy::name($name))->clear();
        $this->webDriver->findElement(WebDriverBy::name($name))->sendKeys($text);
    }

    public function typeByCssSelector($cssSelector, $text)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector($cssSelector)));
        $this->webDriver->findElement(WebDriverBy::cssSelector($cssSelector))->click();
        $this->webDriver->findElement(WebDriverBy::cssSelector($cssSelector))->clear();
        $this->webDriver->findElement(WebDriverBy::cssSelector($cssSelector))->sendKeys($text);
    }

    public function typeByXpath($xpath, $text)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath($xpath)));
        $this->webDriver->findElement(WebDriverBy::xpath($xpath))->clear();
        $this->webDriver->findElement(WebDriverBy::xpath($xpath))->sendKeys($text);
    }

    public function cleanTextByXpath($xpath)
    {
        $this->webDriver->findElement(WebDriverBy::xpath($xpath))->clear();
    }

    public function cleanTextById($id)
    {
        $this->webDriver->findElement(WebDriverBy::id($id))->clear();
    }

    public function selectComboBoxByName($name, $text)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::name($name)));
        $selectingComboBox = $this->webDriver->findElement(WebDriverBy::name($name));
        $selection = new WebDriverSelect($selectingComboBox);
        $selection->selectByVisibleText($text);
    }

    public function selectComboBoxByClassName($className, $text)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className($className)));
        $selectingComboBox = $this->webDriver->findElement(WebDriverBy::className($className));
        $selection = new WebDriverSelect($selectingComboBox);
        $selection->selectByVisibleText($text);
    }

    public function selectComboBoxByCSSSelector($cssSelector, $text)
    {
        $selectingComboBox = $this->webDriver->findElement(WebDriverBy::className($cssSelector));
        $selection = new WebDriverSelect($selectingComboBox);
        $selection->selectByVisibleText($text);
    }

    public function selectComboBoxByXPath($xpath, $text)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath($xpath)));
        $selectingComboBox = $this->webDriver->findElement(WebDriverBy::xpath($xpath));
        $selection = new WebDriverSelect($selectingComboBox);
        $selection->selectByVisibleText($text);
    }

    public function selectComboBoxValueByID($id, $value)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id($id)));
        $selectingComboBox = $this->webDriver->findElement(WebDriverBy::id($id));
        $selection = new WebDriverSelect($selectingComboBox);
        $selection->selectByValue($value);
    }

    public function selectComboBoxOptionByID($id, $option)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id($id)));
        $this->waitElementToAppearByXpath(15, "//select[@id='$id']");
        $this->clickElementWithXpath("//select[@id='$id']/option[$option]");
    }

    public function selectComboBoxOptionByName($name, $option)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::name($name)));
        $selectingComboBox = $this->webDriver->findElement(WebDriverBy::name($name));
        $selection = new WebDriverSelect($selectingComboBox);
        $selection->selectByIndex($option);
    }

    public function selectComboBoxVisibleTextByID($id, $text)
    {
        $selectingComboBox = $this->webDriver->findElement(WebDriverBy::id($id));
        $selection = new WebDriverSelect($selectingComboBox);
        $selection->selectByVisibleText($text);
    }

    public function switchToIframeByID($frame_id)
    {
        $this->waitElementToAppearByID(25, $frame_id);
        $iframe = $this->webDriver->findElement(WebDriverBy::id($frame_id));
        $this->webDriver->switchTo()->frame($iframe);
    }

    public function switchToIframeByXpath($frame_xpath)
    {
        $this->waitElementToAppearByXpath(25, $frame_xpath);
        $iframe = $this->webDriver->findElement(WebDriverBy::xpath($frame_xpath));
        $this->webDriver->switchTo()->frame($iframe);
    }

    public function switchToIframeByClassname($frame_class)
    {
        $this->waitElementToAppearByClass(25, $frame_class);
        $iframe = $this->webDriver->findElement(WebDriverBy::className($frame_class));
        $this->webDriver->switchTo()->frame($iframe);
    }

    public function switchToLastOpenedTab()
    {
        $handles = $this->webDriver->getWindowHandles();
        $this->webDriver->switchTo()->window(end($handles));
    }

    public function refreshPage()
    {
        $this->webDriver->navigate()->refresh();
    }

    public function moveBackFromPage()
    {
        $this->webDriver->navigate()->back();
    }

    public function closeCurrentTabAndSwitchToActual()
    {
        $this->webDriver->close();
        $this->switchToLastOpenedTab();
    }

    public function clickElementWithID($id)
    {
        $this->webDriver->wait(15, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id($id)));
        $this->webDriver->findElement(WebDriverBy::id($id))->click();
    }

    public function clickElementWithIDAndOpenInNewTab($id)
    {
        $this->webDriver->findElement(WebDriverBy::id($id))->sendKeys(array(WebDriverKeys::CONTROL, "\xEE\x80\x87"));
        $this->switchToLastOpenedTab();
    }

    public function clickElementWithXpath($xpath)
    {
        $this->webDriver->wait(15, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath($xpath)));
        $this->webDriver->findElement(WebDriverBy::xpath($xpath))->click();
    }

    public function clickElementWithXpathAndOpenInNewTab($xpath)
    {
        $this->webDriver->findElement(WebDriverBy::xpath($xpath))->sendKeys(array(WebDriverKeys::CONTROL, "\xEE\x80\x87"));
    }

    public function clickElementWithLinkText($linkText)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::linkText($linkText)));
        $this->webDriver->findElement(WebDriverBy::linkText($linkText))->click();
    }

    public function clickElementWithName($name)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::name($name)));
        $this->webDriver->findElement(WebDriverBy::name($name))->click();
    }

    public function clickElementWithClassName($className)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className($className)));
        $this->webDriver->findElement(WebDriverBy::className($className))->click();
    }

    public function clickElementWithCssSelector($cssSelector)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector($cssSelector)));
        $this->webDriver->findElement(WebDriverBy::cssSelector($cssSelector))->click();
    }

    public function getUrlUnderLinkText($linkText)
    {
        $url = $this->webDriver->findElement(WebDriverBy::linkText($linkText))->getAttribute("href");
        return $url;
    }

    public function getUrlUnderID($id)
    {
        $url = $this->webDriver->findElement(WebDriverBy::id($id))->getAttribute("href");
        return $url;
    }

    public function getUrlUnderXpath($xpath)
    {
        $url = $this->webDriver->findElement(WebDriverBy::xpath($xpath))->getAttribute("href");
        return $url;
    }

    public function getAttributeByXpath($xpath,$attributeName)
    {
        $data = $this->webDriver->findElement(WebDriverBy::xpath($xpath))->getAttribute($attributeName);
        return $data;
    }

    public function getVisibilityOfElementByXpath($xpath)
    {
        try {
            if ($this->webDriver->findElement(WebDriverBy::xpath("$xpath"))->isDisplayed()) {
                return true;
            }
        } catch
        (NoSuchElementException $e) {
            return false;
        }
    }

    public function getCountByXpath($xpath)
    {
        $count = $this->webDriver->findElements(WebDriverBy::xpath($xpath));
        return $count;
    }

    public function getTextByID($id)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id($id)));
        $text = $this->webDriver->findElement(WebDriverBy::id($id))->getText();
        return $text;
    }

    public function getTextByXpath($xpath)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath($xpath)));
        $text = $this->webDriver->findElement(WebDriverBy::xpath($xpath))->getText();
        return $text;
    }

    public function getTextFromAlert()
    {
        $this->waitAlertIsPresent(5);
        $text = $this->webDriver->switchTo()->alert()->getText();
        return $text;
    }

    public function openPageByUrl($url)
    {
        $host = $GLOBALS['SITE_HOST'];
        $this->webDriver->get($host . $url);
    }

    public function countElementsByXpath($xpath)
    {
        $elementsArray = $this->webDriver->findElements(WebDriverBy::xpath($xpath));
        $elementQuantity = count($elementsArray);
        return $elementQuantity;
    }

    public function typeValueJSByID($id, $value)
    {
        $this->webDriver->wait(20, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id($id)));
        $this->webDriver->executeScript("document.getElementById('$id').setAttribute('value', '$value');");
    }

    public function typeValueJSByName($name, $value)
    {
        $this->webDriver->wait(30, 200)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::name($name)));
        $this->webDriver->executeScript("document.getElementsByName('$name')[0].setAttribute('value', '$value');");
    }

    public function scrollPageDown()
    {
        //Проскроллить вниз
        $body = $this->webDriver->findElement(WebDriverBy::tagName('body'));
        $body->click();
        $body->sendKeys(array(WebDriverKeys::END));
    }

    public function scrollJSToElement($xpath)
    {
        $element = $this->webDriver->findElement(WebDriverBy::xpath($xpath));
        $this->webDriver->action()->moveToElement($element);
        $this->webDriver->executeScript("arguments[0].scrollIntoView(true)",[$element]);
    }

    public function clickElementJSByXpath($xpath)
    {
        $element = $this->webDriver->findElement(WebDriverBy::xpath($xpath));
        $this->webDriver->action()->moveToElement($element);
        $this->webDriver->executeScript("arguments[0].click()", [$element]);
    }

    public function textExistOnPage($text)
    {
        $source = $this->webDriver->getPageSource();
        assertTrue(strpos($source, $text) !== false);
    }
}