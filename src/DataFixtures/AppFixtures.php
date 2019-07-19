<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Faker\Factory;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr-FR");
        
        for ($i = 1; $i <= 30; $i++){
            $article = new Article();


            $title = $faker->sentence();
            $coverImage  = $faker->imageUrl();
            $short_description  = $faker->paragraph(2);
            $detailed_description  = '<p>'. join ('</p><p>', $faker->paragraphs(5)) . '</p>';

            $article->setTitle($title);
            $article->setCoverImage($coverImage);
            $article->setShortDescription($short_description);
            $article->setDetailedDescription($detailed_description);
            $article->setPrice(mt_rand(40, 200));

            for ($j = 0; $j <= mt_rand(2, 5); $j++){
                $image = new Image();

                $image->setUrl($faker->imageUrl());
                $image->setCaption($faker->sentence());
                $image->setArticle($article);

                $manager->persist($image);
            }

            $manager->persist($article);
        }
        $manager->flush();
    }
}
