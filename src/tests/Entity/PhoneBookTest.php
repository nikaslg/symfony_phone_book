<?php


namespace App\Tests\Entity;


use App\Entity\PhoneBook;
use PHPUnit\Framework\TestCase;

class PhoneBookTest extends TestCase
{
    public function testSetName(){
        $phoneBook = new PhoneBook();

        $this->assertSame(null, $phoneBook->getName());

        $phoneBook->setName('ExpectedName');

        $this->assertSame('ExpectedName', $phoneBook->getName());
    }
} 