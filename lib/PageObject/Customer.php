<?php

namespace lib\PageObject;

use Faker;

class Customer
{
    public function generateCustomer()
    {
        $faker = Faker\Factory::create();
        $customerData = [
            'CustomerName'=>$faker->company(),
            'ContactName'=>$faker->firstName()." ".$faker->lastName(),
            'Address'=>$faker->streetAddress(),
            'City'=>$faker->city(),
            'PostalCode'=>$faker->postcode(),
            'Country'=>$faker->country(),
        ];
        return $customerData;
    }
}