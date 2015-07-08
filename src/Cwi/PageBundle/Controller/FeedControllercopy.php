<?php

namespace Cwi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FeedController extends Controller
{
    /*public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }*/

    public function indexAction(Request $request)
    {
        // $_GET parameters
        $page=$request->query->get('page',0);

        // $_POST parameters
        //$request->request->get('name');
        //echo '<prE>';
        //print_r($request);
        //die;

        /*$limit=10;
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
        }*/
        $params=array('d'=>'s');
        $FeedFilter = $this->get('feed_filter');
        $abc=$FeedFilter->fetchfeed($params);
        echo $abc;die;
        $LastPage=false;

        $request=array('page'=>0);
        $abc=$this->forward('feed_filter:indexAction',array('params'=>$request));
        $abc=json_decode($abc->getContent());

        if($page==0) {
            return $this->render('CwiPageBundle:Feed:feed.html.twig', array('feeds' => $abc->template));
        }else{
            //$template =  $this->get('twig')->render('CwiPageBundle:Feed:feedcontent.html.twig',array('feeds'=>$Feed->questions));
            $ajax_response=array(
                'template'=>$abc->template,
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
