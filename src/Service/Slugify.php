<?php


namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Slugify extends AbstractController
{


    public function generate(string $input) : string
    {
        if (!$input) {
            throw $this->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $input);
        $lower = strtolower($slug);
        $specials = preg_replace("/[\/_|+ -]+/", '-', $lower);
        $space = trim($specials, '-');
        return $space;

    }

}
