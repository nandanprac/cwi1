<?php
/**
 * Created by PhpStorm.
 * User: anushilnandan
 * Date: 08/07/15
 * Time: 6:35 AM
 */

namespace Cwi\PageBundle\Manager;

use GuzzleHttp\Client;
use Symfony\Component\Security\Acl\Exception\Exception;

class BaseManager
{
    protected $ConsultUrl;

    public function __construct($ConsultUrl)
    {
        $this->ConsultUrl=$ConsultUrl;
    }

    public function healthtopics()
    {
        $client = new Client(array('base_url'=>$this->ConsultUrl));
        $response = $client->get('master/specialities');
        return json_decode($response->getBody());
    }

}