<?php

namespace lib\Helper;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use lib\Helper\TestActions;
use PHPUnit\Framework\TestCase;

class TestHelper extends TestCase
{
    /**
     * @var RemoteWebDriver
     */

    protected $webDriver;
    protected $host;
    protected $testActions;

    public function setUp():void
    {
        parent::setUp();
        $this->testActions = new TestActions();
        //Get test name into variable
        $testName=$this->getName();
        //Setup connection
        $this->testActions->setupSeleniumSession($testName);
        //go to start link
        $hostSite = HTTPS_SCHEMA . HOST;
        $GLOBALS['webDriver']->get($hostSite);
        //setup globals
        $GLOBALS['SITE_HOST'] = $hostSite;
        $this->webDriver = $GLOBALS['webDriver'];
    }

    public function tearDown():void
    {
        //if test has failed
        if ($this->hasFailed())
        {
            //Get test name into variable
            $testName=$this->getName();
            //get screenshot
            $this->testActions->getErrorScreenshot($testName);
        }
        parent::tearDown();
        //close webdriver session
        $this->webDriver->quit();
    }
}