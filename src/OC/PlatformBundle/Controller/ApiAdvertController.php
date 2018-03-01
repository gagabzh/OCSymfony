<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 01/03/2018
 * Time: 14:39
 */

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;

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

}