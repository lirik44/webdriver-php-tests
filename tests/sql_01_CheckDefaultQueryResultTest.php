<?php

namespace tests;

use lib\Helper\TestHelper;
use lib\PageObject\MainPage;

class sql_01_CheckDefaultQueryResultTest extends TestHelper
{
    protected $mainPage;

    public function setUp():void
    {
        parent::setUp();
        $this->mainPage = new MainPage();
    }

    public function test_01_CheckDefaultQueryResult()
    {
        //Run default query
        $this->mainPage->runSqlButtonClick();
        //Get number of records into variable
        $recordQuantity = $this->mainPage->getNumberOfRecords();
        //Count result rows
        $rowQuantity = $this->mainPage->countNumberOfRows();
        //Make equal assertion
        $this->assertEquals($recordQuantity,$rowQuantity);
        //Get Row result data by ContactName = Giovanni Rovelli
        $rowData = $this->mainPage->getRowByContactName("Giovanni Rovelli");
        //Check that address in rowData equal to "Via Ludovico il Moro 22"
        $this->assertEquals("Via Ludovico il Moro 22",$rowData["Address"]);
    }
}