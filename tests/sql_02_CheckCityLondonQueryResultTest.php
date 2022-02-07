<?php

namespace tests;

use lib\Helper\QueryGenerator;
use lib\Helper\TestHelper;
use lib\PageObject\MainPage;

class sql_02_CheckCityLondonQueryResultTest extends TestHelper
{
    protected $mainPage;
    protected $queryGenerator;

    public function setUp():void
    {
        parent::setUp();
        $this->mainPage = new MainPage();
        $this->queryGenerator = new QueryGenerator();
    }

    public function test_02_CheckCityLondonQueryResult()
    {
        $query = $this->queryGenerator->selectCustomerByCityQuery("London");
        //input custom statement where city is London
        $this->mainPage->inputSqlStatement($query);
        $this->mainPage->runSqlButtonClick();
        //Get number of records into variable
        $recordQuantity = $this->mainPage->getNumberOfRecords();
        //Count result rows
        $rowQuantity = $this->mainPage->countNumberOfRows();
        //Make equal assertion
        $this->assertEquals($recordQuantity,$rowQuantity);
        //Make assertions that is quantity is 6
        $this->assertEquals(6,$recordQuantity);
        $this->assertEquals(6,$rowQuantity);
    }
}