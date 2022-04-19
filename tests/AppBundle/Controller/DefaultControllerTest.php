<?php

namespace App\Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class DefaultControllerTest extends WebTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;
    private $client = null;

    public function setUp(): void
    {
        $this->client = $this->makeClient();
        $this->databaseTool = $this->client->getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testEnclosuresAreShownOnHomepage()
    {
        $this->databaseTool->loadFixtures([
            'App\AppBundle\DataFixtures\LoadBasicParkData',
            'App\AppBundle\DataFixtures\LoadSecurityData',
        ]);

        $crawler = $this->client->request('GET', '/');

        $table = $crawler->filter('.table-enclosures');
        $this->assertCount(3, $table->filter('tbody tr'));
    }

    public function testThatThereIsAnAlarmButtonWithoutSecurity()
    {
        $fixtures = $this->databaseTool->loadFixtures([
            'App\AppBundle\DataFixtures\LoadBasicParkData',
            'App\AppBundle\DataFixtures\LoadSecurityData',
            ])->getReferenceRepository();

        $client = $this->makeClient();
        $crawler = $client->request('GET', '/');

        //print content in case of error
        //dump($client->getResponse()->getContent());

        $enclosure = $fixtures->getReference('carnivorous-enclosure');

        $selector = sprintf('#enclosure-%s .button-alarm', $enclosure->getId());

        $this->assertGreaterThan(0, $crawler->filter($selector)->count());
    }

    public function testItGrowsADinosaurFromSpecification()
    {
        $this->databaseTool->loadFixtures([
            'App\AppBundle\DataFixtures\LoadBasicParkData',
            'App\AppBundle\DataFixtures\LoadSecurityData',
        ]);

        $client = $this->makeClient();

        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('Grow dinosaur')->form();

        $form['enclosure']->availableOptionValues()[1];
        $form['specification']->setValue('large herbivore');

        $client->submit($form);

//        $this->assertStringContainsString(
//            'Grew a large herbivore in enclosure #3',
//            $client->getResponse()->getContent()
//        );
    }

    public function testStatusCode()
    {
        $client = $this->makeClient();

        $client->request('GET', '/');

        $this->assertStatusCode(200, $client);
    }
}
