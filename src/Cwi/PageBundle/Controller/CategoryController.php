<?php

namespace Cwi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function indexAction($category,Request $request)
    {
        $category=strtolower($category);


        $page=$request->query->get('page',0);
        $AjaxRequest=$request->query->get('ajax',0);

        $HealthTopicsManager = $this->get('consult.general');
        $CategoryUrlHelper = $this->get('consult.basehelper');

        $HealthTopics=$HealthTopicsManager->healthtopics();
        $AllowedCategories=$CategoryUrlHelper->GenerateCategoryUrl($HealthTopics,'url');

        if(!in_array($category,$AllowedCategories))
        {
            throw $this->createNotFoundException();
        }


        $category=$CategoryUrlHelper->FriendlyUrl($category,'backward');
        $params=array('page'=>$page,'category'=>$category);
        $FeedFilter = $this->get('consult.feed_filter');
        $feeds=$FeedFilter->fetchfeed($params);

        if($page==0 && $AjaxRequest==0) {
            return $this->render('CwiPageBundle:Feed:feed.html.twig', array('feeds' => $feeds->questions,'page_title'=>'Category','page'=>$page));
        }else{
            $template =  $this->get('twig')->render('CwiPageBundle:Feed:feedcontent.html.twig',array('feeds'=>$feeds->questions,'page'=>$page));
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
