<?php

namespace Cwi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;


class FeedextractorController extends Controller
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function indexAction($params)
    {
        // $_GET parameters
        //$page=$request->query->get('page',0);

        $page=$params['page'];

        // $_POST parameters
        //$request->request->get('name');

        $limit=10;
        $offset=$page*$limit;
        $ConsultLiveUrl = $this->container->getParameter('consultliveurl');
        $buzz = $this->container->get('buzz');
        $buzz->get($ConsultLiveUrl.'/questions?limit='.$limit.'&offset='.$offset);
        $Feed=json_decode($buzz->getLastResponse()->getContent());
        $TotalPages=ceil($Feed->count/$limit) - 1;
        if($page>=$TotalPages)
        {
            $LastPage=true;
        }else{
            $LastPage=false;
        }
        if($page==0) {
            $template= $this->get('twig')->render('CwiPageBundle:Feed:feedcontent.html.twig', array('feeds' => $Feed->questions));
            $ajax_response=array(
                'template'=>$template,
                'lastpage'=>$LastPage,
            );
            $response = new Response();
            $response->setContent(json_encode($ajax_response));
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            $template =  $this->get('twig')->render('CwiPageBundle:Feed:feedcontent.html.twig',array('feeds'=>$Feed->questions));
            $ajax_response=array(
                'template'=>$template,
                'lastpage'=>$LastPage,
            );
            $response = new Response();
            $response->setContent(json_encode($ajax_response));
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');
            $response->send();
        }
    }
}
