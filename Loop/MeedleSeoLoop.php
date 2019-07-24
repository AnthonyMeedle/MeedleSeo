<?php
namespace MeedleSeo\Loop;
use MeedleSeo\Model\MeedleSeoQuery;
use MeedleSeo\Model\MeedleSeoI18nQuery;
use MeedleSeo\Model\MeedleSeoI18n;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\BooleanOrBothType;
use Thelia\Type\EnumListType;
use Thelia\Type\EnumType;
use Thelia\Type\TypeCollection;

class MeedleSeoLoop extends BaseLoop implements PropelSearchLoopInterface{
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntTypeArgument('oi'),
            Argument::createAnyTypeArgument('ot'),
            Argument::createAnyTypeArgument('locale'),
		 	Argument::createIntTypeArgument('width'),
            Argument::createIntTypeArgument('height'),
            Argument::createIntTypeArgument('rotation', 0),
            Argument::createAnyTypeArgument('background_color'),
            Argument::createIntTypeArgument('quality'),
            new Argument(
                'resize_mode',
                new TypeCollection(
                    new EnumType(array('crop', 'borders', 'none'))
                ),
                'none'
            ),
            Argument::createAnyTypeArgument('effects'),
            Argument::createBooleanTypeArgument('allow_zoom', false)
        );
    }
    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = MeedleSeoQuery::create();
        $id = $this->getId();
        if ($id) {
            $search->filterById($id, Criteria::IN);
        }
        $objectId = $this->getOi();
        if ($objectId !== null) {
            $search->filterByViewId($objectId, Criteria::IN);
        }
        $objectType = $this->getOt();
        if ($objectType) {
            $search->filterByViewName($objectType, Criteria::IN);
        }
        $locale = $this->getLocale();
        if ($locale) {
            $search->filterByLocale($locale, Criteria::IN);
        }
        return $search;
    }
    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult){
		$meedleSeo = new \MeedleSeo\MeedleSeo;
        foreach ($loopResult->getResultDataCollection() as $seo) {
            $loopResultRow = new LoopResultRow($seo);
			$iu ='';
			$oiu ='';
			$ip ='';
			$oip ='';
			if($seo->getFile() && is_file($meedleSeo->getUploadDir() . DS . $seo->getFile())){
				$event = new ImageEvent();
				$event->setSourceFilepath($meedleSeo->getUploadDir() . DS . $seo->getFile())->setCacheSubdirectory('meedleseo');		
				switch ($this->getResizeMode()) {
					case 'crop':
						$resize_mode = \Thelia\Action\Image::EXACT_RATIO_WITH_CROP;
					break;
					case 'borders':
						$resize_mode = \Thelia\Action\Image::EXACT_RATIO_WITH_BORDERS;
					break;
					case 'none':
					default:
						$resize_mode = \Thelia\Action\Image::KEEP_IMAGE_RATIO;
				}

				// Prepare tranformations
				$width = $this->getWidth();
				$height = $this->getHeight();
				$rotation = $this->getRotation();
				$background_color = $this->getBackgroundColor();
				$quality = $this->getQuality();
				$effects = $this->getEffects();

				if (!is_null($width)) {
					$event->setWidth($width);
				}
				if (!is_null($height)) {
					$event->setHeight($height);
				}
				$event->setResizeMode($resize_mode);
				if (!is_null($rotation)) {
					$event->setRotation($rotation);
				}
				if (!is_null($background_color)) {
					$event->setBackgroundColor($background_color);
				}
				if (!is_null($quality)) {
					$event->setQuality($quality);
				}
				if (!is_null($effects)) {
					$event->setEffects($effects);
				}

				$event->setAllowZoom($this->getAllowZoom());

				$this->dispatcher->dispatch(TheliaEvents::IMAGE_PROCESS, $event);
                $iu =  $event->getFileUrl();
                $oiu = $event->getOriginalFileUrl();
                $ip = $event->getCacheFilepath();
                $oip = $event->getSourceFilepath();
			}
			if(null === $i18n = MeedleSeoI18nQuery::create()->filterByMeedleSeoId($seo->getId())->findOne()){
				$i18n = new MeedleSeoI18n();
			}
            $loopResultRow
                ->set('ID', $seo->getId())
                ->set('VIEW_TYPE', $seo->getViewName())
                ->set('VIEW_ID', $seo->getViewId())
                ->set('TYPE', $seo->getOgType())
                ->set('TITLE', $seo->getOgTitle())
                ->set('DESCRIPTION', $seo->getOgDescription())
                ->set('LOCALE', $seo->getLocale())
                ->set('NOFOLLOW_CHECKED', $seo->getNofollow() ? 'checked' : '')
                ->set('NOFOLLOW_BALISE', $seo->getNofollow() ? '<meta name="robots" content="noindex,nofollow">' : '')
                ->set('NOFOLLOW', $seo->getNofollow())
                ->set('URL', $seo->getOgUrl())
                ->set('FILE', $seo->getFile())
                ->set("IMAGE_URL", $iu)
                ->set("ORIGINAL_IMAGE_URL", $oiu)
                ->set("IMAGE_PATH", $ip)
                ->set("ORIGINAL_IMAGE_PATH", $oip)
                ->set("PAGE_TITLE", $i18n->getTitle())
                ->set("PAGE_CHAPO", $i18n->getChapo())
                ->set("PAGE_DESCRIPTION", $i18n->getDescription())
                ->set("PAGE_POSTSCRIPTUM", $i18n->getPostscriptum())
                ->set("META_TITLE", $i18n->getMetaTitle())
                ->set("META_DESCRIPTION", $i18n->getMetaDescription())
                ->set("META_KEYWORD", $i18n->getMetaKeywords())
            ;
            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }
}