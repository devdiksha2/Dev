<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php');

if(!class_exists('plgCommunityMyVideos'))
{
	class plgCommunityMyVideos extends CApplications
	{
		var $name		= 'MyVideos';
		var $_name		= 'myVideos';
		var $_user		= null;

	    function plgCommunityMyVideos(& $subject, $config)
	    {
                        parent::__construct($subject, $config);
                        $this->db = JFactory::getDbo();
			$this->_my		= CFactory::getUser();
	    }

		/**
		 * Ajax function to save a new wall entry
		 *
		 * @param message	A message that is submitted by the user
		 * @param uniqueId	The unique id for this group
		 *
		 **/
		function onProfileDisplay()
		{
			JPlugin::loadLanguage( 'plg_community_myvideos', JPATH_ADMINISTRATOR );
			$mainframe = JFactory::getApplication();

			// Attach CSS
			$document	= JFactory::getDocument();
			// $css		= JURI::base() . 'plugins/community/myvideos/style.css';
			// $document->addStyleSheet($css);
			$user     = CFactory::getRequestUser();
			$userid	= $user->id;
			$this->loadUserParams();

			$def_limit = $this->params->get('count', 10);
			$limit = JRequest::getVar('limit', $def_limit, 'REQUEST');
			$limitstart = JRequest::getVar('limitstart', 0, 'REQUEST');

			$row = $this->getVideos($userid, $limitstart, $limit);
			$total = count($row);

            if($this->params->get('hide_empty', 0) && !$total) return '';

			$caching = $this->params->get('cache', 1);
			if($caching)
			{
				$caching = $mainframe->getCfg('caching');
			}

			$cache = JFactory::getCache('plgCommunityMyVideos');
			$cache->setCaching($caching);
			$callback = array('plgCommunityMyVideos', '_getLatestVideosHTML');
			$count = $this->userparams->get('count', $def_limit );

			$dbg = "<!--DEFLIMIT $def_limit USERPARAMLIMIT $count-->";

			$content = $dbg . $cache->call($callback, $userid, $count, $limitstart, $row, $total);


			return $content;
		}

		static public function _getLatestVideosHTML($userid, $limit, $limitstart, $row, $total)
		{

            $config = CFactory::getConfig();
            $video = JTable::getInstance( 'Video' , 'CTable' );
            $isVideoModal = $config->get('video_mode') == 1;

			ob_start();
			if(!empty($row))
			{
				?>

                    <ul class="joms-list--half clearfix">
    				<?php
    				$i = 1;
    				foreach($row as $data)
    				{
    					if($i > $limit){
    						break;
    					}
    					$i++;
    					$video->load( $data->id );
    					$thumbnail = $video->getThumbnail();

                        if ( $isVideoModal ) {
                            $link = 'javascript:" onclick="joms.api.videoOpen(\'' . $video->id . '\');';
                        } else {
                            $link = plgCommunityMyVideos::buildLink($data->id);
                        }

    				?>
					<li class="joms-list__item">
						<a href="<?php echo $link; ?>">
							<img title="<?php echo CTemplate::escape($video->getTitle());?>" src="<?php echo $thumbnail; ?>"/>
							<span class="joms-video__duration"><?php echo $video->getDurationInHMS()?></span>
						</a>
					</li>
				<?php
				}
				?>
				</ul>

				<?php if($i <= $total) { ?>
                <div class="joms-gap"></div>
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos&task=myvideos&userid='.$userid); ?>">
					<span><?php echo JText::_('PLG_MYVIDEOS_VIEWALL_VIDEOS');?></span>
					<span>(<?php echo $total;?>)</span>
				</a>
				<?php } ?>

			<?php } else { ?>
				<div><?php echo JText::_('PLG_MYVIDEOS_NO_VIDEOS')?></div>
				<?php }	?>
			<?php
			$contents  = ob_get_contents();
			@ob_end_clean();
			$html = $contents;

			return $html;
		}

		public function getVideos($userid, $limitstart, $limit)
		{
			$photoType = PHOTOS_USER_TYPE;

			//privacy settings
			//CFactory::load('libraries', 'privacy');
			$permission	= CPrivacy::getAccessLevel($this->_my->id, $userid);

			//get videos from the user
			//CFactory::load('models', 'videos');
			$model	= CFactory::getModel( 'Videos' );
			$videos = $model->getUserTotalVideos($userid);

			return $videos;
		}

		static public function buildLink($videoId)
		{
			$video	= JTable::getInstance( 'Video' , 'CTable' );
			$video->load( $videoId );

			return $video->getURL();
		}

	}
}
