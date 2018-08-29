<center>
    <div id="registro-main-impressao">
        <div style="width:100%;text-align:center;"><img src="<?php $this->asset('img/registromuseus.gif')?>" style="width: 250px;text-align:center;"></div>
        <h3>Formulário de Solicitação de Registro</h3>
        <h5>Sobre</h5>
        <table class='table-registromuseus'>
            <?php
                echo "<tr><td><b>Nome do Museu:</b>" . $entity->name . "</td></tr>";

                foreach ($metasOrdem['sobre'] as $metaOrdem) {
                    if(is_array($metaOrdem)){
                        echo "<tr><td>";
                        $widthDiv = 100 / count($metaOrdem);
                        foreach ($metaOrdem as $value) {
                            echo "<div class='divTd' style='width:$widthDiv%;'><b>" . \MapasCulturais\i::__($metasSpace[$value]->label) . ": </b> " . $metas[$value] . "</div>";
                        }
                        echo "</td></tr>";
                        continue;
                    }

                    echo "<tr><td><b>" . \MapasCulturais\i::__($metasSpace[$metaOrdem]->label) . ": </b> " . $metas[$metaOrdem] . "</td></tr>";
                }
            ?>
        </table>

        <h5>Gestão</h5>
        <table class='table-registromuseus'>
            <?php
                foreach ($metasOrdem['gestao'] as $metaOrdem) {
                    if(is_array($metaOrdem)){
                        echo "<tr><td>";
                        $widthDiv = 100 / count($metaOrdem);
                        foreach ($metaOrdem as $value) {
                            echo "<div class='divTd' style='width:$widthDiv%;'><b>" . \MapasCulturais\i::__($metasSpace[$value]->label) . ": </b> " . $metas[$value] . "</div>";
                        }
                        echo "</td></tr>";
                        continue;
                    }

                    echo "<tr><td><b>" . \MapasCulturais\i::__($metasSpace[$metaOrdem]->label) . ": </b> " . $metas[$metaOrdem] . "</td></tr>";
                }
            ?>
        </table>

        <h5>Caracterização</h5>
        <table class='table-registromuseus'>
            <?php
                foreach ($metasOrdem['caracterizacao'] as $metaOrdem) {
                    if(is_array($metaOrdem)){
                        echo "<tr><td>";
                        $widthDiv = 100 / count($metaOrdem);
                        foreach ($metaOrdem as $value) {
                            echo "<div class='divTd' style='width:$widthDiv%;'><b>" . \MapasCulturais\i::__($metasSpace[$value]->label) . ": </b> " . $metas[$value] . "</div>";
                        }
                        echo "</td></tr>";
                        continue;
                    }

                    echo "<tr><td><b>" . \MapasCulturais\i::__($metasSpace[$metaOrdem]->label) . ": </b> " . $metas[$metaOrdem] . "</td></tr>";
                }
            ?>
        </table>

        <h5>Acervo</h5>
        <table class='table-registromuseus'>
            <?php
                foreach ($metasOrdem['acervo'] as $metaOrdem) {
                    if(is_array($metaOrdem)){
                        echo "<tr><td>";
                        $widthDiv = 100 / count($metaOrdem);
                        foreach ($metaOrdem as $value) {
                            echo "<div class='divTd' style='width:$widthDiv%;'><b>" . \MapasCulturais\i::__($metasSpace[$value]->label) . ": </b> " . $metas[$value] . "</div>";
                        }
                        echo "</td></tr>";
                        continue;
                    }

                    echo "<tr><td><b>" . \MapasCulturais\i::__(($metaOrdem == 'tipologia') ? 'Tipologia' : $metasSpace[$metaOrdem]->label) . ": </b> " . $metas[$metaOrdem] . "</td></tr>";
                }
            ?>
        </table>
        <?php echo $html; ?>
        <p style="page-break-before:always"></p>

        <div style="width:100%;text-align:center;"><img src="<?php $this->asset('img/registromuseus.gif')?>" style="width: 250px;text-align:center;margin-bottom: 50px;"></div>

        <div style="line-height: 2;">
            Eu, ______________________________________________, portador do RG _________________, expedido em ______________, pelo órgão _________________, inscrito no CPF sob o nº ________________, residente e domiciliado em ________________________________________________________, no município de _________________________________, estado de _______, declaro para fins da Política Nacional de Museus que sou responsável legal pelo Museu ______________________________________________________________, situado à ___________________________________________________________, no município de _______________________________________________, no estado de _________, e que tenho ciência do Estatuto de Museus, instituído pela Lei nº 11.904, de 14 de janeiro de 2009, e de seu respectivo Decreto regulamentador, nº 8.124, de 17 de outrubro de 2013, e das demais normas federais referentes à Legislação Museológica.
            Por ser verdade as informações prestadas, solicito o Registro do referido Museu e comprometo-me a manter as informações desta instiuição requerente, atualizadas junto à entidade registradora de origem.

            <div style="text-align:center;margin-top: 60px;">
                <p>
                    ________________________________________________<br>
                    (Assinatura do solicitante)
                </p>
                <p>
                    ________________________________________________<br>
                    (Nome completo do solicitante)
                </p>
                <p>
                    Local _____________________ - _____, ____ de ________________, de 201__
                </p>
            </div>
        </div>
    </div>
</center>