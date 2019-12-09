<?php
namespace App\DataFixtures;
use App\Entity\Actor;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\DependencyInjection\Tests\A;
class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln' => [
            'programs' => ['program_0', 'program_3'],
        ],
        'Norman Reedus' => [
            'programs' => ['program_0'],
        ],
        'Lauren Cohan' => [
            'programs' => ['program_0'],
        ],
        'Danai Gurira' => [
            'programs' => ['program_0'],
        ],
    ];
    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::ACTORS as $name => $data) {
            $actor = new Actor();
            $slugify = new Slugify();
            $actor->setName($name);
            $slug = $slugify->generate($actor->getName());
            $actor->setSlug($slug);
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $i++;
            foreach ($data['programs'] as $programs => $program) {
                $actor->addProgram($this->getReference($program));
            }
        }
        for ($j = 4; $j < 53; $j++) {
            $actor = new Actor();
            $faker = Faker\Factory::create('en_US');
            $actor->setName($faker->name);
            $manager->persist($actor);
            $this->addReference('actor_' . $j, $actor);
            $actor->addProgram($this->getReference('program_' . rand(0, 5)));
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [ProgramFixtures::class];
    }
}
