<?php if($this->isEditable() || ($entity->mus_EnCorrespondencia_mesmo && $entity->mus_EnCorrespondencia_mesmo == 'não')): ?>
    <div id="endereco-correspondencia" class="infos">
        <?php if($this->isEditable()): ?>
        <p>
            <span class="label">O endereço de correspondência é o mesmo de visitação?</span>
            <span id="mus_EnCorrespondencia_mesmo" class="js-editable" data-edit="mus_EnCorrespondencia_mesmo" data-original-title="O endereço de correspondência é o mesmo de visitação?" data-emptytext="Selecione">
                <?php echo $entity->mus_EnCorrespondencia_mesmo; ?>
            </span>
        </p>
        <?php endif; ?>
        
        <div class="js-endereco-correspondencia">
            <?php if($this->isEditable()): ?>
                <p><strong>Informe abaixo o endereço de correspondência:</strong></p>
                <input type="hidden" class="js-editable" id="mus_endereco_correspondencia" data-edit="mus_endereco_correspondencia" data-original-title="Endereço de correspondência" data-emptytext="Insira o endereço de correspondência" data-showButtons="bottom" value="<?php echo $entity->endereco ?>" data-value="<?php echo $entity->endereco ?>">
                <p><span class="label required">CEP:</span> <span class="js-editable js-mask-cep" id="mus_EnCorrespondencia_CEP" data-edit="mus_EnCorrespondencia_CEP" data-original-title="CEP" data-emptytext="Insira o CEP" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_CEP ?></span></p>
                <p><span class="label required">Logradouro:</span> <span class="js-editable" id="mus_EnCorrespondencia_Nome_Logradouro" data-edit="mus_EnCorrespondencia_Nome_Logradouro" data-original-title="Logradouro" data-emptytext="Insira o logradouro" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_Nome_Logradouro ?></span></p>
                <p><span class="label required">Número:</span> <span class="js-editable" id="mus_EnCorrespondencia_Num" data-edit="mus_EnCorrespondencia_Num" data-original-title="Número" data-emptytext="Insira o Número" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_Num ?></span></p>
                <p><span class="label required">Complemento:</span> <span class="js-editable" id="mus_EnCorrespondencia_Complemento" data-edit="mus_EnCorrespondencia_Complemento" data-original-title="Complemento" data-emptytext="Insira um complemento" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_Complemento ?></span></p>
                <?php if($this->isEditable() || $entity->mus_EnCorrespondencia_CaixaPostal): ?>
                    <p><span class="label">Caixa Postal:</span> <span class="js-editable" id="mus_EnCorrespondencia_CaixaPostal" data-edit="mus_EnCorrespondencia_CaixaPostal" data-original-title="Caixa Postal" data-emptytext="Se houver, informe a caixa postal" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_CaixaPostal ?></span></p>
                <?php endif; ?>
                <p><span class="label required">Bairro:</span> <span class="js-editable" id="mus_EnCorrespondencia_Bairro" data-edit="mus_EnCorrespondencia_Bairro" data-original-title="Bairro" data-emptytext="Insira o Bairro" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_Bairro ?></span></p>
                <p><span class="label required">Município:</span> <span class="js-editable" id="mus_EnCorrespondencia_Municipio" data-edit="mus_EnCorrespondencia_Municipio" data-original-title="Município" data-emptytext="Insira o Município" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_Municipio ?></span></p>
                <p><span class="label required">Estado:</span> <span class="js-editable" id="mus_EnCorrespondencia_Estado" data-edit="mus_EnCorrespondencia_Estado" data-original-title="Estado" data-emptytext="Insira o Estado" data-showButtons="bottom"><?php echo $entity->mus_EnCorrespondencia_Estado ?></span></p>

            <?php else: ?>
                <p><strong>Endereço de correspondência:</strong></p>
                <p class="endereco"><span class="js-endereco"><?php echo $entity->endereco ?></span></p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>