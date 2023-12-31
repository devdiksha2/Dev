<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="blog-featured<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="http://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading') != 0): ?>
    <div class="page-header">
        <h1>
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h1>
    </div>
    <?php endif;?>

    <?php $leadingcount = 0;?>
    <?php if (!empty($this->lead_items)): ?>
    <div class="items-leading clearfix">
        <?php foreach ($this->lead_items as &$item): ?>
        <article
            class="item leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> clearfix"
            itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
            <?php
$this->item =  &$item;
echo $this->loadTemplate('item');
?>
        </article>
        <?php
$leadingcount++;
?>
        <?php endforeach;?>
    </div>
    <?php endif;?>

    <?php
$introcount = count($this->intro_items);
$counter = 0;
$this->columns = $this->columns ?? 1;
?>

    <?php if (!empty($this->intro_items)): ?>
    <div class="article-list">
        <?php foreach ($this->intro_items as $key => &$item): ?>
        <?php
$key = ($key - $leadingcount) + 1;
$rowcount = (((int) $key - 1) % (int) $this->columns) + 1;
$row = $counter / $this->columns;

if ($rowcount === 1): ?>
        <div class="row items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?> row">
            <?php endif;?>

            <div class="col-lg-<?php echo round(12 / $this->columns); ?> item column-<?php echo $rowcount; ?>">
                <div class="article" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <?php
$this->item =  &$item;
echo $this->loadTemplate('item');
?>
                </div>
            </div>

            <?php $counter++;?>
            <?php if (($rowcount == $this->columns) or ($counter == $introcount)): ?>
        </div>
        <?php endif;?>
        <?php endforeach;?>
    </div>
    <?php endif;?>



    <?php if ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)): ?>
    <div class="pagination">

        <?php if ($this->params->def('show_pagination_results', 1)): ?>
        <p class="counter pull-right">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php endif;?>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
    <?php endif;?>

</div>