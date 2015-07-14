<?php

namespace Cwi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    public function indexAction($qid,Request $request)
    {
        $AjaxRequest=$request->query->get('ajax',0);
        $FeedFilter = $this->get('consult.feed_filter');
        $params=array('qid'=>$qid);
        $Questions=$FeedFilter->fetchquestion($params);
        //echo '<pre>';
        //print_r($Questions);
        //die;
        if($AjaxRequest==0){
            return $this->render('CwiPageBundle:Question:question.html.twig',array('question' => $Questions,'page_title'=>'Question'));
        }else{
            $template =  $this->get('twig')->render('CwiPageBundle:Question:questioncontent.html.twig',array('question' => $Questions,'page_title'=>'Category'));
            $ajax_response=array(
                'template'=>$template,
                'lastpage'=>true,
            );
            $response = new Response();
            $response->setContent(json_encode($ajax_response));
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');
            $response->send();
        }
    }
}
