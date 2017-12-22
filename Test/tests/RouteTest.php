<?php

class RouteTest extends TestCase
{
    public function testRoute()
    {
        $this->assertTrue(true);
        $this->visit('/clients');
    }

    public function testCreate()
    {
        $this->visit('/clients/create');
    }

}