<?php

$show_acervo = $this->isEditable() ||
        $entity->mus_acervo_material_emExpoicao ||
        $entity->mus_acervo_nucleoEdificado;

$show_gestao = $this->isEditable();

$show_tipologia = $this->isEditable() ||
        $entity->mus_tipo ||
        $entity->mus_tipo_tematica;

?>
<div id="tab-mais" class="aba-content new-tab">
    
    <div class="servico">
        <?php if($this->isEditable() || $entity->esfera): ?>
            <p class="esfera">
                <span class="label required">Esfera: </span>
                <span class="js-editable" data-edit="esfera" data-original-title="Esfera"><?php echo $entity->esfera; ?></span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->esfera_tipo): ?>
            <p class="esfera"><span class="label required">Tipo de Esfera: </span><span class="js-editable" data-edit="esfera_tipo" data-original-title="Tipo de Esfera"><?php echo $entity->esfera_tipo; ?></span></p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_esfera_tipo_federal): ?>
            <p>
                <span class="label">Em caso de Museu federal, especifique vinculação ministerial:</span> <?php if ($this->isEditable()){ ?><em>Somente para Esfera Federal</em><br><?php } ?><span class="js-editable" data-edit="mus_esfera_tipo_federal" data-original-title="Em caso de Museu federal, especifique vinculação ministerial"><?php echo $entity->mus_esfera_tipo_federal; ?></span>
            </p>
        <?php endif; ?>


        <?php if($this->isEditable() || $entity->certificado): ?>
            <p class="esfera"><span class="label">Títulos e Certificados: </span><span class="js-editable" data-edit="certificado" data-original-title="Títulos e Certificados"><?php echo $entity->certificado; ?></span></p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
            <p class="privado"><span class="icon icon-private-info"></span><span class="label">CNPJ: </span><span class="js-editable" data-edit="cnpj" data-original-title="CNPJ"><?php echo $entity->cnpj; ?></span></p>
        <?php endif; ?>
    </div>
    <div class="servico">

        <?php if($this->isEditable() || $entity->mus_abertura_ano): ?>
        <p>
            <span class="label required">Ano de abertura:</span>
            <span class="js-editable" data-edit="mus_abertura_ano" data-original-title="Ano de abertura" data-emptytext="Informe">
                <?php echo $entity->mus_abertura_ano; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_instumentoCriacao_tipo || $entity->mus_instumentoCriacao_descricao): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Instrumento de criação:</span>
            <?php if($this->isEditable() || $entity->mus_instumentoCriacao_tipo): ?>
                <editable-singleselect entity-property="mus_instumentoCriacao_tipo" empty-label="Selecione" allow-other="true" box-title="O museu possui instrumento de criação?"></editable-singleselect>
            <?php endif; ?>
        </p>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Descrição:</span>
            <?php if($this->isEditable() || $entity->mus_instumentoCriacao_descricao): ?>
                <span
                    class="js-editable" data-edit="mus_instumentoCriacao_descricao"
                    data-original-title="Descrição do instrumento de criação" data-emptytext="Informe uma descrição"
                    >
                    <?php echo $entity->mus_instumentoCriacao_descricao; ?>
                </span>
                <em>somente para instrumento do tipo "Outros"</em>
            <?php endif; ?>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_instituicaoMantenedora): ?>
        <p>
            <span class="label">Instituição mantenedora:</span>
            <span class="js-editable" data-edit="mus_instituicaoMantenedora" data-original-title="Instituição mantenedora" data-emptytext="Informe">
                <?php echo $entity->mus_instituicaoMantenedora; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">O museu possui algum contrato para sua gestão?</span>
                <span class="js-editable" data-edit="mus_contrato_gestao" data-original-title="O museu possui algum contrato para sua gestão?" data-emptytext="Selecione">
                    <?php echo $entity->mus_contrato_gestao; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Em caso positivo especifique a estrutura jurídica da instituição contratada</span>
                <span class="js-editable" data-edit="mus_contrato_gestao_s" data-original-title="Em caso positivo especifique a estrutura jurídica da instituição contratada" data-emptytext="Selecione">
                    <?php echo $entity->mus_contrato_gestao_s; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">A contratada possui qualificações?</span>
                <span class="js-editable" data-edit="mus_contrato_qualificacoes" data-original-title="A contratada possui qualificações?" data-emptytext="Selecione">
                    <?php echo $entity->mus_contrato_qualificacoes; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Quantas pessoas trabalham no museu (contabilizar terceirizados, estagiários e voluntários)?</span>
                <span class="js-editable" data-edit="mus_num_pessoas" data-original-title="Quantas pessoas trabalham no museu (contabilizar terceirizados, estagiários e voluntários)?" data-emptytext="Informe">
                    <?php echo $entity->mus_num_pessoas; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">O museu possui funcionários terceirizados?</span>
                <span class="js-editable" data-edit="mus_func_tercerizado" data-original-title="O museu possui funcionários terceirizados?" data-emptytext="Selecione">
                    <?php echo $entity->mus_func_tercerizado; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Em caso positivo, especifique quantos</span>
                <span class="js-editable" data-edit="mus_func_tercerizado_s" data-original-title="Em caso positivo, especifique quantos" data-emptytext="Informe">
                    <?php echo $entity->mus_func_tercerizado_s; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">O museu possui voluntários?</span>
                <span class="js-editable" data-edit="mus_func_voluntario" data-original-title="O museu possui voluntários?" data-emptytext="Selecione">
                    <?php echo $entity->mus_func_voluntario; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">O museu possui estagiários?</span>
                <span class="js-editable" data-edit="mus_func_estagiario" data-original-title="O museu possui estagiários?" data-emptytext="Selecione">
                    <?php echo $entity->mus_func_estagiario; ?>
                </span>
            </p>

            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Posui regimento interno?</span>
                <span class="js-editable" data-edit="mus_gestao_regimentoInterno" data-original-title="O museu posui regimento interno?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_regimentoInterno; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label required">Possui plano museológico?</span>
                <span class="js-editable" data-edit="mus_gestao_planoMuseologico" data-original-title="O museu possui plano museológico?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_planoMuseologico; ?>
                </span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_tipo): ?>
            <p>
                <span class="label required">Tipo:</span>
                <span class="js-editable" data-edit="mus_tipo" data-original-title="Tipo do museu" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo; ?>
                </span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">O museu é itinerante:</span>
            <span class="js-editable" data-edit="mus_itinerante" data-original-title="O museu é itinerante?" data-emptytext="Selecione">
                <?php echo $entity->mus_itinerante; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_caraterComunitario): ?>
        <p>
            <span class="label">O museu é de caráter comunitário?</span>
            <span class="js-editable" data-edit="mus_caraterComunitario" data-original-title="O museu é de caráter comunitário?" data-emptytext="Selecione">
                <?php echo $entity->mus_caraterComunitario; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Em caso de museus comunitários, a comunidade realiza atividades museológicas?</span>
            <span class="js-editable" data-edit="mus_comunidadeRealizaAtividades" data-original-title="Em caso de museus comunitários, a comunidade realiza atividades museológicas?" data-emptytext="Selecione">
                <?php echo $entity->mus_comunidadeRealizaAtividades; ?>
            </span>
        </p>

        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Informe o número total de bens culturais de caráter museológico que compõem o acervo:</span>
            <span>Não contabilizar bens culturais cujo processamento técnico é de caráter bibliográfico ou arquivístico.</span>
            <span class="js-editable" data-edit="mus_total_bens_culturais" data-original-title="Informe o número total de bens culturais de caráter museológico que compõem o acervo:" data-emptytext="Informe">
                <?php echo $entity->mus_total_bens_culturais; ?>
            </span>
        </p>

        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">O número informado é:</span>
            <span class="js-editable" data-edit="mus_exatidao_total_bens_culturais" data-original-title="O número informado é:" data-emptytext="Informe">
                <?php echo $entity->mus_exatidao_total_bens_culturais; ?>
            </span>
        </p>
        
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Propriedade:</span>
            <span class="js-editable" data-edit="mus_acervo_propriedade" data-original-title="Propriedade do acervo" data-emptytext="Selecione">
                <?php echo $entity->mus_acervo_propriedade; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_tipo_tematica): ?>
        <p>
            <span class="label required">Temática:</span>
            <span class="js-editable" data-edit="mus_tipo_tematica" data-original-title="Temática do museu" data-emptytext="Selecione">
                <?php echo $entity->mus_tipo_tematica; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Indique os instrumentos de documentação de acervo utilizados pelo Museu</span>
                <editable-multiselect entity-property="mus_instr_documento" empty-label="Selecione" allow-other="true" box-title="Indique os instrumentos de documentação de acervo utilizados pelo Museu:"></editable-multiselect>
            </p>

            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Caso o Museu não realize nenhuma ação de documentação de seu acervo, justifique</span>
                <span class="js-editable" data-edit="mus_instr_documento_n" data-original-title="Caso o Museu não realize nenhuma ação de documentação de seu acervo, justifique" data-emptytext="Informe">
                    <?php echo $entity->mus_instr_documento_n; ?>
                </span>
            </p>

            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">O museu possui política de aquisição de acervo?</span>
                <span class="js-editable" data-edit="mus_gestao_politicaAquisicao" data-original-title="O museu possui política de aquisição de acervo?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_politicaAquisicao; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                        <span class="label">Possui política de descarte de acervo?</span>
                <span class="js-editable" data-edit="mus_gestao_politicaDescarte" data-original-title="O museu possui política de descarte de acervo?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_politicaDescarte; ?>
                </span>
            </p>
            <p style="margin-top:1em"><em>somente para o tipo "Unidade de conservação da natureza"</em></p>
        <?php endif; ?>


        <?php if($this->isEditable() || $entity->mus_tipo_tematica === 'Unidade de conservação da natureza' || $entity->mus_tipo_unidadeConservacao): ?>
            <p>
                <span class="label">Tipo/categoria de manejo da Unidade de Conservação:</span>
                <span class="js-editable" data-edit="mus_tipo_unidadeConservacao" data-original-title="Tipo/categoria de manejo da Unidade de Conservação" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo_unidadeConservacao; ?>
                </span>
            </p>
            <?php endif; ?>

            <?php if($this->isEditable() || $entity->mus_tipo_unidadeConservacao_protecaoIntegral): ?>
            <p>
                <span class="label">Tipo de unidade de proteção integral:</span>
                <span class="js-editable" data-edit="mus_tipo_unidadeConservacao_protecaoIntegral" data-original-title="Tipo de unidade de proteção integral" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo_unidadeConservacao_protecaoIntegral; ?>
                </span>
            </p>
            <?php endif; ?>

            <?php if($this->isEditable() || $entity->mus_tipo_unidadeConservacao_usoSustentavel): ?>
            <p>
                <span class="label">Tipo de unidade de uso sustentável:</span>
                <span class="js-editable" data-edit="mus_tipo_unidadeConservacao_usoSustentavel" data-original-title="Tipo de unidade de uso sustentável" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo_unidadeConservacao_usoSustentavel; ?>
                </span>
            </p>

        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_material || $entity->mus_acervo_material_emExpoicao): ?>
            <h5>Somente para museus virtuais</h5>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_material): ?>
            <p>
                <span class="label">Possui acervo material:</span>
                <span class="js-editable" data-edit="mus_acervo_material" data-original-title="O museu possui acervo material?" data-emptytext="Selecione">
                    <?php echo $entity->mus_acervo_material; ?>
                </span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_material_emExpoicao): ?>
            <p>
                <span class="label">O acervo material encontra-se em exposição:</span>
                <span class="js-editable" data-edit="mus_acervo_material_emExposicao" data-original-title="O acervo material encontra-se em exposição?" data-emptytext="Selecione">
                    <?php echo $entity->mus_acervo_material_emExposicao; ?>
                </span>
            </p>
        <?php endif; ?>

    </div>
</div>