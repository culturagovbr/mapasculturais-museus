<div class="servico">
    <?php $this->applyTemplateHook('tab-about-service','begin'); ?>

    <?php if($this->isEditable()): ?>
        <p style="display:none" class="privado"><span class="icon icon-private-info"></span>Virtual ou Físico? (se for virtual a localização não é obrigatória)</p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->site): ?>
        <p><span class="label">Site:</span>
        <?php if($this->isEditable()): ?>
            <span class="js-editable" data-edit="site" data-original-title="Site" data-emptytext="Insira a url de seu site"><?php echo $entity->site; ?></span></p>
        <?php else: ?>
            <a class="url" href="<?php echo $entity->site; ?>"><?php echo $entity->site; ?></a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->emailPublico): ?>
    <p><span class="label required">Email para divulgação:</span> <span class="js-editable" data-edit="emailPublico" data-original-title="Email para divulgação" data-emptytext="Insira um email que será exibido publicamente"><?php echo $entity->emailPublico; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable()):?>
        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Email pessoal para contato:</span> <span class="js-editable" data-edit="emailPrivado" data-original-title="Email pessoal para contato" data-emptytext="Insira um email que não será exibido publicamente"><?php echo $entity->emailPrivado; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->telefonePublico): ?>
    <p><span class="label required">Telefone para divulgação:</span> <span class="js-editable js-mask-phone" data-edit="telefonePublico" data-original-title="Telefone para divulgação" data-emptytext="Insira um telefone que será exibido publicamente"><?php echo $entity->telefonePublico; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable()):?>
        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Telefone pessoal para contato 1:</span> <span class="js-editable js-mask-phone" data-edit="telefone1" data-original-title="Telefone pessoal" data-emptytext="Insira um telefone que não será exibido publicamente"><?php echo $entity->telefone1; ?></span></p>
        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Telefone pessoal para contato 2:</span> <span class="js-editable js-mask-phone" data-edit="telefone2" data-original-title="Telefone pessoal" data-emptytext="Insira um telefone que não será exibido publicamente"><?php echo $entity->telefone2; ?></span></p>
    <?php endif; ?>
    <?php $this->applyTemplateHook('tab-about-service','end'); ?>

    <?php if ( $this->isEditable() || $entity->mus_add_info ): ?>
    <p><span class="label">Informações Adicionais de Contato:</span><br>
        <span
            class="js-editable"
            data-edit="mus_add_info"
            data-original-title="Informações adicionais de contato <?php $this->dict('entities: of the Space') ?>"
            data-emptytext="Insira informações adicionais de contato <?php $this->dict('entities: of the space') ?>" ><?php echo $this->isEditable() ? $entity->mus_add_info : nl2br($entity->mus_add_info); ?></span>
    </p>
<?php endif; ?>
</div>