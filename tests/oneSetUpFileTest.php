<?php

namespace tests;

use lib\Helper\QueryGenerator;
use lib\Helper\TestHelper;
use lib\PageObject\MainPage;
use lib\PageObject\Customer;


class oneSetUpFileTest extends TestHelper
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

    public function test_03_CheckNewCustomerInsert()
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
        //Get new customer data from table
        $rowData = $this->mainPage->getRowByContactName($customerData["ContactName"]);
        //Check that new customer equal to generated data
        $this->assertEquals($customerData,$rowData);
    }

    public function test_04_CheckCustomerUpdate()
    {
        //Generate new customer data via faker
        $customerData = $this->customer->generateCustomer();
        //Make customer update query
        $query = $this->queryGenerator->updateCustomerByIdQuery(2, $customerData);
        //input custom update statement with generated customer
        $this->mainPage->inputSqlStatement($query);
        $this->mainPage->runSqlButtonClick();
        //Check result success
        $this->mainPage->checkStatusSuccess();
        //SELECT updated customer
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
        //Get updated customer data from table
        $rowData = $this->mainPage->getRowByContactName($customerData["ContactName"]);
        //Check that new customer equal to generated data
        $this->assertEquals($customerData,$rowData);
    }

    public function test_05_CheckBadQuery()
    {
        //input bad statement
        $this->mainPage->inputSqlStatement("BAD_REQUEST");
        $this->mainPage->runSqlButtonClick();
        //Check alert with error
        $alertMessage = $this->testActions->getTextFromAlert();
        //Alert message assertions
        $this->assertStringContainsString("Error", $alertMessage);
        $this->assertStringContainsString("BAD_REQUEST", $alertMessage);
        $this->assertStringContainsString("syntax error", $alertMessage);
        //Accept alert message
        $this->testActions->isAlertPresentTypeAccept();
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