<?php

namespace tests;

use lib\Helper\QueryGenerator;
use lib\Helper\TestHelper;
use lib\PageObject\MainPage;
use lib\PageObject\Customer;


class sql_04_CheckCustomerUpdateTest extends TestHelper
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
}