<?php

namespace App\Tests\AppBundle\Entity;

use App\AppBundle\Entity\Dinosaur;
use App\AppBundle\Entity\Enclosure;
use App\AppBundle\Exception\DinosaursAreRunningRampantException;
use App\AppBundle\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;

class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault()
    {
        $enclosure = new Enclosure();

        //$this->assertCount(0, $enclosure->getDinosaurs());
        $this->assertEmpty($enclosure->getDinosaurs());

    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaurs());
    }

    public function testItDoesNotAllowCarnivorousDinosToMixWithHerbivores()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur());

        $this->expectException(NotABuffetException::class);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
    }

//    /**
//     * The expectedException annotations are deprecated. They will be removed in PHPUnit 9.
//     *
//     * @expectedException NotABuffetException
//     */
//    public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure()
//    {
//        $enclosure = new Enclosure();
//        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
//        $enclosure->addDinosaur(new Dinosaur());
//    }

    public function testItDoesNotAllowToAddDinosToUnsecureEnclosures()
    {
        $enclosure = new Enclosure();

        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you craaazy?!?');

        $enclosure->addDinosaur(new Dinosaur());
    }
}
