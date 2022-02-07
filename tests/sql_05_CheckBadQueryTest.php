<?php

namespace tests;

use lib\Helper\TestActions;
use lib\Helper\TestHelper;
use lib\PageObject\MainPage;

class sql_05_CheckBadQueryTest extends TestHelper
{
    protected $mainPage;
    protected $testActions;

    public function setUp():void
    {
        parent::setUp();
        $this->mainPage = new MainPage();
        $this->testActions = new TestActions();
    }

    public function test_05_CheckBadQuery()
    {
        //input bad statement
        $this->mainPage->inputSqlStatement("BAD_REQUEST");
        $this->mainPage->runSqlButtonClick();
        //Check alert with error
        $alertMessage = $this->testActions->getTextFromAlert();
        //Alert message assertions
        $this->assertStringContainsString("Error 1", $alertMessage);
        $this->assertStringContainsString("BAD_REQUEST", $alertMessage);
        $this->assertStringContainsString("syntax error", $alertMessage);
        //Accept alert message
        $this->testActions->isAlertPresentTypeAccept();
    }
}