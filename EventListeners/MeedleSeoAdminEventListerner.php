<?php
namespace MeedleSeo\EventListeners;

use MeedleSeo\Model\MeedleSeoQuery;
use MeedleSeo\Model\MeedleSeo;
use Thelia\Core\Event\TheliaEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Model\ConfigQuery;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\Category\CategoryUpdateEvent;
use Thelia\Core\Event\Folder\FolderUpdateEvent;
use Thelia\Core\Event\Content\ContentUpdateEvent;
use Thelia\Core\Event\UpdateSeoEvent;
use Thelia\Controller\Admin\FileController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Thelia\Files\Exception\ProcessFileException;

use Thelia\Core\Event\File\FileCreateOrUpdateEvent;

class MeedleSeoAdminEventListerner implements EventSubscriberInterface
{
    protected $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
	public function seoUpdate(UpdateSeoEvent $event, $objectType='', EventDispatcherInterface $dispatcher){
		if(null === $meedleSeo = MeedleSeoQuery::create()->filterByViewName($objectType)->filterByViewId($event->getObjectId())->filterByLocale($event->getLocale())->findOne()){
			$meedleSeo=new MeedleSeo();
		}
		
   		
		$meedleSeo
			->setViewName($objectType)
			->setLocale($event->getLocale())
			->setOgUrl($event->getUrl())
			->setViewId($event->getObjectId())
			->setNofollow($this->request->get('seo_nofollow'))
			->setOgTitle($this->request->get('meta_og_title'))
			->setOgDescription($this->request->get('meedleseo_og_description'))
			->setOgType($this->request->get('meta_og_type'))
			->save();
		$file = $meedleSeo->getFile();
		if($this->request->get('meedle_seo_supp_img')){
			$meedleSeo->setFile('')->save();
			unlink(__DIR__.'/../../../media/images/meedleseo/' . $file);
		}
			
	 	$fileBeingUploaded = $this->request->files->get('meta_og_image', null, true);
		if($fileBeingUploaded){
			if($file) unlink(__DIR__.'/../../../media/images/meedleseo/' . $file);
			$namefile = $this->processFile($fileBeingUploaded, $meedleSeo->getId(), 'meedleseo', 'image', array(),['exe'=>'exe','pdf'=>'pdf']);
			$meedleSeo->setFile($namefile)->save();
		}
		$urlsite = ConfigQuery::read('url_site');
		$url = $urlsite . '/'. $event->getUrl();
		$url = str_replace('//', '/', $url);
		$prevenir = 'https://developers.facebook.com/tools/debug/sharing/?url=' . $url;
		
		 // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, $prevenir);
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);      
		
	}
	public function updateCategorySeo(UpdateSeoEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
		$this->seoUpdate($event, 'category', $dispatcher);
    }
	public function updateProductSeo(UpdateSeoEvent $event, $eventName, EventDispatcherInterface $dispatcher){
		$this->seoUpdate($event, 'product', $dispatcher);
	}
	public function updateFolderSeo(UpdateSeoEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
		$this->seoUpdate($event, 'folder', $dispatcher);
    }
    public function updateContentSeo(UpdateSeoEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
		$this->seoUpdate($event, 'content', $dispatcher);
    }	
	
	public function processFile(
        $fileBeingUploaded,
        $parentId,
        $parentType,
        $objectType,
        $validMimeTypes = array(),
        $extBlackList = array()
    ) {

        // Validate if file is too big
        if ($fileBeingUploaded->getError() == 1) {
            $message = 'File is too large, please retry with a file having a size less than '. ini_get('upload_max_filesize') .'.';
            throw new ProcessFileException($message, 403);
        }

        $message = null;
        $realFileName = $fileBeingUploaded->getClientOriginalName();
		$mimeType = $fileBeingUploaded->getMimeType();
        if (! empty($validMimeTypes)) {
            
            if (!isset($validMimeTypes[$mimeType])) {
                $message = 'Only files having the following mime type are allowed: ' . implode(', ', array_keys($validMimeTypes));
            } else {
                $regex = "#^(.+)\.(".implode("|", $validMimeTypes[$mimeType]).")$#i";

                if (!preg_match($regex, $realFileName)) {
                    $message = 'There\'s a conflict between your file extension "'. $mimeType .'" and the mime type "'. $fileBeingUploaded->getClientOriginalExtension() .'"';
                }
            }
        }

        if (!empty($extBlackList)) {
            $regex = "#^(.+)\.(".implode("|", $extBlackList).")$#i";

            if (preg_match($regex, $realFileName)) {
                $message = 'Files with the following extension are not allowed: '. $fileBeingUploaded->getClientOriginalExtension() .', please do an archive of the file if you want to upload it';
            }
        }

        if ($message !== null) {
            throw new ProcessFileException($message, 415);
        }
//		$fichier = $parentId.'_'.$realFileName;
		$realFileName = $this->ereg_caracspec($realFileName);
		$fichier = $this->ereg_caracspec($parentId.'_'.$realFileName);
		$up = new UploadedFile($fileBeingUploaded, $realFileName, $mimeType);
		$up->move(__DIR__.'/../../../media/images/meedleseo/', $fichier);
		
        return $fichier;
    }
	
	public function ereg_caracspec($chaine){
		$chaine = trim($chaine);
		if(function_exists('mb_strtolower'))
			$chaine = mb_strtolower($chaine);
		else
			$chaine = strtolower($chaine);
		$chaine = $this->supprAccent($chaine);
		
		$chaine = str_replace(
			array(':', ';', ',', '°'),
			array('-', '-', '-', '-'),
			$chaine
		 );
		$chaine = str_replace(" ", "-", $chaine);
		$chaine = str_replace("(", "", $chaine);
		$chaine = str_replace(")", "", $chaine);
		$chaine = str_replace(" ", "-", $chaine);
		$chaine = str_replace("'", "-", $chaine);
		$chaine = str_replace("&nbsp;", "-", $chaine);
		$chaine = str_replace("\"", "-", $chaine);
		$chaine = str_replace("?", "", $chaine);
		$chaine = str_replace("*", "-", $chaine);
		$chaine = str_replace("!", "", $chaine);
		$chaine = str_replace("+", "-", $chaine);
		$chaine = str_replace("ß", "ss", $chaine);
		$chaine = str_replace("%", "", $chaine);
		$chaine = str_replace("²", "2", $chaine);
		$chaine = str_replace("³", "3", $chaine);
		$chaine = str_replace("œ", "oe", $chaine);
		$chaine = str_replace(chr(128), "", $chaine);
		$chaine = str_replace(chr(226), "", $chaine);
		$chaine = str_replace(chr(146), "-", $chaine);
		$chaine = str_replace(chr(150), "-", $chaine);
		$chaine = str_replace(chr(151), "-", $chaine);
		$chaine = str_replace(chr(153), "", $chaine);
		$chaine = str_replace(chr(169), "", $chaine);
		$chaine = str_replace(chr(174), "", $chaine);
		$chaine = str_replace("&", "et", $chaine);
		$chaine = str_replace("?", "", $chaine);
		$chaine = str_replace("é", "e", $chaine);
		return $chaine;
	}

	public function supprAccent($texte) {
	   $texte = str_replace(    array(
									'à', 'â', 'ä', 'á', 'ã', 'å',
									'î', 'ï', 'ì', 'í',
									'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
									'ù', 'û', 'ü', 'ú',
									'é', 'è', 'ê', 'ë',
									'ç', 'ÿ', 'ñ', 'ý'
								),
								array(
									'a', 'a', 'a', 'a', 'a', 'a',
									'i', 'i', 'i', 'i',
									'o', 'o', 'o', 'o', 'o', 'o',
									'u', 'u', 'u', 'u',
									'e', 'e', 'e', 'e',
									'c', 'y', 'n', 'y'
								),
								$texte
					);
		$texte = str_replace(    array(
									'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
									'Î', 'Ï', 'Ì', 'Í',
									'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø',
									'Ù', 'Û', 'Ü', 'Ú',
									'É', 'È', 'Ê', 'Ë',
									'Ç', 'Ÿ', 'Ñ', 'Ý',
								),
								array(
									'A', 'A', 'A', 'A', 'A', 'A',
									'I', 'I', 'I', 'I',
									'O', 'O', 'O', 'O', 'O', 'O',
									'U', 'U', 'U', 'U',
									'E', 'E', 'E', 'E',
									'C', 'Y', 'N', 'Y',
								),
								$texte
							);
		return $texte;
	}
	
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::PRODUCT_UPDATE_SEO => ['updateProductSeo', 128],
            TheliaEvents::CATEGORY_UPDATE_SEO   => ['updateCategorySeo', 128],
            TheliaEvents::FOLDER_UPDATE_SEO   => ['updateFolderSeo', 128],
            TheliaEvents::CONTENT_UPDATE_SEO   => ['updateContentSeo', 128]
        ];
    }

}