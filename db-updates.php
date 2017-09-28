<?php

$app = MapasCulturais\App::i();
$em = $app->em;
$conn = $em->getConnection();

return [
    'importa base de museus' => function() use ( $app, $conn ) {
   /*
    [0] => Número na Processada
    [1] => Nome do Museu
    [2] => Natureza Administrativa
    [3] => Instituição mantenedora
    [4] => Endereço Visitação
    [5] => Número Visitação
    [6] => Complemento Visitação
    [7] => Bairro Visitação
    [8] => CEP Visitação
    [9] => Município Visitação
    [10] => UF Visitação
    [11] => Longitude
    [12] => Latitude
    [13] => Endereço Correspondência
    [14] => Número Correspondência
    [15] => Complemento Correspondência
    [16] => Caixa Postal
    [17] => Bairro Correspondência
    [18] => CEP Correspondência
    [19] => Município Correspondência
    [20] => UF Correspondência
    [21] => Telefone
    [22] => E-mail
    [23] => Site
    [24] => Antropologia e Etnografia
    [25] => Arqueologia
    [26] => Arquivístico
    [27] => Artes Visuais
    [28] => Ciências Naturais e História Natural
    [29] => Ciência e Tecnologia
    [30] => História
    [31] => Imagem e Som
    [32] => Virtual
    [33] => Outros
    [34] => 2.3 -  Em relação à temática do museu, classifique a instituição em APENAS UMA   opção:
    [35] => Ano de Abertura
    [36] => Situação de funcionamento
    [37] => Segunda_feira
    [38] => Terça-feira
    [39] => Quarta-feira
    [40] => Quinta-feira
    [41] => Sexta-feira
    [42] => Sábado
    [43] => Domingo
    [44] => O ingresso ao Museu é cobrado?
    [45] => Valor
    [46] => [Bebedouro] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [47] => [Estacionamento  ] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [48] => [Guarda-volumes  ] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [49] => [Livraria] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [50] => [Loja] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [51] => [Restaurante e/ou lanchonete] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [52] => [Sanitário] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [53] => [Teatro/Auditório ] 3.5 - Assinale as instalações básicas e serviços oferecidos pelo museu:
    [54] => 3.5.1 - Capacidade do teatro/auditório (assentos):
    [55] => O Museu promove visitas guiadas?
    [56] => O Museu possui infraestrutura para recebimento de turistas estrangeiros?
    [57] => 3.6.1 - O museu dispõe de sinalização visual em outro(s) idioma(s)?
    [58] => 3.6.2 - O museu oferece material de divulgação impresso em outros idiomas?
    [59] => 3.6.3 - O museu oferece audioguia em outros idiomas?
    [60] => 3.6.4 - O museu dispõe de guia/monitor/mediador que fala outro idioma?
    [61] => 3.7 - O museu possui infraestrutura para atender visitantes que apresentam dificuldade de locomoção?
    [62] => [Bebedouro adaptado] 3.7.1 - Especifique:
    [63] => [Cadeira de rodas para uso do visitante] 3.7.1 - Especifique:
    [64] => [Circuito de visitação adaptado] 3.7.1 - Especifique:
    [65] => [Corrimãos nas escadas e nas rampas] 3.7.1 - Especifique:
    [66] => Elevadores com cabine e portas de entrada acessíveis para pessoa portadora de deficiência ou com mobilidade reduzida
    [67] => Rampa de acesso
    [68] => sanitários adaptados com equipamentos e acessórios próprios
    [69] => [Telefone público adaptado] 3.7.1 - Especifique:
    [70] => Vagas exclusivas em estacionamento
    [71] => [Vaga de estacionamento exclusiva para idosos] 3.7.1 - Especifique:
    [72] => 3.8 - O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?
    [73] => [Guia multimídia (audioguia com monitor)] 3.8.1 - Especifique:
    [74] => [Maquetes táteis ou mapas em relevo do museu] 3.8.1 - Especifique:
    [75] => [Obras e reproduções táteis] 3.8.1 - Especifique:
    [76] => [Piso tátil] 3.8.1 - Especifique:
    [77] => sinalização em braile
    [78] => [Tradutor de Linguagem Brasileira de Sinais (LIBRAS)] 3.8.1 - Especifique:
    [79] => textos/etiquetas em braile com informações sobre os objetos em exposição
    [80] => O Museu possui arquivo histórico?
    [81] => O arquivo tem acesso ao público?
    [82] => O Museu possui biblioteca?
    [83] => A biblioteca tem acesso ao público?
    [84] => 1.3 -  CNPJ:
    [85] => 2.2  -  Em relação à sua atividade principal, indique a opção que melhor caracterize a instituição:
    [86] => 2.2.1 -  A instituição possui acervo:
    [87] => 2.5 - O museu é de caráter comunitário?
    [88] => 2.5.1 - A comunidade realiza atividades museológicas (inventário participativo, museografia...)?
    [89] => 2.6 - O Museu é:
    [90] => 2.7 - Com relação ao acervo, indique a opção que melhor caracterize a instituição:
    [91] => 2.7.1 -  O comodato/empréstimo está formalizado por meio de documento legal?
    [92] => 2.7.2 - Especifique, em meses , a duração do comodato/empréstimo (havendo mais de um contrato especificar o de maior duração):
    [93] => 2.8 - Com relação às exposições, indique a opção que melhor caracterize a instituição:
    [94] => 2.9 - O museu é itinerante?
    [95] => 2.9.1 -  O museu depende de recursos financeiros de outra instituição para a itinerância da exposição?
    [96] => 2.10 -  O museu possui também acervo material?
    [97] => 2.10.1 - Esse acervo encontra-se em exposição presencial?
    [98] => [O museu NÃO possui acervo em exposições em núcleo edificado] 2.11 - Marque a(s) opção(ões) que caracteriza(m) o museu:
    [99] => [A exposição do museu está no próprio território] 2.11 - Marque a(s) opção(ões) que caracteriza(m) o museu:
    [100] => [O museu possui núcleo(s) edificado(s) com acervo em exposição] 2.11 - Marque a(s) opção(ões) que caracteriza(m) o museu:
    [101] => [O museu possui núcleo edificado apenas como sede técnico administrativa] 2.11 - Marque a(s) opção(ões) que caracteriza(m) o museu:
    [102] => [O Museu NÃO possui núcleo edificado e NÃO possui sede técnico-administrativa] 2.11 - Marque a(s) opção(ões) que caracteriza(m) o museu:
    [103] => [O acervo do museu é composto de núcleos edificados] 2.11 - Marque a(s) opção(ões) que caracteriza(m) o museu:
    [104] => 2.12 -  Identifique o tipo/categoria de manejo da Unidade de Conservação:
    [105] => 2.12.1 - Especifique:
    [106] => 2.12.2 - Especifique:
    [107] => 3.3 - O museu é aberto ao púbico em geral ou somente para públicos específicos?
    [108] => 4.1 - O museu possui instrumento de criação?
    [109] => 4.1.1 - Especifique instrumento de criação:
    [110] => Nº e data da Lei:
    [111] => Nº e data do Decreto-Lei:
    [112] => Nº e data da Decreto:
    [113] => Nº e data da Portaria:
    [114] => Nº e data da Resolução:
    [115] => Nº e data do Ata de Reunião:
    [116] => Natureza do documento, número e data:
    [117] => 4.2 - O museu possui regimento interno?
    [118] => 4.3 -  O museu possui plano museológico?
    [119] => 6.6 - O museu possui política de aquisição de acervo?
    [120] => 6.7 - O museu possui política de descarte de acervo?
*/


        $data = file_get_contents(__DIR__ . '/museus.csv');

        $data = str_replace('erro no sistema', '', $data);

        $data = explode("\n", $data);

        $labels = explode("\t", $data[0]);

        $museus = [];

        foreach ($data as $i => $line) {
            if ($i === 0)
                continue;

            $d = explode("\t", $line);
            
            if (count($d) < 119)
                continue;

            foreach($d as $i => $val){
                $d[$i] = trim($val);
                if(trim($val) == '-'){
                    $d[$i] = '';
                }
            }

            $obj = new stdClass;

            $obj->__metadata = new stdClass;

            $obj->__metadata->mus_verificado = '1';

            $obj->__links = [];
            $obj->__terms = ['mus_area' => []];

            switch ($d[2]) {
                case 'Pública Municipal':
                    $obj->__metadata->esfera = 'Pública';
                    $obj->__metadata->esfera_tipo = 'Municipal';
                    $obj->type = 60;
                    break;

                case 'Pública Estadual':
                    $obj->__metadata->esfera = 'Pública';
                    $obj->__metadata->esfera_tipo = 'Estadual';
                    $obj->type = 60;
                    break;

                case 'Pública Federal':
                    $obj->__metadata->esfera = 'Pública';
                    $obj->__metadata->esfera_tipo = 'Federal';
                    $obj->type = 60;
                    break;

                case 'Privada':
                    $obj->__metadata->esfera = 'Privada';
                    $obj->type = 61;
                    break;

                case 'Outra':
                    $obj->__metadata->esfera_tipo = 'Outra';
                    $obj->type = 61;
                    break;

                default:
                    $obj->type = 61;
                    break;
            }

            /* [0] => Número na Processada */
            $obj->__metadata->mus_cod = $d[0];

            $obj->name = $d[1];


            $obj->__metadata->mus_instituicaoMantenedora = $d[3];

            // endereco de visitação
            $obj->__metadata->En_Nome_Logradouro = $d[4];
            $obj->__metadata->En_Num = $d[5];
            $obj->__metadata->En_Complemento = $d[6];
            $obj->__metadata->En_Bairro = $d[7];
            $obj->__metadata->En_CEP = $d[8];
            $obj->__metadata->En_Municipio = $d[9];
            $obj->__metadata->En_Estado = $d[10];

            if ($d[6]) {
                $obj->__metadata->endereco = "{$d[4]} {$d[5]}, {$d[6]}, {$d[7]}, {$d[8]}, {$d[9]}, {$d[10]}";
            } else {
                $obj->__metadata->endereco = "{$d[4]} {$d[5]}, {$d[7]}, {$d[8]}, {$d[9]}, {$d[10]}";
            }

            // (longitude,latitude)
            if($d[11] && $d[12]){
                $obj->location = "({$d[11]},{$d[12]})";
                $obj->_geo_location = "ST_GeographyFromText('POINT({$d[11]} {$d[12]})')";

            } else {
                $obj->location = "(0,0)";
                $obj->_geo_location = "ST_GeographyFromText('POINT(0 0)')";
            }

            // endereco de correspondência
            $obj->__metadata->mus_EnCorrespondencia_Nome_Logradouro = $d[13];
            $obj->__metadata->mus_EnCorrespondencia_Num = $d[14];
            $obj->__metadata->mus_EnCorrespondencia_Complemento = $d[15];
            $obj->__metadata->mus_EnCorrespondencia_CaixaPostal = $d[16];
            $obj->__metadata->mus_EnCorrespondencia_Bairro = $d[17];
            $obj->__metadata->mus_EnCorrespondencia_CEP = $d[18];
            $obj->__metadata->mus_EnCorrespondencia_Municipio = $d[19];
            $obj->__metadata->mus_EnCorrespondencia_Estado = $d[20];

            if ($d[15]) {
                $obj->__metadata->mus_endereco_correspondencia = "{$d[13]} {$d[14]}, {$d[15]}, {$d[17]}, {$d[18]}, {$d[19]}, {$d[20]}";
            } else {
                $obj->__metadata->mus_endereco_correspondencia = "{$d[13]} {$d[14]}, {$d[17]}, {$d[18]}, {$d[19]}, {$d[20]}";
            }

            if($d[16]){
                $obj->__metadata->mus_endereco_correspondencia .= ' - Caixa Postal: ' . $d[16];
            }



            if ($obj->__metadata->mus_EnCorrespondencia_Nome_Logradouro == $obj->__metadata->En_Nome_Logradouro && $obj->__metadata->mus_EnCorrespondencia_Num == $obj->__metadata->En_Num) {
                $obj->__metadata->mus_EnCorrespondencia_mesmo = 'sim';
            } else {
                $obj->__metadata->mus_EnCorrespondencia_mesmo = 'não';
            }

            $obj->__metadata->telefonePublico = $d[21];
            $obj->__metadata->emailPublico = $d[22];

            foreach (explode(";", $d[23]) as $url) {
                $url = trim($url);
                if(!$url){
                    continue;
                }

                if (!preg_match('#^https?://#', $url)) {
                    $url = 'http://' . $url;
                }

                if (preg_match('#^https?://.*(fb\.me|facebook\.com)#', $url)) {
                    $obj->__metadata->facebook = $url;
                } else if (preg_match('#^https?://plus\.google\.com#', $url)) {
                    $obj->__metadata->googleplus = $url;
                } else if (!isset($obj->__metadata->site)) {
                    $obj->__metadata->site = $url;
                } else {
                    $obj->__links[] = $url;
                }
            }

            for ($i = 24; $i <= 33; $i++) {
                if ($d[$i] != 'NULL' && is_numeric($d[$i])) {
                    $term = $labels[$i];
                    $obj->__terms['mus_area'][] = $term;
                }
            }

            if (strlen($d[34]) > 1) {
                $obj->__metadata->mus_tipo_tematica = $d[34];
            }

            if (is_numeric($d[35])) {
                $obj->__metadata->mus_abertura_ano = $d[35];
            }

            $obj->__metadata->mus_status = $d[36];

            /* @TODO:
              [37] => Segunda_feira
              [38] => Terça-feira
              [39] => Quarta-feira
              [40] => Quinta-feira
              [41] => Sexta-feira
              [42] => Sábado
              [43] => Domingo
             */

            /* vou colocar como um metadado e depois resolvemos */

            $obj->__metadata->mus_segunda   = $d[37];
            $obj->__metadata->mus_terca     = $d[38];
            $obj->__metadata->mus_quarta    = $d[39];
            $obj->__metadata->mus_quinta    = $d[40];
            $obj->__metadata->mus_sexta     = $d[41];
            $obj->__metadata->mus_sabado    = $d[42];
            $obj->__metadata->mus_domingo   = $d[43];

            // [44] => O ingresso ao Museu é cobrado?
            if ($d[44] == 'S') {
                $obj->__metadata->mus_ingresso_cobrado = 'sim';
            } else if ($d[44] == 'N') {
                $obj->__metadata->mus_ingresso_cobrado = 'não';
            }


            // [45] => Valor
            $obj->__metadata->mus_ingresso_valor = $d[45];

            $instalacoes = [
                46 => "Bebedouro",
                47 => "Estacionamento",
                48 => "Guarda-volumes",
                49 => "Livraria",
                50 => "Loja",
                51 => "Restaurante e/ou Lanchonete",
                52 => "Sanitário",
                53 => "Teatro/Auditório"
            ];

            $inst = [];
            for ($i = 46; $i <= 53; $i++) {
                if ($d[$i] == 'Sim') {
                    $inst[] = $instalacoes[$i];
                }
            }
            if ($inst) {
                $obj->__metadata->mus_instalacoes = implode(';', $inst);
            }

            if (is_numeric($d[54])) {
                $obj->__metadata->mus_instalacoes_capacidadeAuditorio = $d[54];
            }

            if ($d[55] == 'S') {
                $obj->__metadata->mus_servicos_visitaGuiada = 'sim';
            } else if ($d[55] == 'N') {
                $obj->__metadata->mus_servicos_visitaGuiada = 'não';
            }


            /*
             * [56] => O Museu possui infraestrutura para recebimento de turistas estrangeiros?
             * a questão é se vai para o core do mapas ou nao ( SE FOR PARA O CORE TEM QUE TIRAR O PREFIXO mus_ )
             */
            $atendimento_estrangeiros = [
                57 => "Sinalização visual",
                58 => "Material de divulgação impresso",
                59 => "Audioguia",
                60 => "Guia, monitor e/ou mediador",
            ];


            $aes = [];
            foreach ($atendimento_estrangeiros as $i => $val) {
                if ($d[$i] == 'Sim') {
                    $aes[] = $val;
                }
            }
            $obj->__metadata->mus_servicos_atendimentoEstrangeiros = implode(';', $aes);

            /* [61] => 3.7 - O museu possui infraestrutura para atender visitantes que apresentam dificuldade de locomoção?
             * vai para o core?? se for tem que colocar as opções no conf/space-types.php
             */

            $acessibilidade_fisica = [
                62 => 'Bebedouro adaptado',
                63 => 'Cadeira de rodas para uso do visitante',
                64 => 'Circuito de visitação adaptado',
                65 => 'Corrimão nas escadas e rampas',
                66 => 'Elevador adaptado',
                67 => 'Rampa de acesso',
                68 => 'Sanitário adaptado',
                69 => 'Telefone público adaptado',
                70 => 'Vaga de estacionamento exclusiva para deficientes',
                71 => 'Vaga de estacionamento exclusiva para idosos',
            ];

            $aes = [];
            foreach ($acessibilidade_fisica as $i => $val) {
                if ($d[$i] == 'Sim') {
                    $aes[] = $val;
                }
            }
            $obj->__metadata->acessibilidade_fisica = implode(';', $aes);


            /* [72] 3.8 - O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?
             * vai para o core?? se for tem que colocar as opções no conf/space-types.php e tirar o profixo mus_ do banco de dados
             */

            $acessibilidade_visual = [
                73 => 'Guia multimídia (audioguia com monitor)',
                74 => 'Maquetes táteis ou mapas em relevo do museu',
                75 => 'Obras e reproduções táteis',
                76 => 'Piso tátil',
                77 => 'Sinalização em braile',
                78 => 'Tradutor de Linguagem Brasileira de Sinais (LIBRAS)',
                79 => 'Texto/Etiquetas em braile com informações sobre os objetos expostos',
            ];

            $nedi = [];
            foreach ($acessibilidade_visual as $i => $val) {
                if ($d[$i] == 'Sim') {
                    $nedi[] = $val;
                }
            }
            $obj->__metadata->mus_acessibilidade_visual = implode(';', $nedi);


            // [80] => O Museu possui arquivo histórico?
            if ($d[80] == 'S') {
                $obj->__metadata->mus_arquivo_possui = 'sim';
            } else if ($d[80] == 'N') {
                $obj->__metadata->mus_arquivo_possui = 'não';
            }

            // [81] => O arquivo tem acesso ao público?
            if ($d[81] == 'S') {
                $obj->__metadata->mus_arquivo_acessoPublico = 'sim';
            } else if ($d[81] == 'N') {
                $obj->__metadata->mus_arquivo_acessoPublico = 'não';
            }

            // [82] => O Museu possui biblioteca?
            if ($d[82] == 'S') {
                $obj->__metadata->mus_biblioteca_possui = 'sim';
            } else if ($d[82] == 'N') {
                $obj->__metadata->mus_biblioteca_possui = 'não';
            }

            // [83] => A biblioteca tem acesso ao público?
            if ($d[83] == 'S') {
                $obj->__metadata->mus_biblioteca_acessoPublico = 'sim';
            } else if ($d[83] == 'N') {
                $obj->__metadata->mus_biblioteca_acessoPublico = 'não';
            }

            // [84] => 1.3 -  CNPJ:
            if (preg_match('#\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}#', $d[84])) {
                $obj->__metadata->cnpj = $d[84];
            }

            // [85] => 2.2  -  Em relação à sua atividade principal, indique a opção que melhor caracterize a instituição:
            if (strlen($d[85]) > 3) {
                $obj->__metadata->mus_atividadePrincipal = $d[85];
            }

            // [86] => 2.2.1 -  A instituição possui acervo:

            $obj->__metadata->mus_acervo_comercializacao = $d[86];
            /* mudei de idéia
            switch ($d[86]) {
                case "APENAS comercializável":
                    break;

                case "APENAS Não comercializável":
                    $obj->__metadata->mus_acervo_comercializacao = 'não comercializável';
                    break;

                case "Comercializável e não comercializável":
                    $obj->__metadata->mus_acervo_comercializacao = 'comercializável;não comercializável';
                    break;
            }
            */
            // [87] => 2.5 - O museu é de caráter comunitário?
            if ($d[87] == 'Sim') {
                $obj->__metadata->mus_caraterComunitario = 'sim';
            } else if ($d[87] == 'Não') {
                $obj->__metadata->mus_caraterComunitario = 'não';
            }

            // [88] => 2.5.1 - A comunidade realiza atividades museológicas (inventário participativo, museografia...)?
            if ($d[88] == 'Sim') {
                $obj->__metadata->mus_comunidadeRealizaAtividades = 'sim';
            } else if ($d[88] == 'Não') {
                $obj->__metadata->mus_comunidadeRealizaAtividades = 'não';
            }

            // [89] => 2.6 - O Museu é:
            if (strlen($d[89]) > 3) {
                $obj->__metadata->mus_tipo = $d[89];
            }

            // [90] => 2.7 - Com relação ao acervo, indique a opção que melhor caracterize a instituição:
//
//            if (strlen($d[90]) > 3) {
//                $obj->__metadata->mus_acervo_propriedade = $d[90];
//            }


              switch ($d[90]) {
                case 'Possui SOMENTE acervo próprio':
                    $obj->__metadata->mus_acervo_propriedade = 'próprio';
                    break;

                case 'Possui acervo próprio e em comodato':
                    $obj->__metadata->mus_acervo_propriedade = 'próprio;comodato/empréstimo';
                    break;

                case 'Acervo compartilhado entre órgãos/setores da mesma entidade mantenedora':
                    $obj->__metadata->mus_acervo_propriedade = 'compartilhado';
                    break;

                case 'Possui SOMENTE acervo em comodato/empréstimo':
                    $obj->__metadata->mus_acervo_propriedade = 'comodato/empréstimo';
                    break;

                case 'NÃO possui acervo':
                    break;
            }

            /* [91] => 2.7.1 -  O comodato/empréstimo está formalizado por meio de documento legal?
             * só tem os valores N/A e "erro no sistema" vou pular
             */

            /* [92] => 2.7.2 - Especifique, em meses , a duração do comodato/empréstimo (havendo mais de um contrato especificar o de maior duração):
             * só tem os valores N/A e "erro no sistema" vou pular
             */


            // [93] => 2.8 - Com relação às exposições, indique a opção que melhor caracterize a instituição:
            if (strlen($d[93]) > 3) {
                $obj->__metadata->mus_exposicoes_duracao = $d[93];
            }

            // [94] => 2.9 - O museu é itinerante?
            if ($d[94] == 'Sim') {
                $obj->__metadata->mus_itinerante = 'sim';
            } else if ($d[94] == 'Não') {
                $obj->__metadata->mus_itinerante = 'não';
            }

            // [95] => 2.9.1 -  O museu depende de recursos financeiros de outra instituição para a itinerância da exposição?
            if ($d[95] == 'Sim') {
                $obj->__metadata->mus_itinerante_dependeRecursos = 'sim';
            } else if ($d[95] == 'Não') {
                $obj->__metadata->mus_itinerante_dependeRecursos = 'não';
            }

            // [96] => 2.10 -  O museu possui também acervo material?
            if ($d[96] == 'Sim') {
                $obj->__metadata->mus_acervo_material = 'sim';
            } else if ($d[96] == 'Não') {
                $obj->__metadata->mus_acervo_material = 'não';
            }

            // [97] => 2.10.1 - Esse acervo encontra-se em exposição presencial?
            if ($d[97] == 'Sim') {
                $obj->__metadata->mus_acervo_material_emExposicao = 'sim';
            } else if ($d[97] == 'Não') {
                $obj->__metadata->mus_acervo_material_emExposicao = 'não';
            }

            $nucleo_edificado = [
                98 => 'O museu NÃO possui acervo em exposições em núcleo edificado',
                99 => 'A exposição do museu está no próprio território',
                100 =>'O museu possui núcleo(s) edificado(s) com acervo em exposição',
                101 => 'O Museu possui núcleo edificado apenas como sede técnico-administrativa',
                102 => 'O Museu NÃO possui núcleo edificado e NÃO possui sede técnico-administrativa',
                103 => 'O acervo do museu é composto de núcleos edificados'
            ];

            $nedi = [];
            foreach ($acessibilidade_visual as $i => $val) {
                if ($d[$i] == 'Sim') {
                    $nedi[] = $val;
                }
            }
            $obj->__metadata->mus_acervo_nucleoEdificado = implode(';', $nedi);

            // [104] => 2.12 -  Identifique o tipo/categoria de manejo da Unidade de Conservação:
            if (strlen($d[104]) > 3) {
                $obj->__metadata->mus_tipo_unidadeConservacao = $d[104];
            }

            // Tipo de unidade de proteção integral
            if (strlen($d[105]) > 3) {
                $obj->__metadata->mus_tipo_unidadeConservacao_protecaoIntegral = $d[105];
            }

            // Tipo de unidade de uso sustentável
            if (strlen($d[106]) > 3) {
                $obj->__metadata->mus_tipo_unidadeConservacao_usoSustentavel = $d[106];
            }

            // [107] => 3.3 - O museu é aberto ao púbico em geral ou somente para públicos específicos?
            if (strlen($d[107]) > 3) {
                $obj->__metadata->mus_abertura_publico = $d[107];
            }

            if ($d[108] == 'Sim') {
                $obj->__metadata->mus_instumentoCriacao_tipo = $d[109];

                /*
                 * Lei
                 * Decreto-Lei
                 * Decreto
                 * Portaria
                 * Resolução
                 * Ata de Reunião
                 * Outro
                 */

                switch ($d[109]){
                    case 'Lei':
                        $obj->__metadata->mus_instumentoCriacao_tipo = $d[110];
                        break;

                    case 'Decreto-Lei':
                        $obj->__metadata->mus_instumentoCriacao_tipo = $d[111];
                        break;

                    case 'Decreto':
                        $obj->__metadata->mus_instumentoCriacao_tipo = $d[112];
                        break;

                    case 'Portaria':
                        $obj->__metadata->mus_instumentoCriacao_tipo = $d[113];
                        break;

                    case 'Resolução':
                        $obj->__metadata->mus_instumentoCriacao_tipo = $d[114];
                        break;

                    case 'Ata de Reunião':
                        $obj->__metadata->mus_instumentoCriacao_tipo = $d[115];
                        break;

                    case 'Outro':
                        $obj->__metadata->mus_instumentoCriacao_tipo = $d[116];
                        break;

                }
            }

            // [117] => 4.2 - O museu possui regimento interno?
            if ($d[117] == 'Sim') {
                $obj->__metadata->mus_gestao_regimentoInterno = 'sim';
            } else if ($d[117] == 'Não') {
                $obj->__metadata->mus_gestao_regimentoInterno = 'não';
            }

            // [118] => 4.3 -  O museu possui plano museológico?
            if ($d[118] == 'Sim') {
                $obj->__metadata->mus_gestao_planoMuseologico = 'sim';
            } else if ($d[118] == 'Não') {
                $obj->__metadata->mus_gestao_planoMuseologico = 'não';
            }

            // [119] => 6.6 - O museu possui política de aquisição de acervo?
            if ($d[119] == 'Sim') {
                $obj->__metadata->mus_gestao_politicaAquisicao = 'sim';
            } else if ($d[119] == 'Não') {
                $obj->__metadata->mus_gestao_politicaAquisicao = 'não';
            }

            // [120] => 6.7 - O museu possui política de descarte de acervo?
            if ($d[120] == 'Sim') {
                $obj->__metadata->mus_gestao_politicaDescarte = 'sim';
            } else if ($d[120] == 'Não') {
                $obj->__metadata->mus_gestao_politicaDescarte = 'não';
            }

            $museus[] = $obj;
        }


        // importa pro banco de dados
        foreach($museus as $i => $museu){
            $id = $conn->fetchColumn("SELECT nextval('space_id_seq'::regclass)");

            echo "$i - inserindo museu de id ($id) - \"$museu->name\"\n";

            $museu->agent_id = $app->config['museus.ownerAgentId'];
            $museu->name = $conn->quote($museu->name);

            $conn->executeQuery("
                INSERT INTO space (
                     id, location,  _geo_location,  name,  status,  type,  agent_id
                ) VALUES (
                    $id, '$museu->location', $museu->_geo_location, $museu->name, 1, $museu->type, $museu->agent_id
                )
            ");


            $museu->__metadata->num_sniic = "ES-$id";

            foreach($museu->__metadata as $key => $val){
                $conn->executeQuery("
                    INSERT INTO space_meta (
                        object_id, key, value
                    ) VALUES (
                        '$id', '$key', :val
                    )", ['val' => $val]);
            }

            foreach($museu->__links as $link){
                $conn->executeQuery("
                    INSERT INTO metalist (
                        object_type, object_id, grp, title, value
                    ) VALUES (
                        'MapasCulturais\Entities\Space', '$id', 'links', :val, :val
                    )", ['val' => $link]);
            }
        }
    },

    'adiciona os termos nos museus' => function() use($app, $conn){

        $data = file_get_contents(__DIR__ . '/museus.csv');

        $data = str_replace('erro no sistema', '', $data);

        $data = explode("\n", $data);

        $labels = explode("\t", $data[0]);

        $museus = [];

        $terms = [];

        $vals = $conn->fetchAll("SELECT object_id, value FROM space_meta WHERE key = 'mus_cod'");

        $cods_ids = [];

        foreach($vals as $o){
            $cods_ids[$o['value']] = $o['object_id'];
        }



        foreach ($data as $i => $line) {
            if ($i === 0)
                continue;

            $d = explode("\t", $line);

            if (count($d) < 119)
                continue;


            foreach($d as $i => $val){
                $d[$i] = trim($val);
                if(trim($val) == '-'){
                    $d[$i] = '';
                }
            }

            $obj = new stdClass;


            $obj->cod = $d[0];

            $obj->id = $cods_ids[$obj->cod];

            $obj->terms = [];

            for ($i = 24; $i <= 33; $i++) {
                if($d[$i] != "NULL"){
                    $term = trim($labels[$i]);
                    $obj->terms[] = $term;

                    $terms[$term] = true;
                }
            }
            $museus[] = $obj;
        }

        $_terms = array_keys($terms);
        foreach($_terms as $term){
            echo "INSERINDO TERMO $term\n\n";
            $id = $conn->fetchColumn("SELECT nextval('term_id_seq'::regclass)");
            $conn->executeQuery('INSERT INTO term (id, taxonomy, term) VALUES (:id, 101, :term)',['id' => $id, 'term' => $term]);

            $terms[$term] = $id;
        }

        foreach($museus as $m){
            echo "\n\ninserindo termos ao museu de cod ($m->cod) - id ($m->id)\n";
            foreach($m->terms as $t){
                echo "  termo '$t'\n";
                $conn->executeQuery("INSERT INTO term_relation (term_id, object_type, object_id) VALUES (:id, 'MapasCulturais\Entities\Space', :obj)", ['id' => $terms[$t], 'obj' => $m->id]);
            }
        }

    },
    'adiciona termo Museu aos museus' =>  function() use($app, $conn){

        $data = file_get_contents(__DIR__ . '/museus.csv');
        $data = explode("\n", str_replace('erro no sistema', '', $data));

        $museus = [];
        $vals = $conn->fetchAll("SELECT object_id, value FROM space_meta WHERE key = 'mus_cod'");
        $cods_ids = [];

        foreach($vals as $o)
            $cods_ids[$o['value']] = $o['object_id'];

        foreach ($data as $i => $line) {
            if ($i === 0)
                continue;
            $d = explode("\t", $line);
            if (count($d) < 119)
                continue;
            foreach($d as $i => $val){
                $d[$i] = trim($val);
                if(trim($val) == '-')
                    $d[$i] = '';
            }
            $obj = new stdClass;
            $obj->cod = $d[0];
            $obj->id = $cods_ids[$obj->cod];

            $museus[] = $obj;
        }
        $id_area_museu = $conn->fetchColumn("select id from term where term = 'Museu'");
        if (!$id_area_museu){
            echo "INSERINDO TERMO Área de Atuação: Museu\n\n";
            $id_area_museu = $conn->fetchColumn("SELECT nextval('term_id_seq'::regclass)");
            $conn->executeQuery('INSERT INTO term (id, taxonomy, term) VALUES (:id, 2, :term)',
                            ['id' => $id_area_museu, 'term' => 'Museu']);
        }
        foreach($museus as $m){
            $have_term = $conn->fetchColumn(
                'select id from term_relation where term_id=:term_id and object_id=:object_id',
                ['term_id'=>$id_area_museu, 'object_id'=>$m->id]
            );
            if(!$have_term){
                echo "Inserindo termo 'Museu' ao museu de cod ($m->cod) - id ($m->id)\n";
                $conn->executeQuery(
                    "INSERT INTO term_relation (term_id, object_type, object_id) VALUES (:id, 'MapasCulturais\Entities\Space', :obj)",
                    ['id' => $id_area_museu, 'obj' => $m->id]
                );
            }
        }

    },
    'mascaras erradas para metadado add_info' =>  function() use($app, $conn){

        $data = file_get_contents(__DIR__ . '/museus.csv');
        $data = explode("\n", str_replace('erro no sistema', '', $data));

        $museus = [];
        $vals = $conn->fetchAll("SELECT object_id, value FROM space_meta WHERE key = 'mus_cod'");
        $cods_ids = [];

        foreach($vals as $o)
            $cods_ids[$o['value']] = $o['object_id'];

        foreach ($data as $i => $line) {
            if ($i === 0)
                continue;
            $d = explode("\t", $line);
            if (count($d) < 119)
                continue;
            foreach($d as $i => $val){
                $d[$i] = trim($val);
                if(trim($val) == '-')
                    $d[$i] = '';
            }
            $id_museu = $cods_ids[$d[0]];
            if (!$id_museu){
                echo "Pulando museu de código $d[0]";
                continue;
            }
            $original_email = explode(';', $d[22])[0];

            if (filter_var($original_email, FILTER_VALIDATE_EMAIL)){
                $db_email = $conn->fetchColumn(
                    "select value from space_meta where key=:key and object_id=:object_id",
                    ['key'=>'emailPublico', 'object_id' => $id_museu]
                );
                if (!$db_email){
                    echo "Inserindo email $original_email ao museu de cod ($d[0]) - id ($id_museu)\n";
                    $conn->executeQuery(
                        "INSERT INTO space_meta (object_id, key, value) VALUES (:object_id, :key, :value)",
                        ['object_id'=>$id_museu, 'key'=>'emailPublico', 'value'=>$original_email]
                    );
                } elseif (!filter_var($db_email, FILTER_VALIDATE_EMAIL)){
                    echo "Atualizando email $original_email para o museu de cod ($d[0]) - id ($id_museu)\n";
                    $conn->executeQuery(
                        "UPDATE space_meta set value=:value where object_id=:object_id and key=:key",
                        ['object_id'=>$id_museu, 'key'=>'emailPublico', 'value'=>$original_email]
                    );
                } else
                    echo "Pulando e-mail valido $original_email\n";
            }
            else
                echo "E-mail Inválido $original_email\n";

            $update_phone = function($phone) use($conn, $id_museu, $d){
                $phone_regex = '^\(+[0-9]{2,3}\) [0-9]{4}-[0-9]{4}$^';
                if(preg_match($phone_regex, $phone)) {
                    $db_phone = $conn->fetchColumn(
                        "SELECT value from space_meta where key=:key and object_id=:object_id",
                        ['key'=>'telefonePublico', 'object_id' => $id_museu]
                    );
                    if (!$db_phone){
                        echo "Inserindo telefone $phone ao museu de cod ($d[0]) - id ($id_museu)\n";
                        $conn->executeQuery(
                            "INSERT INTO space_meta (object_id, key, value) VALUES (:object_id, :key, :value)",
                            ['object_id'=>$id_museu, 'key'=>'telefonePublico', 'value'=>$phone]
                        );
                    } elseif (strlen($db_phone) !== 14 || !preg_match($phone_regex, $db_phone)){
                        echo "Atualizando telefone $phone para o museu de cod ($d[0]) - id ($id_museu)\n";
                        $conn->executeQuery(
                            "UPDATE space_meta set value=:value where object_id=$id_museu and key=:key",
                            ['key'=>'telefonePublico', 'value'=>$phone]
                        );
                    } else echo "Pulando telefone válido $db_phone";
                } else echo "Pulando fone inválido $phone";


            };

            $tels = explode('/', $d[21]);
            if(strlen($tels[0]) == 2)
                $tels = explode('/', $d[22]);
            $update_phone(substr(trim($tels[0]), 0, 14));

            $add_info = $conn->fetchColumn(
                "SELECT id from space_meta where key=:key and object_id=:object_id",
                ['key'=>'mus_add_info', 'object_id' => $id_museu ]
            );
            if (!$add_info) {
                echo "Inserindo informações adicionaos para o museu de cod ($d[0]) - id ($id_museu)\n";
                $add_info = $d[21]."\n\n".$d[22];
                $conn->executeQuery(
                    "INSERT INTO space_meta (object_id, key, value) VALUES (:object_id, :key, :value)",
                    ['object_id'=> $id_museu, 'key'=>'mus_add_info', 'value'=>$add_info]
                );
            }
        }

    },
    'acerta tematicas importadas com a lista de tematicas' =>  function() use($app, $conn){
        $space_metas = [
             ['Artes, arquitetura e linguística', 'Artes, Arquitetura e Linguística'],
             ['Antropologia e arqueologia', 'Antropologia e arqueologia'],
             ['Ciências exatas, da terra, biológicas e da saúde', 'Ciências Exatas, da Terra, Biológicas e da Saúde'],
             // ['História', 'História'],
             ['Educação, esporte e lazer', 'Educação, Esporte e Lazer'],
             ['Meios de comunicação e transporte', 'Meios de Comunicação e de Transporte'],
             ['Produção de bens e serviços', 'Produção de Bens e Serviços'],
             ['Defesa e segurança pública', 'Defesa e Segurança Pública'],

             // ['Tradicional/Clássico', 'Tradicional/Clássico'],
             ['Unidade de conservação da natureza', 'Unidade de Conservação da Natureza (Parque, Reserva, Floresta, etc.)'],
             // ['Virtual', 'Virtual'],
             ['Museu de território/Ecomuseu', 'Museu de Território/Ecomuseu'],
             ['Jardim zoológico, botânico, herbário, oceanário ou planetário', 'Jardim Zoológico, Jardim Botânico, Herbário ou Planetário']

        ];
        foreach ($space_metas as $val) {
            echo "Alterando termos importados como \"$val[1]\" para \"$val[0]\"\n";
            $conn->executeQuery(
                "UPDATE space_meta set value = :new_value where value = :old_value",
                ['new_value' => $val[0], 'old_value' => $val[1]]
            );
        }
    },
    'importa museus para o agente ibraam' => function() use($app, $conn){
        $space_ids = file_get_contents(__DIR__ . '/museus-ibram.csv');
        $space_ids = explode("\n", $space_ids);
        $space_ids = implode(",", $space_ids);
        $conn->executeQuery(
            "UPDATE space set agent_id = :agent_id where id in (".$space_ids.")",
            [
                'agent_id'  => $app->config['museus.ownerAgentId']
                // , 'space_ids' => $space_ids
            ],
            [\PDO::PARAM_INT, \Doctrine\DBAL\Connection::PARAM_INT_ARRAY]
            // array(\PDO::PARAM_INT, \PDO::PARAM_INT, \PDO::PARAM_INT, \PDO::PARAM_INT, \PDO::PARAM_INT, \PDO::PARAM_INT)
        );
    },
    'adiciona selos padrao' => function() use($app, $conn) {
        $agent = $app->config['museus.ownerAgentId'];
        $seal_id = $conn->fetchColumn("select max(id) from seal;");
        $seal_id++;
        $conn->executeQuery(
            "INSERT INTO seal (
                id,
                agent_id,
                name,
                valid_period,
                create_timestamp,
                status
            ) VALUES(
                $seal_id,
                $agent,
                'RENIM - Rede Nacional de Identificação de Museus',
                0,
                CURRENT_TIMESTAMP,
                1
            );"
        );
        $seal_id++;
        $conn->executeQuery(
            "INSERT INTO seal (
                id,
                agent_id,
                name,
                valid_period,
                create_timestamp,
                status
            ) VALUES(
                $seal_id,
                $agent,
                'SBM - Sistema Brasileiro de Museus',
                0,
                CURRENT_TIMESTAMP,
                1
            );"
        );
    },
    'remove selo padrao adicionado' => function() use($conn){
        $conn->executeQuery("
            DELETE FROM seal_relation
            WHERE   object_type = 'MapasCulturais\Entities\Space'
                AND object_id in (
                    SELECT  id
                    FROM    space
                    WHERE   is_verified = 't'
                        AND type >= 60
                        AND type <= 69
                )"
        );
    },
    'adiciona selo renim para museus verificados' => function() use($app, $conn){
        $agent = $app->config['museus.ownerAgentId'];
        $seal_id = $conn->fetchColumn("
            SELECT  id
            FROM    seal
            WHERE   name = 'RENIM - Rede Nacional de Identificação de Museus';"
        );
        $conn->executeQuery("
            INSERT INTO seal_relation
                SELECT  nextval('seal_relation_id_seq'),
                        $seal_id,
                        id,
                        CURRENT_TIMESTAMP,
                        1,
                        'MapasCulturais\Entities\Space',
                        $agent
                FROM    space
                WHERE   is_verified = 't'
                    AND type >= 60
                    AND type <= 69;"
        );
    },
    'mus: adiciona selo fva 2014' => function() use($app, $conn){
        $agent = $app->config['museus.ownerAgentId'];
        //FVA 2014 http://museus.cultura.gov.br/selo/4/
        $seal_id = 4;
        $mus_cods = explode("\n", file_get_contents(__DIR__ . '/apply-seals/seal_fva2014.csv'));
        $conn->executeQuery("
            INSERT INTO seal_relation
                SELECT  nextval('seal_relation_id_seq'),
                        $seal_id,
                        s.id,
                        CURRENT_TIMESTAMP,
                        1,
                        'MapasCulturais\Entities\Space',
                        $agent
                FROM
                    space s JOIN space_meta cod
                        ON cod.key = 'mus_cod'
                        AND cod.value IN ('" . implode("','", $mus_cods) . "')
                        AND s.id = cod.object_id;
                "
        );
    },
    'mus: adiciona selo fva 2015' => function() use($app, $conn){
        $agent = $app->config['museus.ownerAgentId'];
        //FVA 2015 http://museus.cultura.gov.br/selo/5/
        $seal_id = 5;
        $mus_cods = explode("\n", file_get_contents(__DIR__ . '/apply-seals/seal_fva2015.csv'));
        $conn->executeQuery("
            INSERT INTO seal_relation
                SELECT  nextval('seal_relation_id_seq'),
                        $seal_id,
                        s.id,
                        CURRENT_TIMESTAMP,
                        1,
                        'MapasCulturais\Entities\Space',
                        $agent
                FROM
                    space s JOIN space_meta cod
                        ON cod.key = 'mus_cod'
                        AND cod.value IN ('" . implode("','", $mus_cods) . "')
                        AND s.id = cod.object_id;
                "
        );
    },
    'mus: remove notificacoes do Ibram' => function() use($app, $conn) {
        $agent_id = $app->config['museus.ownerAgentId'];
        $conn->executeQuery("
            DELETE FROM notification WHERE id IN (
                SELECT
                    n.id
                FROM
                    notification n
                        LEFT JOIN request r ON
                            r.id = n.request_id
                WHERE
                    r.id is NULL
                    AND n.user_id = (SELECT id FROM usr WHERE profile_id = $agent_id)
            )
        ");
    },
    'normalize space meta acessibilidade' => function () use($conn, $app) {
        $spaceCounter = 0;

        function insertAcessibilidadeMeta($conn, $value, $id) {
            $conn->executeQuery("INSERT into space_meta(id, key, value, object_id) VALUES (nextval('space_meta_id_seq'::regclass), 'acessibilidade', '{$value}', {$id})");  
        }

        function updateAcessibilidadeMeta($conn, $value, $id) {
            $conn->executeQuery("UPDATE space_meta SET value = '{$value}' where object_id = {$id} AND key = 'acessibilidade'");
        }

        $space = $app->repo('Space')->findBy(array('_type'=>array(60, 61)));
        
        foreach($space as $s) {
            if(!key_exists('acessibilidade', $s->metadata)) {
                if(!key_exists('acessibilidade_fisica', $s->metadata)) {
                    insertAcessibilidadeMeta($conn, 'não', $s->id);
                    $spaceCounter++;
                }
                else {
                    /*Se existe a 'acessibilidade física' e não existe 'acessibilidade, insere 'Não' em acessibilidade caso o valor seja 'Não possui'.
                    Para todos os outros casos é marcado o valor 'Sim' */
                    if($s->metadata['acessibilidade_fisica'] === 'Não possui' || $s->metadata['acessibilidade_fisica'] === '') {
                        insertAcessibilidadeMeta($conn, 'não', $s->id);
                        $spaceCounter++;
                    }
                    else {
                        insertAcessibilidadeMeta($conn, 'sim', $s->id);
                        $spaceCounter++;
                    }
                }
            }
            else {
                /* Se não houver 'acessibilidade física' mas 'acessibilidade' está vazio, update 'acessibilidade' como 'Não' */
                if(!key_exists('acessibilidade_fisica', $s->metadata)) {
                    if($s->metadata['acessibilidade'] === '') {
                        updateAcessibilidadeMeta($conn, 'não', $s->id);
                        $spaceCounter++;
                    }
                }else {
                    /*Se existe a acessibilidade física, grava 'Não' em acessibilidade caso o valor seja 'Não possui'.
                    Para todos os outros casos é marcado o valor 'Sim' */
                    if($s->metadata['acessibilidade'] === '' && $s->metadata['acessibilidade_fisica'] === 'Não possui') {
                        updateAcessibilidadeMeta($conn, 'não', $s->id);
                        $spaceCounter++;
                    }
                    else if($s->metadata['acessibilidade'] === '' && $s->metadata['acessibilidade_fisica'] !== 'Não possui'){
                        updateAcessibilidadeMeta($conn, 'sim', $s->id);
                        $spaceCounter++;
                    }
                }
            }
        }
        
        echo "{$spaceCounter} espaços normalizados com sucesso!";
    }
];
