<?php

namespace Cwi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WidgetController extends Controller
{
    public function sidebarAction()
    {
        $HealthTopicsManager = $this->get('consult.general');
        $CategoryUrlHelper = $this->get('consult.basehelper');
        $HealthTopics=$HealthTopicsManager->healthtopics();
        $HealthTopics=$CategoryUrlHelper->GenerateCategoryUrl($HealthTopics);
        return $this->render('CwiPageBundle::sidebar.html.twig', array('topics' => $HealthTopics));
    }
}
