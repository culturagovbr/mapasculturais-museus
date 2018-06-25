<?php

namespace MapasMuseus;

use BaseMinc;
use MapasCulturais\App;
use MapasCulturais\Definitions;
use MapasCulturais\i;

class Theme extends BaseMinc\Theme {

    protected static function _getTexts() {
        return array(
            'site: name' => 'Museus',
            'site: in the region' => 'SNB',
            'site: of the region' => 'SNB',
            'site: owner' => 'SNB',
            'site: by the site owner' => 'pelo Ministério da Cultura',
            'home: abbreviation' => "SNB",
            'home: title' => "Bem-vind@!",
            'search: verified results' => 'Museus Cadastrados',
//            'home: colabore' => "Colabore com o Mapas Culturais",
//             'home: welcome' => "Bem-vindo ao <strong>Museus BR</strong> - a maior plataforma de informações sobre os museus existentes no Brasil.<br><br>

// Você vai descobrir que nosso país é muito rico e que tem museus para todos os gostos e interesses. Em Museus BR você encontrará Museus de Arte, de História, de Ciências, de Antropologia, Museus Comunitários, Museus de Território, Museus das mais variadas temáticas e muitos outros que você sequer imagina.<br><br>

// Aqui você verificará onde estão localizados os museus do seu estado, do seu município ou de qualquer outro lugar de seu interesse, encontrando os dados de contato e serviços oferecidos como: visitas guiadas, acessibilidade, bibliotecas, arquivos, atendimento a visitantes estrangeiros e muito mais.<br><br>

// Seja qual for a pesquisa, a Plataforma Museus BR permitirá extrair os dados dos museus em formato de planilha, por meio de filtros e cruzamentos. <br><br>

// Como a Plataforma é colaborativa, você também pode participar, indicando um museu que você conheça e que ainda não faça parte da Museus BR, ou atualizando alguma informação. Basta seguir os passos na seção Como Participar. <br><br>

// Aventure-se!<br>
// Participe!<br>
// Descubra o Brasil por meio dos seus museus!<br>

// <p style='text-align:right'>Rede Nacional de Identificação de Museus</p>",
// //            'home: events' => "Você pode pesquisar eventos culturais nos campos de busca combinada. Como usuário cadastrado, você pode incluir seus eventos na plataforma e divulgá-los gratuitamente.",
// //            'home: agents' => "Você pode colaborar na gestão da cultura com suas próprias informações, preenchendo seu perfil de agente cultural. Neste espaço, estão registrados artistas, gestores e produtores; uma rede de atores envolvidos na cena cultural paulistana. Você pode cadastrar um ou mais agentes (grupos, coletivos, bandas instituições, empresas, etc.), além de associar ao seu perfil eventos e espaços culturais com divulgação gratuita.",
//             'home: spaces' => "Procure os museus incluídos na plataforma, acessando os campos de busca combinado que ajudam na precisão de sua pesqusia.",
// //            'home: projects' => "Reúne projetos culturais ou agrupa eventos de todos os tipos. Neste espaço, você encontra leis de fomento, mostras, convocatórias e editais criados, além de diversas iniciativas cadastradas pelos usuários da plataforma. Cadastre-se e divulgue seus projetos.",
// //            'home: home_devs' => 'Existem algumas maneiras de desenvolvedores interagirem com o Mapas Culturais. A primeira é através da nossa <a href="https://github.com/hacklabr/mapasculturais/blob/master/doc/api.md" target="_blank">API</a>. Com ela você pode acessar os dados públicos no nosso banco de dados e utilizá-los para desenvolver aplicações externas. Além disso, o Mapas Culturais é construído a partir do sofware livre <a href="http://institutotim.org.br/project/mapas-culturais/" target="_blank">Mapas Culturais</a>, criado em parceria com o <a href="http://institutotim.org.br" target="_blank">Instituto TIM</a>, e você pode contribuir para o seu desenvolvimento através do <a href="https://github.com/hacklabr/mapasculturais/" target="_blank">GitHub</a>.',
// //
// //            'search: verified results' => 'Resultados Verificados',
// //            'search: verified' => "Verificado


//             'entities: Spaces of the agent'=> 'Museus do agente',
//             'entities: Space Description'=> 'Descrição do Museu',
//             'entities: My Spaces'=> 'Meus Museus',
//             'entities: My spaces'=> 'Meus museus',

//             'entities: no registered spaces'=> 'nenhum museu cadastrado',
//             'entities: no spaces'=> 'nenhum museu',

//             'entities: Space' => 'Museu',
//             'entities: Spaces' => 'Museus',
//             'entities: space' => 'museu',
//             'entities: spaces' => 'museus',
//             'entities: parent space' => 'museu matriz',
//             'entities: a space' => 'um museu',
//             'entities: the space' => 'o museu',
//             'entities: of the space' => 'do museu',
//             'entities: In this space' => 'Neste museu',
//             'entities: in this space' => 'neste museu',
//             'entities: registered spaces' => 'Museus Identificados',
//             'entities: new space' => 'novo museu',
        );
    }

    public function _init() {
        $app = App::i();

        /*
         *  Modifica a consulta da API de espaços para só retornar Museus
         *
         * @see protectec/application/conf/space-types.php
         */
        $app->hook('API.<<*>>(space).params', function(&$api_params) use ($app) {
            $api_params['type'] = 'BET(60,69)';
            // if($app->view->controller->id !== 'panel')
            //     $api_params['owner'] = 'EQ('.$app->config['museus.ownerAgentId'].')';
        });

//         desconsidera o site de origem da entidade
        $app->hook('entity(space).isUserAdmin(<<*>>)', function($user, $role, &$result){
            if($user->is($role)){
                if($this->isNew() || ($this->getType() !== null && $this->getType()->id >= 60 && $this->getType()->id <= 69)){
                    $result = true;
                }
                else {
                    $result = false;
                }
            }
        });

        parent::_init();


        $app->hook('entity(<<Space>>).save:after', function() use ($app){
            if(!$this->getValidationErrors() && !$this->mus_cod){
                $getDvFromNumeroIdent = function($numIdent)
                {
                       $dgs = array();
                       for($i=0; $i < strlen($numIdent); $i++)
                               $dgs[] = $numIdent{$i};

                       $ft  = 9;
                       $sm  = 0;
                       foreach($dgs as $dg)
                       {
                               $sm += ($dg*$ft);
                               $ft -= 1;
                       }
                       $resto = $sm % 11;
                       return $resto > 1 ? (11 - $resto) : 0;
                };
                $existMusCod = function($new_cod) use($app){
                    $conn = $app->em->getConnection();
                    $tot = $conn->fetchColumn("SELECT count(*) FROM space_meta WHERE key = 'mus_cod' and value = '".$new_cod."'");
                    return $tot > 0;
                };
                $geraNumeroIdent = function () use($getDvFromNumeroIdent){
                       $pdg = array(1,2,5,6,8,9);
                       shuffle($pdg);

                       $dgs = array($pdg[0]);
                       for ($i=2; $i<=8; $i++)
                               $dgs[$i] = rand(0,9);

                       $nId = implode('',$dgs);
                       $nId .= $getDvFromNumeroIdent($nId);

                       return $nId;
                };
                do{
                    $mus_cod = $geraNumeroIdent();
                    // format mus_cod in mask 0.00.00.0000
                    $mus_cod = substr($mus_cod, 0, 1).'.'.substr($mus_cod, 1, 2).'.'.substr($mus_cod, 3, 2).'.'.substr($mus_cod, 5, 4);
                } while($existMusCod($mus_cod));
                $this->mus_cod = $mus_cod;
            }
        });

        // BUSCA POR CÓDIGO DO MUSEU
        // adiciona o join do metadado
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.join', function(&$joins, $keyword) {
            $joins .= "
                LEFT JOIN
                        e.__metadata mus_cod
                WITH
                        mus_cod.key = 'mus_cod'";
        });

        // filtra pelo valor do keyword
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword) {
            $where .= "OR lower(mus_cod.value) LIKE lower(:keyword)";
        });


        // modificações nos templates
        $app->hook('template(space.<<*>>.num-sniic):before', function(){
            $entity = $this->data->entity;

            if($entity->mus_cod)
                echo "<small><span class='label'>Código:</span> {$entity->mus_cod}</small>";
            else
                echo "<small><span class=\"label\">Código: </span><span>Preencha os campos obrigatorios e clique em salvar para gerar</span></small>";
        });

        $app->hook('template(space.<<create|edit|single>>.tabs):end', function(){
            $this->part('tabs-museu', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.tabs-content):end', function(){
            $this->part('tab-publico', ['entity' => $this->data->entity]);
            $this->part('tab-mais', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.tab-about-service):begin', function(){
            $this->part('about-service-begin', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.acessibilidade):after', function(){
            $entity = $this->data->entity;
            ?>
        <?php
        });

        $app->hook('mapasculturais.add_entity_modal', function ($meta, &$show_meta, &$class) {
            $_base = "mus_EnCorrespondencia_";
            $_key = $meta->key;
            if (isset($_key)) {
                if ($_base . "mesmo" === $_key) {
                    $show_meta = true;
                } else if (substr($_key, 0, strlen($_base)) === $_base) {
                    $class .= " en-correspondencia";
                }
            }
        });

        $app->hook('template(space.<<*>>.location):after', function(){
            $this->enqueueScript('app', 'endereco-correspondencia', 'js/endereco-correspondencia.js');
            $this->part('endereco-correspondencia', ['entity' => $this->data->entity]);
        });

        //Seal relation hook. Metadados não listados no core podem ser impressos aqui
        $app->hook('sealRelation.certificateText', function(&$mensagem, $relation){
            $mensagem = str_replace("[musCod]",$relation->owner->mus_cod, $mensagem);
        });

        // own
        $app->hook('POST(space.own)', function() use($app){
            $this->requireAuthentication();

            $entity = $this->getRequestedEntity();
            if($entity->mus_owned){
                throw new \MapasCulturais\Exceptions\PermissionDenied($app->user, $entity, 'own');
            }
            $app->disableAccessControl();
            $entity->mus_owned = true;
            $entity->owner = $app->user->profile;
            $entity->save(true);
            $app->enableAccessControl();

            $this->json(true);
        });

        // $app->hook('template(space.single.header-image):after', function(){
        //     $this->enqueueScript('app', 'botao-meu-museu', 'js/botao-meu-museu.js');
        //     $this->part('botao-meu-museu', ['entity' => $this->data->entity]);
        // });
        
        $app->hook('mapasculturais.scripts', function() use($app){
            echo "<script type='text/javascript'>
                    if(MapasCulturais.mode !== 'development'){
                        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                        ga('create', 'UA-87133854-1', 'auto');
                        ga('send', 'pageview');
                    }                    
                </script>";
        });

        $app->hook('view.render(space/<<*>>):before', function(){
            $this->addTaxonoyTermsToJs('mus_area');
        });

        $app->hook('view.render(<<*>>):before', function() use($app) {
            $this->assetManager->publishAsset('img/logo-ibram.png');
        });

        $app->hook('template(panel.<<*>>.highlighted-message):end', function() use($app){
            $this->part( 'panel/highlighted-message--numsniic');
        });

        /*
        $app->hook('template(space.<<create|edit|single>>.acessibilidade):after', function(){
            $this->part('acessibilidade', ['entity' => $this->data->entity]);
        });
        */

        // $app->hook('view.render(<<*>>):before', function() use ($app) {
        //     $app->view->enqueueScript('app', 'agenda-single', 'js/analytics.js', array('mapasculturais'));
        // });

        //Filtragem de museus por selos
        $app->hook('search.filters', function(&$filters) use($app) {
            $seals = \MapasCulturais\App::i()->repo('Seal')->findBy(array('name' => array(
                        'Formulário de Visitação Anual - 2014', 
                        'Formulário de Visitação Anual - 2015',
                        'Formulário de Visitação Anual - 2016',
                        'Registro de Museus',
                    )
                )
            );

            $seal_filter = [
                'label' => i::__('Selos'),
                'placeholder' => i::__('Selecione os Selos'),
                'fieldType' => 'checklist',
                'type' => 'custom',
                'isArray' => true,
                'isInline' => false,
                'filter' => [
                    'param' => '@seals',
                    'value' => '{val}'
                ],
                'options' => []
            ];

            foreach($seals as $seal) {
                $seal_filter['options'][] = ['value' => $seal->id, 'label' => $seal->name];
            }

            $filters['space']['seal'] = $seal_filter;
        });

        $this->enqueueScript('app', 'modal-museu', 'js/modal-museu.js');
    }

    static function getThemeFolder() {
        return __DIR__;
    }

    public function getMetadataPrefix() {
        return 'mus_';
    }

    protected function _getAgentMetadata() {
        return [];
    }

    protected function _getEventMetadata() {
        return [];
    }

    protected function _getProjectMetadata() {
        return [];
    }

    protected function _getSpaceMetadata() {
        return [
            'owned' => [
                'label' => 'Se o museu já apropriado por algum usuário'
            ],

            'cod' => [
                'label' => 'Número na Processada',
                'type' => 'readonly'
            ],

            'instituicaoMantenedora' => [
                'label' => 'Instituição mantenedora'
            ],

            'instumentoCriacao_tipo' => [
                'label' => 'Instrumento de criação',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outro',
                'options' => [
                    '' => 'Não possui',
                    'Lei',
                    'Decreto-Lei',
                    'Decreto',
                    'Portaria',
                    'Resolução',
                    'Ata de Reunião'
                ]
            ],

            'instumentoCriacao_descricao' => [
                'label' => 'Descrição do instrumento de criação',
            ],

            'status' => [
                'label' => 'Status do Museu',
                'type' => 'select',
                'options' => [
                    'aberto' => 'Aberto',
                    'fechado' => 'Fechado',
                    'implantacao' => 'Em implantação',
                    'extinto' => 'Extinto'
                ],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar o ano de abertura'),
                ]
            ],

            // caso status == Fechado î
            'previsao_abertura_mes' =>[
                'label' => 'Previsão de Abertura (Mês)',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O Mês deve ser um campo inteiro'
                ]
            ],

            'previsao_abertura_ano' =>[
                'label' => 'Previsão de Abertura (Ano)',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O Ano deve ser um campo inteiro'
                ]
            ],

            'abertura_ano' => [
                'label' => 'Ano de abertura',
                'type' => 'int',
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar o ano de abertura'),
                    'v::intVal()' => 'O ano de abertura deve ser um valor numérico inteiro'
                ]
            ],

            'itinerante' => [
                'label' => 'O museu é itinerante?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],

            // tipologia
            'tipo' => [
                'label' => 'Tipo',
                'type' => 'select',
                'options' => [
                    'Tradicional/Clássico',
                    'Virtual',
                    'Museu de território/Ecomuseu',
                    'Unidade de conservação da natureza',
                    'Jardim zoológico, botânico, herbário, oceanário ou planetário'
                ],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar o tipo do museu')
                ]
            ],

            'tipo_tematica' => [
                'label' => 'Temática do museu',
                'type' => 'select',
                'options' => [
                    'Artes, arquitetura e linguística',
                    'Antropologia e arqueologia',
                    'Ciências exatas, da terra, biológicas e da saúde',
                    'História',
                    'Educação, esporte e lazer',
                    'Meios de comunicação e transporte',
                    'Produção de bens e serviços',
                    'Defesa e segurança pública',
                ],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar a temática do museu')
                ]
            ],

            'tipo_unidadeConservacao' => [
                'label' => 'Tipo/categoria de manejo da Unidade de Conservação',
                'type' => 'select',
                'options' => [
                    '' => 'Não se aplica',
                    'Proteção integral',
                    'Uso sustentável'
                ]
            ],

            'tipo_unidadeConservacao_protecaoIntegral' => [
                'label' => 'Tipo de unidade de proteção integral',
                'type' => 'select',
                'options' => [
                    '' => 'Não se aplica',
                    'Estação Ecológica',
                    'Monumento Natural',
                    'Parque',
                    'Refúgio da Vida Silvestre',
                    'Reserva Biológica'
                ]
            ],

            'tipo_unidadeConservacao_usoSustentavel' => [
                'label' => 'Tipo de unidade de uso sustentável',
                'type' => 'select',
                'options' => [
                    '' => 'Não se aplica',
                    'Floresta',
                    'Reserva Extrativista',
                    'Reserva de Desenvolvimento Sustentável',
                    'Reserva de Fauna',
                    'Área de Proteção Ambiental',
                    'Área de Relevante Interesse Ecológico',
                    'Reserva Particular do Patrimônio Natural'
                ]
            ],


            'instalacoes' => [
                'label' => 'Instalações básicas e serviços oferecidos',
                'multiselect',
                'options' => [
                    'Bebedouro',
                    'Estacionamento',
                    'Guarda-volumes',
                    'Livraria',
                    'Loja',
                    'Restaurante e/ou Lanchonete',
                    'Sanitário',
                    'Teatro/Auditório'
                ]
            ],
            'instalacoes_capacidadeAuditorio' => [
                'label' => 'Capacidade do teatro/auditório (assentos)',
                'type' => 'int',
                'validations' => [
                    'v::numeric()' => 'a capacidade do teatro/auditório deve ser um número inteiro'
                ]
            ],
            'servicos_visitaGuiada' => [
                'label' => 'O museu promove visitas guiadas?',
                'type' => 'select',
                'options' => [ 'sim', 'não'],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar se tem visitas guiadas')
                ]
            ],
            'servicos_visitaGuiada_s' => [
                'label' => 'Em caso positivo, especifique',
                'type' => 'select',
                'options' => [
                    'SOMENTE mediante agendamento',
                    'Sem necessidade de agendamento'
                ]
            ],
            'servicos_atendimentoEstrangeiros' => [
                'label' => 'Atendimento em outros idiomas',
                'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Sinalização visual',
                    'Material de divulgação impresso',
                    'Audioguia',
                    'Guia, monitor e/ou mediador',
                    'Não possui'
                ],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar se possui acessibilidade aos turistas')
                ]
            ],
            'acessibilidade_visual' => [
                'label' => 'O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?',
                'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Guia multimídia (com monitor)',
                    'Maquetes táteis ou mapas em relevo',
                    'Obras e reproduções táteis',
                    'Tradutor de Linguagem Brasileira de Sinais (LIBRAS)',
                    'Texto/Etiquetas em braile com informações sobre os objetos expostos',
                    'Não possui'
                ],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar se possui acessibilidade audiovisual')
                ]
            ],
            'arquivo_possui' => [
                'label' => 'O museu possui arquivo histórico?',
                'type' => 'select',
                'options' => [ 'sim', 'não'],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar se possui arquivo histórico')
                ]
            ],
            'arquivo_acessoPublico' => [
                'label' => 'O arquivo tem acesso ao público?',
                'type' => 'select',
                'options' => [ 'sim', 'não'],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar se tem acesso ao público')
                ]
            ],
            'biblioteca_possui' => [
                'label' => 'O Museu possui biblioteca?',
                'type' => 'select',
                'options' => [ 'sim', 'não'],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar se possui biblioteca')
                ]
            ],
            'biblioteca_acessoPublico' => [
                'label' => 'A biblioteca tem acesso ao público?',
                'type' => 'select',
                'options' => [
                    '' => 'não se aplica',
                    'sim' => 'sim',
                    'não' => 'não',
                ],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar se a biblioteca tem acesso ao público')
                ]
            ],

            // acervo
            'acervo_propriedade' => [
                'label' => 'Propriedade do acervo',
                'type' => 'select',
                'options' => [
                    'Possui SOMENTE acervo próprio',
                    'Possui acervo próprio e em comodato',
                    'Acervo compartilhado entre órgãos/setores da mesma entidade mantenedora',
                    'Possui SOMENTE acervo em comodato/empréstimo',
                    'NÃO possui acervo',
                ]
            ],

            'acervo_material' => [
                'label' => 'O museu possui também acervo material?',
                'type' => 'select',
                'options' => [
                    'sim' => 'sim',
                    'não' => 'não'
                ]
            ],

            'acervo_material_emExposicao' => [
                'label' => 'O acervo material encontra-se em exposição?',
                'type' => 'select',
                'options' => [
                    '' => 'não se aplica',
                    'sim' => 'sim',
                    'não' => 'não'
                ]
            ],

            'caraterComunitario' => [
                'label' => 'O museu é de carater comunitário?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],

            'comunidadeRealizaAtividades' => [
                'label' => 'Em caso de museus comunitários, a comunidade realiza atividades museológicas?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],

            'ingresso_cobrado' => [
                'label' => 'O ingresso ao museu é cobrado?',
                'type' => 'select',
                'options' => [ 'sim', 'não', 'contribuição voluntária'],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar a cobrança de ingresso')
                ]
            ],

            'ingresso_valor' => [
                'label' => 'Descrição do valor do ingresso ao museu',
                'type' => 'text'
            ],

            // GESTÂO
            'gestao_regimentoInterno' => [
                'label' => 'O museu posui regimento interno?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],

            'gestao_planoMuseologico' => [
                'label' => 'O museu possui plano museológico?',
                'type' => 'select',
                'options' => ['sim', 'não'],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar o plano museológico')
                ]
            ],

            'gestao_politicaAquisicao' => [
                'label' => 'O museu possui política de aquisição de acervo?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],

            'gestao_politicaDescarte' => [
                'label' => 'O museu possui política de descarte de acervo?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],



            // FALTA DEFINIR SE VAI PARA O CORE
            'EnCorrespondencia_mesmo' => [
                'label' => 'O endereço de correspondência é o mesmo de visitação?',
                'type' => 'select',
                'options' => [ 'sim', 'não' ]
            ],

            'endereco_correspondencia' => [
                'label' => 'Endereço de correspondência'
            ],

            'EnCorrespondencia_CEP' => [
                'label' => 'CEP',
                'validations' => array(
                    'required' => \MapasCulturais\i::__('O CEP do endereço de correspondência é obrigatório')
                )
            ],
            'EnCorrespondencia_Nome_Logradouro' => [
                'label' => 'Logradouro',
                'validations' => array(
                    'required' => \MapasCulturais\i::__('O Logradouro do endereço de correspondência é obrigatório')
                )
            ],
            'EnCorrespondencia_Num' => [
                'label' => 'Número',
                'validations' => array(
                    'required' => \MapasCulturais\i::__('O Número do endereço de correspondência é obrigatório')
                )
            ],
            'EnCorrespondencia_Complemento' => [
                'label' => 'Complemento',
            ],
            'EnCorrespondencia_CaixaPostal' => [
                'label' => 'Caixa Postal',
            ],
            'EnCorrespondencia_Bairro' => [
                'label' => 'Bairro',
                'validations' => array(
                    'required' => \MapasCulturais\i::__('O Bairro do endereço de correspondência é obrigatório')
                )
            ],
            'EnCorrespondencia_Municipio' => [
                'label' => 'Município',
                'validations' => array(
                    'required' => \MapasCulturais\i::__('O Município do endereço de correspondência é obrigatório')
                )
            ],
            'EnCorrespondencia_Estado' => [
                'label' => 'Estado',
                'type' => 'select',
                'options' => array(
                    'AC'=>'Acre',
                    'AL'=>'Alagoas',
                    'AP'=>'Amapá',
                    'AM'=>'Amazonas',
                    'BA'=>'Bahia',
                    'CE'=>'Ceará',
                    'DF'=>'Distrito Federal',
                    'ES'=>'Espírito Santo',
                    'GO'=>'Goiás',
                    'MA'=>'Maranhão',
                    'MT'=>'Mato Grosso',
                    'MS'=>'Mato Grosso do Sul',
                    'MG'=>'Minas Gerais',
                    'PA'=>'Pará',
                    'PB'=>'Paraíba',
                    'PR'=>'Paraná',
                    'PE'=>'Pernambuco',
                    'PI'=>'Piauí',
                    'RJ'=>'Rio de Janeiro',
                    'RN'=>'Rio Grande do Norte',
                    'RS'=>'Rio Grande do Sul',
                    'RO'=>'Rondônia',
                    'RR'=>'Roraima',
                    'SC'=>'Santa Catarina',
                    'SP'=>'São Paulo',
                    'SE'=>'Sergipe',
                    'TO'=>'Tocantins',
                ),
                'validations' => array(
                    'required' => \MapasCulturais\i::__('O Estado do endereço de correspondência é obrigatório')
                )
            ],
            'add_info' => [
                'label' => 'Informações Adicionais de Contato',
                'type' => 'text',
            ],
            'atividade_pub_especif' => [
                'label' => 'O museu realiza atividades educativas e culturais para públicos específicos?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ],
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar atividades para públicos específicos')
                ]
            ],
            'atividade_pub_especif_s' => [
                'label' => 'Em caso positivo, especifique: escolha a(s) que mais se adeque(m)',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outro',
                'options' => [
                    'Estudantes de ensino fundamental',
                    'Estudantes de ensino médio',
                    'Estudantes universitários',
                    'Professores',
                    'Terceira idade',
                    'Pessoas com deficiência',
                    'Indígenas, quilombolas ou outras comunidades tradicionais',
                    'Turistas nacionais ',
                    'Turistas estrangeiros',
                    'Pessoas em situação de vulnerabilidade social '
                ]
            ],
            'esfera_tipo_federal' => [
                'label' => 'Em caso de Museu federal, especifique vinculação ministerial',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outro',
                'options' => [
                    'Agricultura, Pecuária e Abastecimento',
                    'Cidades',
                    'Ciência, Tecnologia, Inovação e Comunicações',
                    'Cultura',
                    'Defesa',
                    'Desenvolvimento, Indústria e Comércio Exterior ',
                    'Desenvolvimento Social e Agrário',
                    'Educação',
                    'Esporte',
                    'Fazenda',
                    'Integração Nacional',
                    'Justiça e Cidadania',
                    'Meio Ambiente',
                    'Minas e Energia',
                    'Planejamento, Orçamento e Gestão',
                    'Relações Exteriores',
                    'Saúde',
                    'Trabalho e Previdência Social',
                    'Transparência, Fiscalização e Controle    ',
                    'Transportes, Portos e Aviação Civil',
                    'Turismo ',
                    'Secretaria de Governo  ',
                    'Casa Civil   ',
                    'Gabinete de Segurança Institucional'
                ]
            ],
            'contrato_gestao' => [
                'label' => 'O museu possui algum contrato para sua gestão?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'contrato_gestao_s' => [
                'label' => 'Em caso positivo especifique a estrutura jurídica da instituição contratada',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outra',
                'options' => [
                    'Associação',
                    'Fundação',
                    'Sociedade (incluem-se aqui as sociedades de economia mista, empresas públicas e privadas)'
                ]
            ],
            'contrato_qualificacoes' => [
                'label' => 'A contratada possui qualificações?',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outra',
                'options' => [
                    'OS',
                    'OSCIP',
                    'Não possui qualificações'
                ]
            ],
            'num_pessoas' => [
                'label' => 'Quantas pessoas trabalham no museu (contabilizar terceirizados, estagiários e voluntários)?',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O Mês deve ser um campo inteiro'
                ]
            ],
            'func_tercerizado' => [
                'label' => 'O museu possui funcionários terceirizados?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'func_tercerizado_s' => [
                'label' => 'Em caso positivo, especifique quantos',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O número de funcionários deve ser um número inteiro'
                ]
            ],
            'func_voluntario' => [
                'label' => 'O museu possui voluntários?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'func_estagiario' => [
                'label' => 'O museu possui estagiários?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'instr_documento' => [
                'label' => 'Indique os instrumentos de documentação de acervo utilizados pelo Museu',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outro(s)',
                'options' => [
                    'Livro de registro/tombo/inventário manuscritos',
                    'Listagem digital (Word, Excel...)',
                    'Ficha de catalogação',
                    'Software/sistemas de catalogação informatizado'
                ]
            ],
            'instr_documento_n' => [
                'label' => 'Caso o Museu não realize nenhuma ação de documentação de seu acervo, justifique',
                'type' => 'text'
            ],
            'total_bens_culturais' => [
                'label' => 'Informe o número total de bens culturais de caráter museológico que compõem o acervo:',
                'type' => 'number'
            ],
            'exatidao_total_bens_culturais' => [
                'label' => 'Informe o número total de bens culturais de caráter museológico que compõem o acervo:',
                'type' => 'select',
                'options' => [
                    'Exato',
                    'Aproximado'
                ]
            ]
        ];
    }

    function register() {
        parent::register();
        $app = App::i();
        $app->hook('app.register', function(&$registry) {
            $group = null;
            $registry['entity_type_groups']['MapasCulturais\Entities\Space'] = array_filter($registry['entity_type_groups']['MapasCulturais\Entities\Space'], function($item) use (&$group) {
                if ($item->name === 'Museus') {
                    $group = $item;
                    return $item;
                } else {
                    return null;
                }
            });

            $registry['entity_types']['MapasCulturais\Entities\Space'] = array_filter($registry['entity_types']['MapasCulturais\Entities\Space'], function($item) use ($group) {
                if ($item->id >= $group->min_id && $item->id <= $group->max_id) {
                    return $item;
                } else {
                    return null;
                }
            });
        });

        $terms = [
            'Antropologia e Etnografia',
            'Arqueologia',
            'Arquivístico',
            'Artes Visuais',
            'Ciências Naturais e História Natural',
            'Ciência e Tecnologia',
            'História',
            'Imagem e Som',
            'Virtual',
            'Outros'
        ];

        $taxo_def = new \MapasCulturais\Definitions\Taxonomy(101, 'mus_area', 'Tipologia de Acervo', $terms, false, true);

        $app->registerTaxonomy('MapasCulturais\Entities\Space', $taxo_def);


        $add_project_types = [
            120 => 'Inscrições',
            121 => 'Pesquisa',
            122 => 'Consulta'
        ];
        foreach($add_project_types as $k => $v)
            $app->registerEntityType(new Definitions\EntityType('MapasCulturais\Entities\Project', $k, $v));
    }


    /**
    * Returns a verified entity
    * @param type $entity_class
    * @return \MapasCulturais\Entity
    */
    function getOneVerifiedEntity($entity_class) {
        $app = \MapasCulturais\App::i();

        $cache_id = __METHOD__ . ':' . $entity_class;

        if($app->cache->contains($cache_id)){
            return $app->cache->fetch($cache_id);
        }



        $controller = $app->getControllerByEntity($entity_class);

        if ($entity_class === 'MapasCulturais\Entities\Event') {
            $entities = $controller->apiQueryByLocation([
                '@from' => date('Y-m-d'),
                '@to' => date('Y-m-d', time() + 28 * 24 * 3600),
                '@verified' => '1',
                '@select' => 'id'
            ]);

        } else {
            $entities = $controller->apiQuery([
                '@select' => 'id',
                '@verified' => 'IN(1)',
            ]);
        }

        $ids = array_map(function($item) {
            return $item['id'];
        }, $entities);

        if ($ids) {
            $id = $ids[array_rand($ids)];
            $result = $app->repo($entity_class)->find($id);
            $result->refresh();
        } else {
            $result = null;
        }

        $app->cache->save($cache_id, $result, 120);

        return $result;
    }

    protected function _getFilters(){
          $filters = parent::_getFilters();
          $filters['space'] = [
                [
                    'fieldType' => 'checklist',
                    'label' => 'Estado',
                    'placeholder' => 'Selecione os Estados',
                    'filter' => [
                        'param' => 'En_Estado',
                        'value' => 'IN({val})'
                    ],
                ],
                [
                    'label' => 'Tipologia',
                    'placeholder' => 'Selecione os Tipos',
                    'filter' => [
                        'param' => 'mus_tipo',
                        'value' => 'IN({val})'
                    ],
                ],
                [
                    'label' => 'Temática do museu',
                    'placeholder' => 'Selecione as Temáticas',
                    'filter' => [
                        'param' => 'mus_tipo_tematica',
                        'value' => 'IN({val})'
                    ],
                    'validations' => [
                        'required' => \MapasCulturais\i::__('É obrigatório informar o tipo do museu')
                    ]
                ],
                'verificados' => [
                    'label' => $this->dict('search: verified results', false),
                    'tag' => $this->dict('search: verified', false),
                    'placeholder' => 'Exibir somente ' . $this->dict('search: verified results', false),
                    'fieldType' => 'checkbox-verified',
                    'addClass' => 'verified-filter',
                    'isArray' => false,
                    'filter' => [
                        'param' => '@verified',
                        'value' => '1'
                    ]
                ],
                [
                    'fieldType' => 'text',
                    'label' => 'Município',
                    'isArray' => false,
                    'placeholder' => 'Pesquisar por Município',
                    'isInline' => false,
                    'filter' => [
                        'param' => 'En_Municipio',
                        'value' => 'ILIKE(*{val}*)'
                    ]
                ],
                [
                    'isInline' => false,
                    'label' => 'Situação de funcionamento',
                    'placeholder' => 'Selecione a Situação de funcionamento',
                    'filter' => [
                        'param' => 'mus_status',
                        'value' => 'IN({val})'
                    ],
                ],
                [
                    'label' => 'Esfera',
                    'placeholder' => 'Selecione a esfera',
                    'isInline' => false,
                    'filter' => [
                        'param' => 'esfera',
                        'value' => 'IN({val})'
                    ],
                    'validations' => [
                        'required' => \MapasCulturais\i::__('É obrigatório informar a esfera')
                    ]
                ],
                [
                    'isInline' => false,
                    'label' => 'Tipo de esfera',
                    'placeholder' => 'Selecione o tipo da esfera',
                    'filter' => [
                        'param' => 'esfera_tipo',
                        'value' => 'IN({val})'
                    ],
                    'validations' => [
                        'required' => \MapasCulturais\i::__('É obrigatório informar o tipo de esfera')
                    ]
                ]
          ];
          App::i()->applyHookBoundTo($this, 'search.filters', [&$filters]);
          return $filters;
      }
}
