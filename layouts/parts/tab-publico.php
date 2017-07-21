<?php

$show_acessibilidade = $this->isEditable() ||
    $entity->acessibilidade ||
    $entity->acessibilidade_fisica ||
    $entity->mus_acessibilidade_visual;


$show_instalacoes = $this->isEditable() ||
    $entity->mus_instalacoes ||
    $entity->mus_instalacoes_capacidadeAuditorio ||
    $entity->mus_arquivo_possui ||
    $entity->mus_arquivo_acessoPublico ||
    $entity->mus_biblioteca_possui ||
    $entity->mus_biblioteca_acessoPublico;
?>

<div id="tab-publico" class="aba-content new-tab">
    <div class="servico">
        <?php if($this->isEditable() || $entity->mus_status): ?>
        <p>
            <span class="label required">O Museu encontra-se:</span>
            <span class="js-editable" data-edit="mus_status" data-original-title="Status do museu" data-emptytext="Selecione status do museu"><?php echo $entity->mus_status; ?></span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_previsao_abertura_mes || $entity->mus_previsao_abertura_ano): ?>
            <p>
                <span class="label">Em caso de museu fechado, qual a previsão de abertura?</span><br>
                <?php if ($this->isEditable() || $entity->mus_previsao_abertura_mes): ?>
                    <span class="label">Mês:</span>
                    <span class="js-editable" data-edit="mus_previsao_abertura_mes" data-original-title="Previsão de Abertura (Mês)" data-emptytext="Selecione o mês"><?php echo $entity->mus_previsao_abertura_mes; ?></span><br>
                <?php endif; ?>
                <?php if ($this->isEditable() || $entity->mus_previsao_abertura_ano): ?>
                    <span class="label">Ano:</span>
                    <span class="js-editable" data-edit="mus_previsao_abertura_ano" data-original-title="Previsão de Abertura (Ano)" data-emptytext="Selecione o ano"><?php echo $entity->mus_previsao_abertura_ano; ?></span>
                <?php endif; ?>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->horario): ?>
            <p><span class="label required">Horário de funcionamento: </span><span class="js-editable" data-edit="horario" data-original-title="Horário de Funcionamento" data-emptytext="Insira o horário de abertura e fechamento"><?php echo $entity->horario; ?></span></p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_ingresso_cobrado || $entity->mus_ingresso_valor): ?>
        <h5 style="margin-top:0">Entrada</h5>
        <?php endif; ?>
        <?php if($this->isEditable() || $entity->mus_ingresso_cobrado): ?>
            <p>
                <span class="label required">Entrada é cobrada:</span>
                <span class="js-editable" data-edit="mus_ingresso_cobrado" data-original-title="A entrada no museu é cobrada?" data-emptytext="Selecione"><?php echo $entity->mus_ingresso_cobrado; ?></span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_ingresso_valor): ?>
            <p>
                <span class="label">Descrição do valor da entrada:</span>
                <span class="js-editable" data-edit="mus_ingresso_valor" data-original-title="Valor da entrada no museu" data-emptytext="Descreva"><?php echo $this->isEditable() ? $entity->mus_ingresso_valor : nl2br($entity->mus_ingresso_valor); ?></span>
            </p>
        <?php endif; ?>

        <?php if($show_acessibilidade):?>
            <h5>Acessibilidade</h5>
        <?php endif ?>

        <?php if($this->isEditable() || $entity->acessibilidade): ?>
            <p><span class="label required">Acessibilidade: </span><span class="js-editable" data-edit="acessibilidade" data-original-title="Acessibilidade"><?php echo $entity->acessibilidade; ?></span></p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->acessibilidade_fisica): ?>
            <p>
                <span class="label">Acessibilidade física: </span>
                <editable-multiselect entity-property="acessibilidade_fisica" empty-label="Selecione" allow-other="true" box-title="Acessibilidade física:"></editable-multiselect>
            </p>
        <?php endif; ?>
        <?php $this->applyTemplateHook('acessibilidade','after'); ?>

        <?php if($this->isEditable() || $entity->mus_acessibilidade_visual): ?>
        <p>
            <span class="label">Acessibilidade para pessoas com deficiências auditivas e visuais: </span>
            <editable-multiselect entity-property="mus_acessibilidade_visual" empty-label="Selecione" allow-other="true" box-title="Acessibilidade para pessoas com deficiências auditivas e visuais" help-text="O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_atendimentoEstrangeiros): ?>
        <p>
            <span class="label">Atendimento aos turistas estrangeiros:</span>
            <editable-multiselect entity-property="mus_servicos_atendimentoEstrangeiros" empty-label="Selecione" box-title="Atendimento ao turista estrangeiro" help-text="O museu possui recursos para atendimento de turistas estrangeiros, como sinalização, audioguia, folder etc. em outros idiomas?"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($show_instalacoes):?>
            <h5>Instalações</h5>
        <?php endif ?>

        <?php if($this->isEditable() || $entity->mus_instalacoes): ?>
        <p>
            <span class="label">Instalações básicas e serviços oferecidos:</span>
            <editable-multiselect entity-property="mus_instalacoes" empty-label="Selecione" box-title="Assinale as instalações básicas e serviços oferecidos pelo museu" allow-other="true"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_instalacoes_capacidadeAuditorio): ?>
        <p>
            <span class="label">Capacidade do teatro/auditório (assentos):</span>
            <span class="js-editable" data-edit="mus_instalacoes_capacidadeAuditorio" data-original-title="Capacidade do teatro/auditório (assentos)" data-emptytext="Informe">
                <?php echo $entity->mus_instalacoes_capacidadeAuditorio; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_arquivo_possui): ?>
        <p>
            <span class="label required">O museu possui arquivo histórico?</span>
            <span class="js-editable" data-edit="mus_arquivo_possui" data-original-title="O museu possui arquivo histórico?" data-emptytext="Selecione">
                <?php echo $entity->mus_arquivo_possui; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_arquivo_acessoPublico): ?>
        <p>
            <span class="label required">O arquivo tem acesso ao público?</span>
            <span class="js-editable" data-edit="mus_arquivo_acessoPublico" data-original-title="O arquivo tem acesso ao público?" data-emptytext="Selecione">
                <?php echo $entity->mus_arquivo_acessoPublico; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_biblioteca_possui): ?>
        <p>
            <span class="label required">O Museu possui biblioteca?</span>
            <span class="js-editable" data-edit="mus_biblioteca_possui" data-original-title="O Museu possui biblioteca?" data-emptytext="Selecione">
                <?php echo $entity->mus_biblioteca_possui; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_biblioteca_acessoPublico): ?>
        <p>
            <span class="label required">A biblioteca tem acesso ao público?</span>
            <span class="js-editable" data-edit="mus_biblioteca_acessoPublico" data-original-title="A biblioteca tem acesso ao público?" data-emptytext="Selecione">
                <?php echo $entity->mus_biblioteca_acessoPublico; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_visitaGuiada): ?>
        <p>
            <span class="label required">O museu promove visitas guiadas?</span>
            <span class="js-editable" data-edit="mus_servicos_visitaGuiada" data-original-title="O museu promove visitas guiadas?" data-emptytext="Selecione">
                <?php echo $entity->mus_servicos_visitaGuiada; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_visitaGuiada_s): ?>
        <p>
            <span class="label">Em caso positivo, especifique:</span>
            <span class="js-editable" data-edit="mus_servicos_visitaGuiada_s" data-original-title="Em caso positivo, especifique" data-emptytext="Selecione">
                <?php echo $entity->mus_servicos_visitaGuiada_s; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_atividade_pub_especif || $entity->mus_atividade_pub_especif_s): ?>
            <h5>Atividades educativas e culturais</h5>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_atividade_pub_especif): ?>
            <p>
                <span class="label required">O museu realiza atividades educativas e culturais para públicos específicos?</span>
                <span class="js-editable" data-edit="mus_atividade_pub_especif" data-original-title="O museu realiza atividades educativas e culturais para públicos específicos?" data-emptytext="Selecione"><?php echo $entity->mus_atividade_pub_especif; ?></span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_atividade_pub_especif_s): ?>
            <p>
                <span class="label">Em caso positivo, especifique: escolha a(s) que mais se adeque(m)</span>
                <editable-multiselect entity-property="mus_atividade_pub_especif_s" empty-label="Selecione" allow-other="true" box-title="Em caso positivo, especifique: escolha a(s) que mais se adeque(m):"></editable-multiselect>
            </p>
        <?php endif; ?>
    </div>
</div>