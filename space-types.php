<?php
/**
 * See https://github.com/Respect/Validation to know how to write validations
 */

$core_space_types = include APPLICATION_PATH.'/conf/space-types.php';

$core_space_types['metadata']['emailPublico'] = array(
    'label' => \MapasCulturais\i::__('Email Público'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O email para divulgação é obrigatório'),
        'v::email()' => \MapasCulturais\i::__('O email informado não é um email válido.')
    )
);
$core_space_types['metadata']['telefonePublico'] = array(
    'label' => \MapasCulturais\i::__('Telefone Público'),
    'type' => 'string',
    'validations' => array(
        'required' => \MapasCulturais\i::__('O telefone para divulgação é obrigatório'),
        'v::allOf(v::regex("#^\(\d{2}\)[ ]?\d{4,5}-\d{4}$#"), v::brPhone())' => \MapasCulturais\i::__('Por favor, informe o telefone público no formato (xx) xxxx-xxxx.')
    )
);
$core_space_types['metadata']['emailPublico'] = array(
    'label' => \MapasCulturais\i::__('Email Público'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O email para divulgação é obrigatório'),
        'v::email()' => \MapasCulturais\i::__('O email informado não é um email válido.')
    )
);
$core_space_types['metadata']['emailPublico'] = array(
    'label' => \MapasCulturais\i::__('Email Público'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O email para divulgação é obrigatório'),
        'v::email()' => \MapasCulturais\i::__('O email informado não é um email válido.')
    )
);
$core_space_types['metadata']['En_CEP'] = array(
    'label' => \MapasCulturais\i::__('CEP'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O CEP é obrigatório')
    )
);
$core_space_types['metadata']['En_Nome_Logradouro'] = array(
    'label' => \MapasCulturais\i::__('Logradouro'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O Logradouro é obrigatório')
    )
);
$core_space_types['metadata']['En_Num'] = array(
    'label' => \MapasCulturais\i::__('Número'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O Número é obrigatório')
    )
);

$core_space_types['metadata']['En_Bairro'] = array(
    'label' => \MapasCulturais\i::__('Bairro'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O Bairro é obrigatório')
    )
);
$core_space_types['metadata']['En_Municipio'] = array(
    'label' => \MapasCulturais\i::__('Município'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O Município é obrigatório')
    )
);
$core_space_types['metadata']['En_Estado'] = array(
    'label' => \MapasCulturais\i::__('Estado'),
    'validations' => array(
        'required' => \MapasCulturais\i::__('O Estado é obrigatório')
    )
);

$core_space_types['metadata']['horario'] = array(
    'label' => \MapasCulturais\i::__('Horário de funcionamento'),
    'type' => 'text',
    'validations' => array(
        'required' => \MapasCulturais\i::__('O horário de funcionamento é obrigatório')
    )
);

$core_space_types['metadata']['acessibilidade_fisica'] = array(
    'label' => \MapasCulturais\i::__('Acessibilidade física'),
    'type' => 'multiselect',
    'allowOther' => true,
    'allowOtherText' => \MapasCulturais\i::__('Outros'),
    'options' => array(
        \MapasCulturais\i::__('Banheiros adaptados'),
        \MapasCulturais\i::__('Rampa de acesso'),
        \MapasCulturais\i::__('Elevador'),
        \MapasCulturais\i::__('Sinalização tátil'),
        
        // vindos do sistema de museus.cultura.gov.br
        \MapasCulturais\i::__('Bebedouro adaptado'),
        \MapasCulturais\i::__('Cadeira de rodas para uso do visitante'),
        \MapasCulturais\i::__('Circuito de visitação adaptado'),
        \MapasCulturais\i::__('Corrimão nas escadas e rampas'),
        \MapasCulturais\i::__('Elevador adaptado'),
        \MapasCulturais\i::__('Rampa de acesso'),
        \MapasCulturais\i::__('Sanitário adaptado'),
        \MapasCulturais\i::__('Telefone público adaptado'),
        \MapasCulturais\i::__('Vaga de estacionamento exclusiva para deficientes'),
        \MapasCulturais\i::__('Vaga de estacionamento exclusiva para idosos')
    ),
);

$core_space_types['metadata']['acessibilidade'] = array(
    'label' => \MapasCulturais\i::__('Acessibilidade'),
    'type' => 'select',
    'options' => array(
        '' => \MapasCulturais\i::__('Não Informado'),
        'Sim' => \MapasCulturais\i::__('Sim'),
        'Não' => \MapasCulturais\i::__('Não')
    ),
    'validations' => array(
        'required' => \MapasCulturais\i::__('Acessibilidade é obrigatório')
    )
);


return $core_space_types;