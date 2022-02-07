<?php

namespace lib\Helper;

class QueryGenerator extends TestHelper
{
    public function selectCustomerByCityQuery($city)
    {
        $query = 'SELECT * FROM Customers where City = "'.$city.'"';
        return $query;
    }

    public function selectCustomerByContactNameQuery($contactName)
    {
        $query = 'SELECT * FROM Customers where ContactName = "'.$contactName.'"';
        return $query;
    }

    public function deleteCustomerByContactNameQuery($contactName)
    {
        $query = 'DELETE FROM Customers where ContactName = "'.$contactName.'"';
        return $query;
    }

    public function insertNewCustomerQuery($customerData)
    {
        $customerName = $customerData["CustomerName"];
        $contactName = $customerData["ContactName"];
        $address = $customerData["Address"];
        $city = $customerData["City"];
        $postalCode = $customerData["PostalCode"];
        $country = $customerData["Country"];
        $query = 'INSERT INTO Customers (CustomerName, ContactName, Address, City, PostalCode, Country) VALUES ("'.$customerName.'", "'.$contactName.'", "'.$address.'", "'.$city.'", "'.$postalCode.'", "'.$country.'")';
        return $query;
    }

    public function updateCustomerByIdQuery($id, $customerData)
    {
        $customerName = $customerData["CustomerName"];
        $contactName = $customerData["ContactName"];
        $address = $customerData["Address"];
        $city = $customerData["City"];
        $postalCode = $customerData["PostalCode"];
        $country = $customerData["Country"];
        $query = 'UPDATE Customers set CustomerName = "'.$customerName.'", ContactName = "'.$contactName.'", Address = "'.$address.'", City = "'.$city.'", PostalCode = "'.$postalCode.'", Country = "'.$country.'" WHERE CustomerID = "'.$id.'"';
        return $query;
    }
}