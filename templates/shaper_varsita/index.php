<?php
/**
 * @package Helix3 Framework
 * Template Name - Shaper Varsita
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

// No direct access
defined ('_JEXEC') or die ('restricted access');

$doc = Factory::getDocument();
$app = Factory::getApplication();
$menu = $app->getMenu()->getActive();

// Load Helix
$helix3_path = JPATH_PLUGINS.'/system/helix3/core/helix3.php';

if (file_exists($helix3_path))
{
    require_once($helix3_path);
    $this->helix3 = helix3::getInstance();
}
else
{
    die('Please install and activate helix plugin');
}

//Coming Soon
if ($this->helix3->getParam('comingsoon_mode'))
{
	header("Location: " . Route::_(Uri::root(true) . "/index.php?tmpl=comingsoon", false));
	exit();
}

//Class Classes
$body_classes = '';

if ($this->helix3->getParam('sticky_header'))
{
    $body_classes .= ' sticky-header';
}

$body_classes .= ($this->helix3->getParam('boxed_layout', 0)) ? ' layout-boxed' : ' layout-fluid';

if (isset($menu) && $menu)
{
    if ($menu->getParams()->get('pageclass_sfx'))
	{
		$body_classes .= ' ' . $menu->getParams()->get('pageclass_sfx');
	}
}

//Body Background Image
if($bg_image = $this->helix3->getParam('body_bg_image')) {

    $body_style  = 'background-image: url(' . Uri::base(true ) . '/' . $bg_image . ');';
    $body_style .= 'background-repeat: '. $this->helix3->getParam('body_bg_repeat') .';';
    $body_style .= 'background-size: '. $this->helix3->getParam('body_bg_size') .';';
    $body_style .= 'background-attachment: '. $this->helix3->getParam('body_bg_attachment') .';';
    $body_style .= 'background-position: '. $this->helix3->getParam('body_bg_position') .';';
    $body_style  = 'body.site {' . $body_style . '}'; 

    $doc->addStyledeclaration( $body_style );
}

//Custom CSS
if ($custom_css = $this->helix3->getParam('custom_css'))
{
    $doc->addStyledeclaration( $custom_css );
}

//Custom JS
if ($custom_js = $this->helix3->getParam('custom_js'))
{
    $doc->addScriptdeclaration( $custom_js );
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if($favicon = $this->helix3->getParam('favicon')) {
        $doc->addFavicon( Uri::base(true) . '/' .  $favicon);
    } else {
        $doc->addFavicon( $this->helix3->getTemplateUri() . '/images/favicon.ico' );
    }
    ?>

    <jdoc:include type="head" />
   
    <?php

    $this->helix3->addCSS('bootstrap.min.css, font-awesome.min.css, joomla-fontawesome.min.css') // CSS Files
        ->addJS('bootstrap.min.js, smoothscroll.js, main.js') // JS Files
        ->lessInit()->setLessVariables(array(
            'preset'=>$this->helix3->Preset(),
            'bg_color'=> $this->helix3->PresetParam('_bg'),
            'text_color'=> $this->helix3->PresetParam('_text'),
            'major_color'=> $this->helix3->PresetParam('_major')
            ))
        ->addLess('legacy/bootstrap', 'legacy')
        ->addLess('master', 'template');

        //RTL
        if($this->direction=='rtl') {
            $this->helix3->addCSS('bootstrap-rtl.min.css')
            ->addLess('rtl', 'rtl');
        }

        $this->helix3->addLess('presets',  'presets/'.$this->helix3->Preset(), array('class'=>'preset'));
        
        //Before Head
        if($before_head = $this->helix3->getParam('before_head')) {
            echo $before_head . "\n";
        }
    ?>
</head>
<body class="<?php echo $this->helix3->bodyClass( $body_classes ); ?>">
    <div class="body-innerwrapper">
        <?php $this->helix3->generatelayout(); ?>

        <div class="offcanvas-menu">
            <a href="#" class="close-offcanvas"><i class="fa fa-remove"></i></a>
            <div class="offcanvas-inner">
                <?php if ($this->helix3->countModules('offcanvas')) { ?>
                    <jdoc:include type="modules" name="offcanvas" style="sp_xhtml" />
                <?php } else { ?>
                    <p class="alert alert-warning"><?php echo Text::_('HELIX_NO_MODULE_OFFCANVAS'); ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    
    if($this->params->get('compress_css')) {
        $this->helix3->compressCSS();
    }

    if($this->params->get('compress_js')) {
        $this->helix3->compressJS( $this->params->get('exclude_js') );
    }

    if($before_body = $this->helix3->getParam('before_body')) {
        echo $before_body . "\n";
    }

    ?>
    <jdoc:include type="modules" name="debug" />
</body>
</html>