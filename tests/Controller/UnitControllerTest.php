<?php

namespace App\Test\Controller;

use App\Entity\Language;
use App\Entity\Unit;
use App\Repository\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnitControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UnitRepository $repository;
    private string $path = '/unit/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Unit::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Unit index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'unit[identifier]' => 'Testing',
            'unit[nativeLanguage]' => 'Testing',
            'unit[foreignLanguage]' => 'Testing',
        ]);

        self::assertResponseRedirects('/unit/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Unit();
        $fixture->setIdentifier('My Title');
        $fixture->setNativeLanguage($language);
        $fixture->setForeignLanguage($language);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Unit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $language= new Language('test-language');

        $fixture = new Unit();
        $fixture->setIdentifier('My Title');
        $fixture->setNativeLanguage($language);
        $fixture->setForeignLanguage($language);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'unit[identifier]' => 'Something New',
            'unit[nativeLanguage]' => 'Something New',
            'unit[foreignLanguage]' => 'Something New',
        ]);

        self::assertResponseRedirects('/unit/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdentifier());
        self::assertSame('Something New', $fixture[0]->getNativeLanguage());
        self::assertSame('Something New', $fixture[0]->getForeignLanguage());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $language= new Language('test-language');

        $fixture = new Unit();
        $fixture->setIdentifier('Test Unit');
        $fixture->setNativeLanguage($language);
        $fixture->setForeignLanguage($language);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/unit/');
    }
}
