<?php

namespace Cwi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

        $params=array('page'=>$page);
        $FeedFilter = $this->get('consult.feed_filter');
        $feeds=$FeedFilter->fetchfeed($params);

        if($page==0) {
            return $this->render('CwiPageBundle:Feed:feed.html.twig', array('feeds' => $feeds->questions));
        }else{
            $template =  $this->get('twig')->render('CwiPageBundle:Feed:feedcontent.html.twig',array('feeds'=>$feeds->questions));
            $ajax_response=array(
                'template'=>$template,
                'lastpage'=>$feeds->lastpage,
            );
            $response = new Response();
            $response->setContent(json_encode($ajax_response));
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');
            $response->send();
        }
    }
}
