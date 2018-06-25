<?php
$site_name = $this->dict('site: name', false);
$title = isset($entity) ? $this->getTitle($entity) : $this->getTitle()
?>
<!DOCTYPE html>
<html lang="pt-BR" dir="ltr">
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $title == $site_name ? $title : "{$site_name} - {$title}"; ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="shortcut icon" href="<?php $this->asset('img/favicon.ico') ?>" />
        <?php $this->head(isset($entity) ? $entity : null); ?>
        <!--[if lt IE 9]>
        <script src="<?php $this->asset('js/html5.js'); ?>" type="text/javascript"></script>
        <![endif]-->
    </head>

    <body <?php $this->bodyProperties() ?> >
        <div id="blockdiv" style="background-color: rgba(0,0,0,0.6);width: 100%;height: 100%;position: fixed;z-index: 1800;top: 0;display: none;"></div>
       <?php $this->bodyBegin(); ?>
        <header id="main-header" class="clearfix"  ng-class="{'sombra':data.global.viewMode !== 'list'}">
            <?php $this->part('header-logo') ?>

            <a href="http://renim.museus.gov.br/registro-de-museus/" class="btn btn-danger register-museum">Registre aqui o seu museu <span class="icon icon-space"></span></a>

            <?php $this->part('header-about-nav') ?>
            <?php $this->part('header-main-nav') ?>
        </header>
        <section id="main-section" class="clearfix">
            <?php if ($this->isEditable()): ?>
                <div id="ajax-response-errors" class="js-dialog" title="Corrija os erros abaixo e tente novamente.">
                    <div class="js-dialog-content"></div>
                </div>
            <?php endif; ?>
