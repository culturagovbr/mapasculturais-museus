$(function(){

    //Seta algumas funcionalidades padrão do tema
    function setDefaults(){
        //default do campo de correspondência é ser o mesmo da visitação
        $('#mus_EnCorrespondencia_mesmo').editable('setValue', 'sim');
        $('.js-endereco-correspondencia').hide();

        //Como o core não estabelece como requerido os campos do endereço, o CSS será adicionado via JS
        $('#En_CEP, #En_Nome_Logradouro, #En_Num, #En_Estado, ' +
          '#En_Bairro, #En_Municipio').siblings('.label').addClass('required');
    };

    /**
     * Seta os warnings nas abas com o número de erros
     * @return void
     */
    function setWarningsCount(){
        //Listener da requisição ajax para salvar o museu
        $(document).ajaxComplete(function(event, xhr){
            var tabsToWarn = getInactiveTabs();
            tabsToWarn = countWarningsPerTab(tabsToWarn);
            
            for(var key in tabsToWarn){
                var warnings = tabsToWarn[key].numberOfWarnings;

                if(warnings > 0){
                    var errorHtml = '<span id="tab-warning" title="Há ' + warnings + ' item(s) obrigatório(s) nesta aba. Verifique e tente novamente." class="danger hltip js-response-error" data-hltip-classes="hltip-danger"></span>';
                    $('#'+tabsToWarn[key].idTab).append(errorHtml);
                }
            }
        });
    };

    /**
     * Identifica a tab ativa e retorna as tabs não ativas.
     * cada tab está representada pelo id da aba em si (idTab) e 
     * o id do corpo da respectiva tab (idBody)
     * 
     * @return obj
     */
    function getInactiveTabs(){
        var tabs = {
            sobre:{
                idTab: 'tab-sobre',
                idBody: '#sobre'
            },
            publico:{
                idTab: 'tab-tab-publico',
                idBody: '#tab-publico'
            },
            info:{
                idTab: 'tab-tab-mais',
                idBody: '#tab-mais'
            }
        }

        var activeTab = $('.main-content > ul.abas > li.active > a').attr('id');
        for(var key in tabs){
            var currentTabID = tabs[key].idTab;
            
            if(currentTabID === activeTab){
                delete tabs[key];
            }
        }

        return tabs;
    }

    /**
     * Conta o número de warnings em cada tab e seta uma nova propriedade
     * 'numberOfWarnings' com o valor correspondente de cada aba
     * 
     * @param {obj} tabs
     * @return {obj} tabs
     */
    function countWarningsPerTab(tabs){
        for(var key in tabs){
            if(key == 'sobre'){
                tabs[key].numberOfWarnings = countSobreTab();
            }else{
                tabs[key].numberOfWarnings = $(tabs[key].idBody + ' > .servico > p').find('.danger').length;
            }
        }

        return tabs;
    }

    /**
     * Conta o número de warnings na tab 'sobre'
     * @return string
     */
    function countSobreTab() {
        if ($('#mus_EnCorrespondencia_mesmo').length > 0) {
            var warnings = 0;
            var enderecoCorrespondenciaMesmoVisitacao = $('#mus_EnCorrespondencia_mesmo').editable('getValue', true);
            //conta warning para a descrição curta
            $('#sobre > .ficha-spcultura > p').each(function(){
                warnings += $(this).find('.danger').length;
            });

            //conta warnings de email divulgacao, telefone divulgação e endereço
            $('#sobre > .ficha-spcultura > .servico').each(function(){
                warnings += $(this).find('.danger').length;
            });

            //conta erros do endereço de correspondência
            if(enderecoCorrespondenciaMesmoVisitacao === 'não'){
                $('#sobre > .ficha-spcultura > #endereco-correspondencia > .js-endereco-correspondencia > p').each(function(){
                    warnings += $(this).find('.danger').length;
                });
            }

            return warnings;
        }

        return false;
    }
    
    function concatena_enderco(){
        var nome_logradouro = $('#mus_EnCorrespondencia_Nome_Logradouro').editable('getValue', true);
        var cep = $('#mus_EnCorrespondencia_CEP').editable('getValue', true);
        var numero = $('#mus_EnCorrespondencia_Num').editable('getValue', true);
        var complemento = $('#mus_EnCorrespondencia_Complemento').editable('getValue', true);
        var bairro = $('#mus_EnCorrespondencia_Bairro').editable('getValue', true);
        var municipio = $('#mus_EnCorrespondencia_Municipio').editable('getValue', true);
        var estado = $('#mus_EnCorrespondencia_Estado').editable('getValue', true);
        
        if(cep && nome_logradouro && numero && bairro && municipio && estado){
            var endereco =  nome_logradouro + ", " + numero + (complemento ? ", " + complemento : " ") + ", " + bairro + ", " + cep  + ", " + municipio + ", " + estado;
            $('#mus_endereco_correspondencia').editable('setValue', endereco);
        }
    };
    
    $('#mus_EnCorrespondencia_Nome_Logradouro, #mus_EnCorrespondencia_CEP, #mus_EnCorrespondencia_Num, #mus_EnCorrespondencia_Complemento, #mus_EnCorrespondencia_Bairro, #mus_EnCorrespondencia_Municipio, #mus_EnCorrespondencia_Estado, #mus_EnCorrespondencia_Estado').on('hidden', function(e, params) {
        concatena_enderco();
    });

    $('#mus_EnCorrespondencia_CEP').on('hidden', function(e, params){
        var cep = $('#mus_EnCorrespondencia_CEP').editable('getValue', true);
        cep = cep.replace('-','');
        $.getJSON('http://cep.correiocontrol.com.br/'+cep+'.json',function(r){
            $('#mus_EnCorrespondencia_Nome_Logradouro').editable('setValue', r.logradouro);
            $('#mus_EnCorrespondencia_Bairro').editable('setValue', r.bairro);
            $('#mus_EnCorrespondencia_Municipio').editable('setValue', r.localidade);
            $('#mus_EnCorrespondencia_Estado').editable('setValue', r.uf);
            concatena_enderco();
        });
    });
    
    /**
     * Event listeners para copiar o endereço do espaço no endereço de correspondência
     * quando estes coincidem
     */
    $('#mus_EnCorrespondencia_mesmo').bind('DOMNodeInserted', function() {
        var showEnderecoCorrespondencia = $('#mus_EnCorrespondencia_mesmo').editable('getValue', true);

        if(showEnderecoCorrespondencia == 'não'){
            $('.js-endereco-correspondencia').show();
        }else{
            $('.js-endereco-correspondencia').hide();

            $('#En_CEP').bind('DOMNodeInserted', function() {
                var cep = $('#En_CEP').editable('getValue', true);
                $('#mus_EnCorrespondencia_CEP').editable('setValue', cep);
            });

            $('#En_Nome_Logradouro').bind('DOMNodeInserted', function() {
                var logradouro = $('#En_Nome_Logradouro').editable('getValue', true);
                $('#mus_EnCorrespondencia_Nome_Logradouro').editable('setValue', logradouro);
            });

            $('#En_Num').bind('DOMNodeInserted', function() {
                var numero = $('#En_Num').editable('getValue', true);
                $('#mus_EnCorrespondencia_Num').editable('setValue', numero);
            });

            $('#En_Complemento').bind('DOMNodeInserted', function() { 
                var complemento = $('#En_Complemento').editable('getValue', true);
                $('#mus_EnCorrespondencia_Complemento').editable('setValue', complemento);
            });

            $('#En_Bairro').bind('DOMNodeInserted', function() {
                var bairro = $('#En_Bairro').editable('getValue', true);
                $('#mus_EnCorrespondencia_Bairro').editable('setValue', bairro);
            });

            $('#En_Municipio').bind('DOMNodeInserted', function() {
                var municipio = $('#En_Municipio').editable('getValue', true);
                $('#mus_EnCorrespondencia_Municipio').editable('setValue', municipio);
            });

            $('#En_Estado').bind('DOMNodeInserted', function() {
                var estado = $('#En_Estado').editable('getValue', true);
                $('#mus_EnCorrespondencia_Estado').editable('setValue', estado);
            });
        }
    });

    /**
     * Quando carregado a página, essa função certifica-se de que o endereço de correspondência
     * seja preenchido com os mesmos valores do endereço do museu caso a opção de 'mesmo endereço de correspondencia'
     * esteja marcado como 'sim'
     */
    function checkMailAddress() {
        if ($('#mus_EnCorrespondencia_mesmo').length > 0) {

            var showEnderecoCorrespondencia = $('#mus_EnCorrespondencia_mesmo').editable('getValue', true);
            if(showEnderecoCorrespondencia == 'sim'){
                var cep = $('#En_CEP').editable('getValue', true);
                $('#mus_EnCorrespondencia_CEP').editable('setValue', cep);

                var logradouro = $('#En_Nome_Logradouro').editable('getValue', true);
                $('#mus_EnCorrespondencia_Nome_Logradouro').editable('setValue', logradouro);

                var numero = $('#En_Num').editable('getValue', true);
                $('#mus_EnCorrespondencia_Num').editable('setValue', numero);

                var complemento = $('#En_Complemento').editable('getValue', true);
                $('#mus_EnCorrespondencia_Complemento').editable('setValue', complemento);

                var bairro = $('#En_Bairro').editable('getValue', true);
                $('#mus_EnCorrespondencia_Bairro').editable('setValue', bairro);

                var municipio = $('#En_Municipio').editable('getValue', true);
                $('#mus_EnCorrespondencia_Municipio').editable('setValue', municipio);

                var estado = $('#En_Estado').editable('getValue', true);
                $('#mus_EnCorrespondencia_Estado').editable('setValue', estado);
            }
        }
    }

    //bind responsável por preencher o metadata "Acessibilidade" que é obrigatório no core. Qualquer escolhe em acess. física fára
    //com que 'Acessibilidade' seja sim, menos em caso de 'não' 
    function setAcessibilidade(){
        //Há casos em que um museu já pode ter preenchido "acessibilidade física" antes de ser obrigatório e 
        $('#acessibilidade_fisica').bind('DOMNodeInserted', function(){
            var selected_value = $('#acessibilidade_fisica').editable('getValue', true);
            
            var acessibilidade_value;

            if(selected_value === 'Não possui'){
                acessibilidade_value = 'Não';
            }
            else{
                acessibilidade_value = 'Sim';
            }

            $('#acessibilidade').editable('setValue', acessibilidade_value);
        });
    }
    
    setTimeout(setAcessibilidade, 3000);
    setDefaults();
    setWarningsCount();
    checkMailAddress();
});