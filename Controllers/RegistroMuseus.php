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
                        background-color: #CCCCCC;
                        color: #000000;
                        padding: 5px;
                        font-weight: bold;
                        text-transform: uppercase;
                        margin-bottom: 0;
                    }
                    .box-importante-registromuseus{
                        padding: 20px;
                        background: #dfdfdf;
                        margin-top: 30px;
                        font-size: 11px;
                    }
                    @media print {
                        h5{
                            background-color: #CCCCCC;
                            color: #000000;
                        }
                        .box-importante-registromuseus{
                            background: #dfdfdf;
                        }
                    }
                    * {
                        -webkit-print-color-adjust: exact !important;
                        color-adjust: exact !important;
                    }
                </style>";
                
            echo "<script type='text/javascript'>window.print();</script>";
        });

        $metasOrdem = array(
            'sobre' => array(
                'Sobre',
                'nome',
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
                'Gestão',
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
                'Caracterização',
                'mus_tipo',
                'mus_itinerante',
                'mus_caraterComunitario',
                'mus_comunidadeRealizaAtividades',
                'mus_tipo_tematica'
            ),
            'acervo' => array(
                'Acervo',
                'mus_acervo_propriedade',
                'tipologia',
                'mus_instr_documento',
                'mus_instr_documento_n',
                array(
                    'mus_gestao_politicaAquisicao',
                    'mus_gestao_politicaDescarte'
                )
            ),
            'publico' => array(
                'Público, Acessibilidade e Serviços',
                array(
                    'mus_status',
                    'museu_fechado'
                ),
                array(
                    'mus_ingresso_cobrado',
                    'mus_ingresso_valor'
                ),
                'horario',
                'acessibilidade_fisica',
                'mus_acessibilidade_visual',
                'mus_servicos_atendimentoEstrangeiros',
                'mus_instalacoes',
                'mus_instalacoes_capacidadeAuditorio',
                array(
                    'mus_arquivo_possui',
                    'mus_arquivo_acessoPublico'
                ),
                array(
                    'mus_biblioteca_possui',
                    'mus_biblioteca_acessoPublico'
                ),
                array(
                    'mus_servicos_visitaGuiada',
                    'mus_servicos_visitaGuiada_s'
                ),
                'mus_atividade_pub_especif',
                'mus_atividade_pub_especif_s'
            )
        );

        $id = $app->view->controller->data['id'];
        $space = $app->repo('Space')->find($id);

        $metas = $space->getMetadata();

        $_metadataSpace = $app->getRegisteredMetadata('MapasCulturais\Entities\Space');

        foreach ($_metadataSpace as $k => $meta) {
            $metasSpace[$meta->key] = $_metadataSpace[$meta->key]->label;

            if(!isset($metas[$meta->key])) continue;

            $metas[$meta->key] = ($metas[$meta->key] == 's') ? 'Sim' : $metas[$meta->key];
            $metas[$meta->key] = ($metas[$meta->key] == 'n') ? 'Não' : $metas[$meta->key];

            if(!isset($_metadataSpace[$meta->key]) && $meta->key != 'nome') continue;
            if(preg_match('/^fva/m', $meta->key)) continue;

            if(strlen($_metadataSpace[$meta->key]->label) >= 60)
                $metas[$meta->key] = '<br>' . $metas[$meta->key];

        }

        $metasSpace['tipologia'] = 'Tipologias de acervo existentes no museu:';
        $metas['tipologia']      = implode($space->terms['mus_area'], ', ');

        $metasSpace['nome'] = 'Nome do Museus';
        $metas['nome']      = $space->name;

        $metasSpace['museu_fechado'] = 'Em caso de museu fechado, qual a previsão de abertura?';
        @$metas['museu_fechado']     = $metas['mus_previsao_abertura_mes'] . "/" . $metas['mus_previsao_abertura_ano'];

        $this->render('impressao',array(
            'metasOrdem' => $metasOrdem,
            'metas'      => $metas,
            'metasSpace' => $metasSpace,
            'entity'     => $space
        ));
    }
}
?>