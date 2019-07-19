<?php
/**
 * Created by PhpStorm.
 * User: dugour
 * Date: 29/10/14
 * Time: 15:20
 */

namespace MeedleSeo\Controller\Admin;

use MeedleSeo\Model\MeedleSeoQuery;
use MeedleSeo\Model\MeedleSeo;
use MeedleSeo\Model\MeedleSeoI18nQuery;
use MeedleSeo\Model\MeedleSeoI18n;
use Thelia\Model\LangQuery;
use Thelia\Log\Tlog;
use Thelia\Core\Event\ActionEvent;
use Thelia\Controller\Admin\BaseAdminController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MeedleSeoAdminController extends BaseAdminController
{
    public function __construct()
    {
    }
	public function noAction(){}
	
	
	
	public function updateAction(){
	//	print_r($_REQUEST);
		
		$codeLocale='fr_FR';
		if(null !== $lang = LangQuery::create()->filterById($_REQUEST['lang'])->findOne()){
			$codeLocale = $lang->getLocale();
		}
		if(null === $seo = MeedleSeoQuery::create()->filterByViewName($_REQUEST['view_name'])->filterByViewId($_REQUEST['view_id'])->filterByLocale($codeLocale)->findOne()){
			$seo = new MeedleSeo();
		}
		$seo->setViewName($_REQUEST['view_name'])
			->setViewId($_REQUEST['view_id'])
			->setLocale($codeLocale)
			->setOgUrl('')
			->setViewId($_REQUEST['view_id'])
			->setOgTitle($_REQUEST['meta_og_title'])
			->setOgDescription($_REQUEST['meedleseo_og_description'])
			->setOgType($_REQUEST['meta_og_type'])	
			->save();
		
		if(null === $seoI18n = MeedleSeoI18nQuery::create()->filterByMeedleSeoId($seo->getId())->findOne()){
			$seoI18n = new MeedleSeoI18n();
		}
		$seoI18n->setMeedleSeoId($seo->getId())
			->setTitle($_REQUEST['title'])
			->setMetaTitle($_REQUEST['meta_title'])
			->setDescription($_REQUEST['description'])
			->setMetaDescription($_REQUEST['meta_description'])
			->setChapo($_REQUEST['chapo'])	
			->setPostscriptum($_REQUEST['postscriptum'])	
			->setMetaKeywords($_REQUEST['meta_keywords'])
			->save();

		$file = $seo->getFile();
		if(isset($_REQUEST['meedle_seo_supp_img']) && $_REQUEST['meedle_seo_supp_img']){
			$seo->setFile('')->save();
			unlink(__DIR__.'/../../../../media/images/meedleseo/' . $file);
		}

			$fileBeingUploaded = $this->getRequest()->files->get('meta_og_image', null, true);
			if($fileBeingUploaded){
				if($file) unlink(__DIR__.'/../../../../media/images/meedleseo/' . $file);
				$namefile = $this->processFile($fileBeingUploaded, $seo->getId(), 'meedleseo', 'image', array(), ['exe'=>'exe','pdf'=>'pdf']);
				$seo->setFile($namefile)->save();
			}

		
		
		return $this->generateRedirect($_REQUEST['success_url']); 

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
		$fichier = $this->ereg_caracspec($parentId.'_'.$realFileName);
		$up = new UploadedFile($fileBeingUploaded, $realFileName, $mimeType);
		$retour = $up->move(__DIR__.'/../../../../media/images/meedleseo/', $fichier);
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
}