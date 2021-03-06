<?php

namespace App\AppBundle\DataFixtures;

use App\AppBundle\Entity\Enclosure;
use App\AppBundle\Entity\Security;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadSecurityData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $herbivorousEnclosure = $this->getReference('herbivorous-enclosure');

        $this->addSecurity($herbivorousEnclosure, 'Fence', true);

        $carnivorousEnclosure = $this->getReference('carnivorous-enclosure');

        $this->addSecurity($carnivorousEnclosure, 'Electric fence', false);
        $this->addSecurity($carnivorousEnclosure, 'Guard tower', false);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

    private function addSecurity(
        Enclosure $enclosure,
        string $name,
        bool $isActive
    )
    {
        $enclosure->addSecurity(new Security($name, $isActive, $enclosure));
    }
}
