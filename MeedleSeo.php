<?php
namespace MeedleSeo;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;
use Symfony\Component\Filesystem\Filesystem;
use Thelia\Model\ConfigQuery;
use Symfony\Component\Finder\Finder;

class MeedleSeo extends BaseModule{
	var $file;
    const DOMAIN_NAME = 'meedleseo';
	public function postActivation(ConnectionInterface $con = null){
        $database = new Database($con->getWrappedConnection());
        $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));
    }
	public function getUploadDir(){
        $uploadDir = ConfigQuery::read('images_library_path');

        if ($uploadDir === null) {
            $uploadDir = THELIA_LOCAL_DIR . 'media' . DS . 'images';
        } else {
            $uploadDir = THELIA_ROOT . $uploadDir;
        }

        return $uploadDir . DS . MeedleSeo::DOMAIN_NAME;
    }

    /**
     * @param string $currentVersion
     * @param string $newVersion
     * @param ConnectionInterface $con
     * @author Thomas Arnaud <tarnaud@openstudio.fr>
     */
	public function setFile($file){
		$this->file = $file;
	}
	public function getFile(){
		return $this->file;
	}
    public function update($currentVersion, $newVersion, ConnectionInterface $con = null)
    {
        $uploadDir = $this->getUploadDir();
        $fileSystem = new Filesystem();

        if (!$fileSystem->exists($uploadDir) && $fileSystem->exists(__DIR__ . DS . 'media' . DS . 'meedleseo')) {
            $finder = new Finder();
            $finder->files()->in(__DIR__ . DS . 'media' . DS . 'meedleseo');

            $fileSystem->mkdir($uploadDir);

            /** @var SplFileInfo $file */
            foreach ($finder as $file) {
                copy($file, $uploadDir . DS . $file->getRelativePathname());
            }
            $fileSystem->remove(__DIR__ . DS . 'media');
        }
    }
}