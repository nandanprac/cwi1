<?php
/**
 * Created by PhpStorm.
 * User: anushilnandan
 * Date: 09/07/15
 * Time: 10:12 AM
 */

namespace Cwi\PageBundle\Helper;

class Base
{
    public function GenerateCategoryUrl($HealthTopics,$ArrayType='detailed')
    {
        foreach($HealthTopics->specialities as $index=>$topic)
        {
            $category = new \stdClass();
            $url=$this->FriendlyUrl($topic);
            switch($ArrayType)
            {
                case 'detailed':    $category->url=$url;
                                    $category->topictext=$topic;
                                    $cat[]=$category;
                                    break;
                case 'url': $cat[]=$url; break;
            }

        }
        return $cat;
    }

    public function FriendlyUrl($text,$logic='forward')
    {
        $replace_table=array(
            ' '=>'-',
            '/'=>'~'
        );
        $text=strtolower($text);
        switch($logic)
        {
            case 'forward': $text=str_replace(array_keys($replace_table), array_values($replace_table), $text);
                            return strtolower($text);
                            break;
            case 'backward':    $text=str_replace(array_values($replace_table), array_keys($replace_table), $text);
                                $text=implode('/', array_map('ucfirst', explode('/', $text)));
                                return ucwords($text);
                                break;
        }
    }
}