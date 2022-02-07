<?php

namespace tests;

use lib\Helper\QueryGenerator;
use lib\Helper\TestHelper;
use lib\PageObject\MainPage;
use lib\PageObject\Customer;


class sql_06_CheckCustomerCreationAndDeleteTest extends TestHelper
{
    protected $mainPage;
    protected $queryGenerator;

    public function setUp():void
    {
        parent::setUp();
        $this->mainPage = new MainPage();
        $this->customer = new Customer();
        $this->queryGenerator = new QueryGenerator();
    }

    public function test_06_CheckCustomerCreationAndDelete()
    {
        //Generate new customer via faker
        $customerData = $this->customer->generateCustomer();
        //Make customer insert query
        $query = $this->queryGenerator->insertNewCustomerQuery($customerData);
        //input custom insert statement with generated customer
        $this->mainPage->inputSqlStatement($query);
        $this->mainPage->runSqlButtonClick();
        //Check result success
        $this->mainPage->checkStatusSuccess();
        //SELECT new customer
        $query = $this->queryGenerator->selectCustomerByContactNameQuery($customerData["ContactName"]);
        $this->mainPage->inputSqlStatement($query);
        $this->mainPage->runSqlButtonClick();
        //Get number of records into variable
        $recordQuantity = $this->mainPage->getNumberOfRecords();
        //Count result rows
        $rowQuantity = $this->mainPage->countNumberOfRows();
        //Make equal assertion
        $this->assertEquals($recordQuantity,$rowQuantity);
        //Make assertions that is quantity is 1
        $this->assertEquals(1,$recordQuantity);
        $this->assertEquals(1,$rowQuantity);
        //Delete customer query
        $query = $this->queryGenerator->deleteCustomerByContactNameQuery($customerData["ContactName"]);
        $this->mainPage->inputSqlStatement($query);
        $this->mainPage->runSqlButtonClick();
        //Check result success
        $this->mainPage->checkStatusSuccess();
        //Try to select deleted customer
        $query = $this->queryGenerator->selectCustomerByContactNameQuery($customerData["ContactName"]);
        $this->mainPage->inputSqlStatement($query);
        $this->mainPage->runSqlButtonClick();
        //Check no result
        $this->mainPage->checkNoResult();
    }

}