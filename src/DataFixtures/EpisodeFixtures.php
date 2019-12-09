<?php
namespace App\DataFixtures;
use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 6; $i++) {
            for ($j = 1; $j < 4; $j++) {
                for ($k = 1; $k < 11; $k++) {
                    $episode = new Episode();
                    $slug = new Slugify();
                    $episode->setTitle($faker->word);
                    $episode->setNumber($k);
                    $episode->setSynopsis($faker->text);
                    $episode->setSlug($slug);
                    $manager->persist($episode);
                    $this->addReference('program_' . $i . '_season_' . $j . '_episode_' . $k, $episode);
                    $episode->setSeason($this->getReference('program_' . $i . '_season_' . $j));
                }
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
