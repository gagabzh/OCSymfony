<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 26/02/2018
 * Time: 13:00
 */

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        // Get our userManager, you must implement `ContainerAwareInterface`
        $userManager = $this->container->get('fos_user.user_manager');

        // Les noms d'utilisateurs à créer
        $listNames = array('Alexandre', 'Marine', 'Anna');

        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user =$userManager->createUser();

            // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
            $user->setUsername($name);
            $user->setPlainPassword($name);

            // On ne se sert pas du sel pour l'instant
            $user->setEmail($name.'@test.fr');
            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(array('ROLE_USER'));
            $user->setEnabled(True);

            // On le persiste
            $userManager->updateUser($user, true);
            $manager->persist($user);
        }

        // On crée l'utilisateur
        $user =$userManager->createUser();

        // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
        $user->setUsername('bgarnier' );
        $user->setPlainPassword('bgarnier');
        $user->setEmail('bgarnier@test.fr');
        // On ne se sert pas du sel pour l'instant
        // On définit uniquement le role ROLE_USER qui est le role de base
        $user->setRoles(array('ROLE_AUTEUR'));
        $user->setEnabled(True);

        // On le persiste
        $manager->persist($user);

        // On déclenche l'enregistrement
        $manager->flush();
    }
}