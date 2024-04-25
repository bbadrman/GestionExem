<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\EnseignantFactory;
use App\Factory\NoteFactory;
use App\Factory\EtudiantFactory;
use App\Factory\FiliereFactory;
use App\Factory\ModuleFactory;
use App\Factory\SemestreFactory;
use App\Factory\UserFactory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        FiliereFactory::createMany(12);
        EnseignantFactory::createMany(15);
        EtudiantFactory::createMany(25);
        SemestreFactory::createMany(4);
        ModuleFactory::createMany(14);
        NoteFactory::createMany(20);
        UserFactory::createMany(1);

        $manager->flush();
    }
}
