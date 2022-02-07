<?php

namespace lib\PageObject;

use lib\Helper\TestActions;

class MainPage extends TestActions
{
    public function inputSqlStatement($query)
    {
        $this->waitElementToAppearByID(5,"tryitform");
        //input query text via JS
        $this->webDriver->executeScript("window.editor.getDoc().setValue('$query');");
    }

    public function runSqlButtonClick()
    {
        //click Run SQL button
        $this->waitElementToAppearByXpath(5, "//button[contains(.,'Run SQL')]");
        $this->clickElementWithXpath("//button[contains(.,'Run SQL')]");
    }

    public function checkStatusSuccess()
    {
        //wait for You have made changes to the database message
        $this->waitElementToAppearByXpath(5, "//div[@id='divResultSQL']//div[contains(.,'You have made changes to the database. Rows affected: 1')]");
    }

    public function checkNoResult()
    {
        //wait for You have made changes to the database message
        $this->waitElementToAppearByXpath(5, "//div[@id='divResultSQL']//div[contains(.,'No result')]");
    }

    public function getNumberOfRecords()
    {
        //Get number of records into variable
        $quantityText = $this->getTextByXpath("//div[@id='divResultSQL']/*/div[contains(.,'Number of Records')]");
        //delete text
        $quantity = str_replace("Number of Records: ","",$quantityText);
        return $quantity;
    }

    public function countNumberOfRows()
    {
        //Get number of result table rows into variable
        $rowQuantity = $this->countElementsByXpath("//div[@id='divResultSQL']//tbody/tr[not(contains(.,'CustomerID'))]");
        return $rowQuantity;
    }

    public function getRowByContactName($contactName)
    {
        //wait row to appear
        $this->waitElementToAppearByXpath(5, "//tr[contains(.,'$contactName')]");
        //Get row data into array
        $rowData = [
            'CustomerName'=>$this->getTextByXpath("//tr[contains(.,'$contactName')]/td[2]"),
            'ContactName'=>$contactName,
            'Address'=>$this->getTextByXpath("//tr[contains(.,'$contactName')]/td[4]"),
            'City'=>$this->getTextByXpath("//tr[contains(.,'$contactName')]/td[5]"),
            'PostalCode'=>$this->getTextByXpath("//tr[contains(.,'$contactName')]/td[6]"),
            'Country'=>$this->getTextByXpath("//tr[contains(.,'$contactName')]/td[7]"),
        ];
        return $rowData;
    }
}