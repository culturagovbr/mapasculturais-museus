<?php
namespace MapasMuseus\Controllers;

use MapasCulturais\App;

class RegistroMuseus extends \MapasCulturais\Controller{
    function POST_index(){
        $app = App::i();
        
        $app->hook('mapasculturais.scripts', function() use($app){
            echo "<style type='text/css'>
                    #main-header{
                        display: none;
                    }
                    body,#main-section,#main-footer{
                        background-color:#fff;
                    }
                    #main-section{
                        margin-top:20px;
                    }
                    h3{
                        color:#76923c;
                        font-weight:bold;
                        text-align:center;
                        padding: 20px 0;
                    }
                    #registro-main-impressao{
                        max-width: 800px;text-align: justify;
                        font-size:13px;
                    }
                </style>";
                
            echo "<script type='text/javascript'>window.print();</script>";
        });
        
        $id = $app->view->controller->data['id'];
        $space = $app->repo('Space')->find($id);
        
        $metas = $space->getMetadata();
        
        $_metadataSpace = $app->getRegisteredMetadata('MapasCulturais\Entities\Space');
        
        $html = "<b>Nome do Museu:</b> " . $space->name . "<hr>";
        foreach ($metas as $k => $meta) {
            if(!isset($_metadataSpace[$k])) continue;
            if(preg_match('/^fva/m', $k)) continue;
            $html .= "<b>" . \MapasCulturais\i::__($_metadataSpace[$k]->label) . ":</b> ";
            $html .= $meta . "<hr>";
        }

        $this->render('impressao',array('html' => $html));
    }
}
