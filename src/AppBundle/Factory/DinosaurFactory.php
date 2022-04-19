<?php

namespace App\AppBundle\Factory;

use App\AppBundle\Entity\Dinosaur;
use App\AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $specification): Dinosaur
    {
        // defaults
        // $codeName refer to genus
        $codeName = 'InG-' . random_int(1, 99999);
        $isCarnivorous = false;

        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);
        // this line is to test expect($this->>once()) and with($spec) from DinoFactoryTest
        //$length = $this->lengthDeterminator->getLengthFromSpecification('foo');

        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }
}
