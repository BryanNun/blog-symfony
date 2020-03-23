<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        // Créer 3 catégories fakes
        for($i = 1; $i <= 3; $i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());

        
            $manager->persist($category);

        // Créer entre 4 et 6 articles

        $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

        for($j = 1; $j <= mt_rand(4, 6); $j++){
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreateAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

            $manager->persist($article);

            // Créer des commentaires à l'article

            for($k = 1; $k <= mt_rand(4, 10); $k++){
                $comment = new Comment();

                $days = (new \DateTime())->diff($article->getCreateAt())->days;

                $comment->setAuthor($faker->name)
                        ->setContent("Ceci est un commentaire unique pour tout les articles")
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days'))
                        ->setArticle($article);

                        $manager->persist($comment);
            }
            
        }

        }

        $manager->flush();
    }
}
