<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 13/02/2018
 * Time: 16:56
 */

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;

class LoadAvert implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $names = array(
            'Alexendre',
            'Benjamin',
            'Clément',
            'David',
            'Eric'
        );

        foreach ($names as $name) {

            // Création de l'entité Advert
            $advert = new Advert();
            $advert->setTitle($name.' : Recherche développeur Symfony.');
            $advert->setAuthor($name);
            $advert->setEmail('bgarnier@aneo.fr');
            $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

            // Création de l'entité Image
            $image = new Image();
            $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
            $image->setAlt('Job de rêve');

            // On lie l'image à l'annonce
            $advert->setImage($image);




            // Étape 1 : On « persiste » l'entité
            $manager->persist($advert);



        }
        // Création d'une première candidature
        $application1 = new Application();
        $application1->setAuthor('Marine');
        $application1->setEmail('bgarnier@aneo.fr');
        $application1->setContent("J'ai toutes les qualités requises.");

        // Création d'une deuxième candidature par exemple
        $application2 = new Application();
        $application2->setAuthor('Pierre');
        $application2->setEmail('bgarnier@aneo.fr');
        $application2->setContent("Je suis très motivé.");


        // On lie la candidature à l'annonce
        $advert->addApplication($application1);
        $advert->addApplication($application2);

        // On lie l'annonce à la candidature
//        $application1->setAdvert($advert);
//        $application2->setAdvert($advert); => plus besoin car fait dans la méthode add de advert

        // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
        // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
        $manager->persist($application1);
        $manager->persist($application2);

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}