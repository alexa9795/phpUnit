<?php

namespace App\Tests\AppBundle\Service;

use App\AppBundle\Entity\Dinosaur;
use App\AppBundle\Entity\Security;
use App\AppBundle\Factory\DinosaurFactory;
use App\AppBundle\Service\EnclosureBuilderService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();

        $this->truncateEntities();
    }

    public function testItBuildsEnclosureWithDefaultSpecifications()
    {
        $enclosureBuilderService = self::$kernel->getContainer()
            ->get('test.EnclosureBuilderService');

        /** @var EnclosureBuilderService $enclosureBuilderService */
        $enclosureBuilderService->buildEnclosure();

          // Sometimes you may want to use partial mocking => create new EnclosureBuilderService,
          // but mock DinosaurFactory in order to test expected result
//        $dinoFactory = $this->createMock(DinosaurFactory::class);
//        $dinoFactory->expects($this->any())
//            ->method('growFromSpecification')
//            ->willReturnCallback(function($spec) {
//                return new Dinosaur();
//            });
//
//        $enclosureBuilderService = new EnclosureBuilderService(
//            $this->getEntityManager(),
//            $dinoFactory
//        );
//        $enclosureBuilderService->buildEnclosure();

        $em = $this->getEntityManager();

        $count = (int) $em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(1, $count, 'Amount of security systems is not the same');

        $count = (int) $em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(3, $count, 'Amount of dinosaurs is not the same');
    }

    private function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
