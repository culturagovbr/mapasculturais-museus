<?php
namespace MapasMuseus\Controllers;

use MapasCulturais\App;

class RegistroMuseus extends \MapasCulturais\Controller{
    function POST_impressao(){
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
                    .table-registromuseus td{
                        text-align: left;
                    }
                </style>";
                
            echo "<script type='text/javascript'>window.print();</script>";
        });

        $id = $app->view->controller->data['id'];
        $space = $app->repo('Space')->find($id);

        $metas = $space->getMetadata();

        $_metadataSpace = $app->getRegisteredMetadata('MapasCulturais\Entities\Space');

        $html = "<table class='table-registromuseus'><tr><td><b>Nome do Museu:</b> " . $space->name . "</td></tr>";
        foreach ($metas as $k => $meta) {
            if(!isset($_metadataSpace[$k])) continue;
            if(preg_match('/^fva/m', $k)) continue;
            $html .= "<tr><td><b>" . \MapasCulturais\i::__($_metadataSpace[$k]->label) . ":</b> ";
            $html .= $meta . "</td></tr>";
        }

        $html .= "</td></tr></table>";

        $this->render('impressao',array('html' => $html));
    }
}
?>