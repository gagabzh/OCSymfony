<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 26/02/2018
 * Time: 10:28
 */

namespace OC\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antiflood extends Constraint
{
    public $message = "Vous avez déjà posté un message il y a moins de 15 secondes, merci d'attendre un peu.";
    public function validatedBy()
    {
        return 'oc_platform_antiflood'; // Ici, on fait appel à l'alias du service
    }
}