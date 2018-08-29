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
                    .table-registromuseus{
                        width: 100%;
                    }
                    .table-registromuseus td{
                        text-align: left;
                    }
                    .table-registromuseus td div.divTd{
                        float:left;
                    }
                    h5{
                        background-color: #899976;
                        color: #fff;
                        padding: 5px;
                        font-weight: bold;
                        text-transform: uppercase;
                        margin-bottom: 0;
                    }
                </style>";
                
            echo "<script type='text/javascript'>//window.print();</script>";
        });

        $metasOrdem = array(
            'sobre' => array(
                'site',
                array(
                    'emailPublico',
                    'emailPrivado'
                ),
                array(
                    'telefonePublico',
                    'telefone1',
                    'telefone2'
                ),
                'endereco'
            ),
            'gestao' => array(
                array(
                    'esfera',
                    'esfera_tipo'
                ),
                'mus_esfera_tipo_federal',
                array(
                    'cnpj',
                    'mus_abertura_ano'
                ),
                array(
                    'mus_instumentoCriacao_tipo',
                    'mus_instumentoCriacao_descricao'
                ),
                'mus_contrato_gestao',
                'mus_contrato_gestao_s',
                'mus_contrato_qualificacoes',
                'mus_num_pessoas',
                array(
                    'mus_func_tercerizado',
                    'mus_func_tercerizado_s'
                ),
                array(
                    'mus_func_voluntario',
                    'mus_func_estagiario'
                ),
                array(
                    'mus_gestao_regimentoInterno',
                    'mus_gestao_planoMuseologico'
                )
            ),
            'caracterizacao' => array(
                'mus_tipo',
                'mus_itinerante',
                'mus_caraterComunitario',
                'mus_comunidadeRealizaAtividades',
                'mus_tipo_tematica'
            ),
            'acervo' => array(
                'mus_acervo_propriedade',
                'tipologia',
                'mus_instr_documento',
                'mus_instr_documento_n',
                array(
                    'mus_gestao_politicaAquisicao',
                    'mus_gestao_politicaDescarte'
                )
            )
        );

        $id = $app->view->controller->data['id'];
        $space = $app->repo('Space')->find($id);
        // var_dump($space->terms['mus_area']);die;

        $metas = $space->getMetadata();

        $_metadataSpace = $app->getRegisteredMetadata('MapasCulturais\Entities\Space');

        $html = "<table class='table-registromuseus'><tr><td><b>Nome do Museu:</b> " . $space->name . "</td></tr>";
        foreach ($metas as $k => $meta) {
            $metas[$k] = ($meta == 's') ? 'Sim' : $metas[$k];
            $metas[$k] = ($meta == 'n') ? 'Não' : $metas[$k];
            if(!isset($_metadataSpace[$k])) continue;
            if(preg_match('/^fva/m', $k)) continue;

            if(strlen($_metadataSpace[$k]->label) >= 60)
                $metas[$k] = '<br>' . $metas[$k];

            $html .= "<tr><td><b>$k  --  " . \MapasCulturais\i::__($_metadataSpace[$k]->label) . ":</b> ";
            $html .= $meta . "</td></tr>";
        }

        $metas['tipologia'] = implode($space->terms['mus_area'], ', ');
        // var_dump($_metadataSpace);die;
        $html .= "</td></tr></table>";

        $this->render('impressao',array(
            'html'       => $html,
            'metasOrdem' => $metasOrdem,
            'metas'      => $metas,
            'metasSpace' => $_metadataSpace,
            'entity'     => $space
        ));
    }
}
?>