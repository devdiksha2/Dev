<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\Document\Renderer\Html\HeadRenderer;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

// No direct access
defined ('_JEXEC') or die ('restricted access');

$doc = Factory::getDocument();
$params = Factory::getApplication()->getTemplate('true')->params;

//Favicon
if ($favicon = $params->get('favicon'))
{
    $doc->addFavicon( Uri::base(true) . '/' .  $favicon);
}
else
{
    $doc->addFavicon( $this->baseurl . '/templates/' . $this->template . '/images/favicon.ico' );
}

//Logo
if ($logo_image = $params->get('logo_image'))
{
    $logo = Uri::base(true) . '/' .  $logo_image;
}
else
{
    $logo = $this->baseurl . '/templates/' . $this->template . '/images/presets/preset1/logo@2x.png';
}

//Stylesheets
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/bootstrap.min.css' );
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/font-awesome.min.css' );
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/template.css' );

$doc->setTitle($this->error->getCode() . ' - '.$this->title);
$header_contents = '';

if (!class_exists('HeadRenderer'))
{
  $head = JPATH_LIBRARIES . '/joomla/document/html/renderer/head.php';
  
  if (file_exists($head))
  {
    require_once($head);
  }
}

$header_renderer = new HeadRenderer($doc);
$header_contents = $header_renderer->render(null);
	
?>
<!DOCTYPE html>
<html class="error-page" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<?php echo $header_contents; ?>
	</head>
	<body>
		<div class="error-page-inner">
			<div>
				<div class="container">
					<div class="error-page-logo">
						<img class="img-resposive error-logo" src="<?php echo $logo; ?>" />
					</div>
					<h1 class="error-code"><?php echo $this->error->getCode(); ?></h1>
					<p class="error-message"><?php echo $this->error->getMessage(); ?></p>
					<a class="btn btn-primary btn-lg error-button" href="<?php echo $this->baseurl; ?>/" title="<?php echo Text::_('HOME'); ?>"><i class="fa fa-chevron-left"></i> <?php echo Text::_('HELIX_GO_BACK'); ?></a>
					<?php echo $doc->getBuffer('modules', '404', array('style' => 'sp_xhtml')); ?>
				</div>
			</div>
		</div>
	</body>
</html>