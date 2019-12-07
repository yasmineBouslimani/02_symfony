<?php
namespace App\DataFixtures;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 6; $i++) {
            for ($j = 1; $j < 4; $j++) {
                $season = new Season();
                $season->setYear($faker->year);
                $season->setDescription($faker->text);
                $manager->persist($season);
                $this->addReference('program_' . $i . '_season_' . $j, $season);
                $season->setProgram($this->getReference('program_' . $i));
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
