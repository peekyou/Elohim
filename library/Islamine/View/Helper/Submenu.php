<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Islamine_View_Helper_FormCKEditor
 *
 * @author jeremie
 */
class Islamine_View_Helper_Submenu extends Zend_View_Helper_Abstract
{
    public function submenu()
    {
        $modelCategory = new Model_Category();
        $categories = $modelCategory->getNames();
        $html = '<ul class="subnav">';
        foreach($categories as $category)
        {
            $categoryFiltered = strtolower(str_replace(array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô,','õ','ö','ù','ú','û','ü','ý','ÿ'), array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o,','o','o','u','u','u','u','y','y'), $category));
            
            switch ($categoryFiltered)
            {
                case 'texte': $icon = 'icon-align-justify';
                    break;
                case 'audio': $icon = 'icon-music';
                    break;
                case 'video': $icon = 'icon-film';
                    break;
                case 'image': $icon = 'icon-picture';
                    break;
                default: $icon = 'icon-asterisk';
            }
            
            $html .= '<li><a href="'.$this->view->url(array(
                                        'category' => $categoryFiltered,
                                    ), 'docList', true).'"><i class="'.$icon.' icon-white"></i> '.$category.'</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}


?>
