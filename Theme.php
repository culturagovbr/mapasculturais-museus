<?php

namespace MapasMuseus;

use BaseMinc;
use MapasCulturais\App;
use MapasCulturais\Definitions;
use MapasCulturais\i;
use Doctrine\ORM\Query\ResultSetMapping;

class Theme extends BaseMinc\Theme {

    private $selosCustom = ['cadastrado' => 'Museu Cadastrado', 'registro' => 'Registro de Museus'];

    public function _init() {
        $app = App::i();
        $_self = $this;
        $selosCustom = $this->selosCustom;

        $app->registerController('registromuseus', 'MapasMuseus\Controllers\RegistroMuseus');

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

        // desconsidera o site de origem da entidade
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
                echo "<small><span class=\"label\">Código: </span><span>Preencha os campos obrigatórios e clique em salvar para gerar</span></small>";
        });

        $app->hook('template(space.<<create|edit|single>>.tabs):end', function(){
            $this->part('tabs-museu', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.tabs-content):end', function(){
            $this->part('tab-publico', ['entity' => $this->data->entity]);
            $this->part('tab-mais', ['entity' => $this->data->entity]);

            if(self::checkSealRegistro() == 0)
                $this->part('tab-registro', ['entity' => $this->data->entity]);
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

        $app->hook('template(space.<<*>>.location-info):after', function() use($app){
            $_metadataSpace = $app->getRegisteredMetadata('MapasCulturais\Entities\Space');
            echo '<p>
                <span class="label">' . \MapasCulturais\i::__($_metadataSpace['mus_territorioCultural']->label) . ':</span>
                <span class="js-editable" data-edit="mus_territorioCultural" data-original-title="' . \MapasCulturais\i::__($_metadataSpace['mus_territorioCultural']->label). '" data-emptytext="Informe">' .
                    $this->data->entity->mus_territorioCultural
                . '</span>
            </p>';
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

        $app->hook("API.find(space).result", function($p, &$result) use ($_self,$app) {
            $rsm = new ResultSetMapping();
            $rsm->addScalarResult('seal_id', 'id_selo_ibram');
            $selosIBRAM = $_self->getIBRAMSeals($app);

           if (is_array($result)) {
               $i=0;
               foreach ($result as $museu) {
                   $dql = "SELECT seal_id FROM seal_relation WHERE object_id = ?";
                   $query = $app->em->createNativeQuery($dql, $rsm);
                   $query->setParameter(1, $museu["id"]);
                   $selos_museu = $query->getResult(2);

                   $selos = [];
                   array_map(function ($s) use (&$selos) {
                       $__d = $s["id_selo_ibram"];
                       if (is_int($__d) && !is_null($__d)) {
                           array_push($selos, $__d);
                       }
                   },$selos_museu);

                   foreach ($selosIBRAM as $_selo) {
                       $valor = "não";
                       if (in_array($_selo->id, $selos))
                           $valor = "sim";

                       $result[$i][$_selo->name] = $valor;
                   }
                   $i++;
               }
           }
        });

        /*
         * Não utilizado no momento
        $app->hook('API.(space).result.extra-header-fields', function() use ($_self, $app) {
            foreach ($_self->getIBRAMSeals($app) as $IBRAMSeal)
                echo "<th> $IBRAMSeal->name </th>";
        });*/

        /*
        $app->hook('template(space.<<create|edit|single>>.acessibilidade):after', function(){
            $this->part('acessibilidade', ['entity' => $this->data->entity]);
        });
        */

        // $app->hook('view.render(<<*>>):before', function() use ($app) {
        //     $app->view->enqueueScript('app', 'agenda-single', 'js/analytics.js', array('mapasculturais'));
        // });

        //Filtragem de museus por selos
        $app->hook('search.filters', function(&$filters) use($app,$selosCustom) {
            //Seleciona todos os selos que iniciam com o nome 'Formulário de Visitação Anual - '
            $dql = "SELECT u FROM MapasCulturais\Entities\Seal u WHERE u.name LIKE 'Formulário de Visitação Anual - %' ORDER BY u.name";

            $query = \MapasCulturais\App::i()->em->createQuery($dql);
            $sealsFvaQ = $query->getResult();

            $sealsFvas = [];
            foreach ($sealsFvaQ as $selo) {
                $sealsFvas[] = $selo->name;
            }

            $seals = \MapasCulturais\App::i()->repo('Seal')->findBy(array('name' => array_merge($sealsFvas,array(
                    $selosCustom['registro'], $selosCustom['cadastrado'])))
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
                if($seal->name != $selosCustom['registro']){
                    if($seal->name == $selosCustom['cadastrado'])
                        $second_seal = ['value' => $seal->id, 'label' => $seal->name];
                    else
                        $seal_filter['options'][] = ['value' => $seal->id, 'label' => $seal->name];
                }else
                    $first_seal = ['value' => $seal->id, 'label' => $seal->name];
            }

            usort($seal_filter['options'], function($a, $b) {
                return strcmp(strtolower($a['label']), strtolower($b['label']));
            });

            if (isset($first_seal) && isset($second_seal)) {
                array_unshift($seal_filter['options'],$first_seal,$second_seal);
            }        

            $filters['space']['seal'] = $seal_filter;
        });

        $this->enqueueScript('app', 'modal-museu', 'js/modal-museu.js');
    }
    
    private function getIBRAMSeals($app) {
        $dql = "SELECT u FROM MapasCulturais\Entities\Seal u WHERE u.name LIKE 'Formulário de Visitação Anual - %' ORDER BY u.name";
        $query = $app->em->createQuery($dql);
        $selosFVA = $query->getResult();

        $registro_museus  = $app->repo('Seal')->findBy(['name'=> $this->selosCustom['registro']]);
        $museu_cadastrado = $app->repo('Seal')->findBy(['name'=> $this->selosCustom['cadastrado']]);

        if (is_array($registro_museus) && !empty($registro_museus) && $registro_museus[0] instanceof \MapasCulturais\Entities\Seal)
            $selosFVA[] = $registro_museus[0];

        if (is_array($museu_cadastrado) && !empty($registro_museus) && $museu_cadastrado[0] instanceof \MapasCulturais\Entities\Seal)
            $selosFVA[] = $museu_cadastrado[0];

        return $selosFVA;
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
                'validations' => [
                    'required' => \MapasCulturais\i::__('É obrigatório informar o total de bens culturais')
                ]
            ],
            'exatidao_total_bens_culturais' => [
                'label' => 'Informe o número total de bens culturais de caráter museológico que compõem o acervo:',
                'type' => 'select',
                'options' => [
                    'Exato',
                    'Aproximado'
                ]
            ],
            'territorioCultural' => [
                'label' => 'Território Cultural (para utilização do Sistema de Museus)'
            ],
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

    protected function checkSealRegistro() {
        if (array_key_exists('museus.sealRegistroMuseu', App::i()->config) && is_numeric($this->data->entity->id)) {
            $selo_museu = App::i()->config['museus.sealRegistroMuseu'];
            $dql = 'SELECT COUNT(e) FROM \MapasCulturais\Entities\SpaceSealRelation e WHERE e.seal = ' . $selo_museu . ' AND e.objectId = ' . $this->data->entity->id;
            $query = App::i()->em->createQuery($dql);

            return $query->getSingleScalarResult();
        }
    }
}
