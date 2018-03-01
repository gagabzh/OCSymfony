<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 01/03/2018
 * Time: 14:39
 */

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;

use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Form\AdvertTypeApi;
use OC\PlatformBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class ApiAdvertController extends Controller
{

    public function apiShowAction(Request $request)
    {
        if ($request->isMethod('GET'))
        {
            $em = $this->getDoctrine()->getManager();
            $new = $em->getRepository('OCPlatformBundle:Advert')->find($request->get('id'));
            if (null === $new) {
                $data = $this->get('jms_serializer')->serialize("error id : ".$request->get('id')." not found", 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                return $response;
            }
            $data = $this->get('jms_serializer')->serialize($new, 'json');

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        else{
            $data = $this->get('jms_serializer')->serialize("error", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
            return $response;
        }

    }
    public function apiHomeAction(Request $request)
    {
        if ($request->isMethod('GET'))
        {
            $data = $this->get('jms_serializer')->serialize("{description:'Api du blog de gestion d\'annonce'}", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        else{
            $data = $this->get('jms_serializer')->serialize("error", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
            return $response;
        }
    }
    public function apiListAction(Request $request)
    {
        if ($request->isMethod('GET'))
        {
            $em = $this->getDoctrine()->getManager();
            $new = $em->getRepository('OCPlatformBundle:Advert')->findAll();
            if (null === $new) {
                $data = $this->get('jms_serializer')->serialize("error id : ".$request->get('id')." not found", 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                return $response;
            }
            $data = $this->get('jms_serializer')->serialize($new, 'json');

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        elseif ($request->isMethod('POST'))
        {
            $advert = new Advert();
            $form = $this->get('form.factory')->create(AdvertTypeApi::class, $advert);
            $form->submit($request->request->all());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                // l'entité vient de la base, donc le merge n'est pas nécessaire.
                // il est utilisé juste par soucis de clarté
                $em->merge($advert);
                $em->flush();
                $data = $this->get('jms_serializer')->serialize($advert, 'json');

                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            } else {
                $data = $this->get('jms_serializer')->serialize($form->getErrors(), 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(500);
                return $response;
            }

        }

        else{
            $data = $this->get('jms_serializer')->serialize("error", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
            return $response;
        }
    }
}