<?php

namespace Cwi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WidgetController extends Controller
{
    public function sidebarAction()
    {
        $HealthTopicsManager = $this->get('consult.general');
        $HealthTopics=$HealthTopicsManager->healthtopics();
        return $this->render('CwiPageBundle::sidebar.html.twig', array('topics' => $HealthTopics->specialities));
    }
}
