<?php

namespace MeedleSeo\Model\Map;

use MeedleSeo\Model\MeedleSeo;
use MeedleSeo\Model\MeedleSeoQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'meedle_seo' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MeedleSeoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MeedleSeo.Model.Map.MeedleSeoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'meedle_seo';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MeedleSeo\\Model\\MeedleSeo';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MeedleSeo.Model.MeedleSeo';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the ID field
     */
    const ID = 'meedle_seo.ID';

    /**
     * the column name for the VIEW_NAME field
     */
    const VIEW_NAME = 'meedle_seo.VIEW_NAME';

    /**
     * the column name for the VIEW_ID field
     */
    const VIEW_ID = 'meedle_seo.VIEW_ID';

    /**
     * the column name for the OG_URL field
     */
    const OG_URL = 'meedle_seo.OG_URL';

    /**
     * the column name for the OG_TITLE field
     */
    const OG_TITLE = 'meedle_seo.OG_TITLE';

    /**
     * the column name for the OG_DESCRIPTION field
     */
    const OG_DESCRIPTION = 'meedle_seo.OG_DESCRIPTION';

    /**
     * the column name for the FILE field
     */
    const FILE = 'meedle_seo.FILE';

    /**
     * the column name for the OG_TYPE field
     */
    const OG_TYPE = 'meedle_seo.OG_TYPE';

    /**
     * the column name for the LOCALE field
     */
    const LOCALE = 'meedle_seo.LOCALE';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ViewName', 'ViewId', 'OgUrl', 'OgTitle', 'OgDescription', 'File', 'OgType', 'Locale', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'viewName', 'viewId', 'ogUrl', 'ogTitle', 'ogDescription', 'file', 'ogType', 'locale', ),
        self::TYPE_COLNAME       => array(MeedleSeoTableMap::ID, MeedleSeoTableMap::VIEW_NAME, MeedleSeoTableMap::VIEW_ID, MeedleSeoTableMap::OG_URL, MeedleSeoTableMap::OG_TITLE, MeedleSeoTableMap::OG_DESCRIPTION, MeedleSeoTableMap::FILE, MeedleSeoTableMap::OG_TYPE, MeedleSeoTableMap::LOCALE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'VIEW_NAME', 'VIEW_ID', 'OG_URL', 'OG_TITLE', 'OG_DESCRIPTION', 'FILE', 'OG_TYPE', 'LOCALE', ),
        self::TYPE_FIELDNAME     => array('id', 'view_name', 'view_id', 'og_url', 'og_title', 'og_description', 'file', 'og_type', 'locale', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ViewName' => 1, 'ViewId' => 2, 'OgUrl' => 3, 'OgTitle' => 4, 'OgDescription' => 5, 'File' => 6, 'OgType' => 7, 'Locale' => 8, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'viewName' => 1, 'viewId' => 2, 'ogUrl' => 3, 'ogTitle' => 4, 'ogDescription' => 5, 'file' => 6, 'ogType' => 7, 'locale' => 8, ),
        self::TYPE_COLNAME       => array(MeedleSeoTableMap::ID => 0, MeedleSeoTableMap::VIEW_NAME => 1, MeedleSeoTableMap::VIEW_ID => 2, MeedleSeoTableMap::OG_URL => 3, MeedleSeoTableMap::OG_TITLE => 4, MeedleSeoTableMap::OG_DESCRIPTION => 5, MeedleSeoTableMap::FILE => 6, MeedleSeoTableMap::OG_TYPE => 7, MeedleSeoTableMap::LOCALE => 8, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'VIEW_NAME' => 1, 'VIEW_ID' => 2, 'OG_URL' => 3, 'OG_TITLE' => 4, 'OG_DESCRIPTION' => 5, 'FILE' => 6, 'OG_TYPE' => 7, 'LOCALE' => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'view_name' => 1, 'view_id' => 2, 'og_url' => 3, 'og_title' => 4, 'og_description' => 5, 'file' => 6, 'og_type' => 7, 'locale' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('meedle_seo');
        $this->setPhpName('MeedleSeo');
        $this->setClassName('\\MeedleSeo\\Model\\MeedleSeo');
        $this->setPackage('MeedleSeo.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('VIEW_NAME', 'ViewName', 'VARCHAR', false, 30, null);
        $this->addColumn('VIEW_ID', 'ViewId', 'INTEGER', true, null, 0);
        $this->addColumn('OG_URL', 'OgUrl', 'VARCHAR', false, 255, null);
        $this->addColumn('OG_TITLE', 'OgTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('OG_DESCRIPTION', 'OgDescription', 'VARCHAR', false, 255, null);
        $this->addColumn('FILE', 'File', 'VARCHAR', false, 100, null);
        $this->addColumn('OG_TYPE', 'OgType', 'VARCHAR', false, 100, null);
        $this->addColumn('LOCALE', 'Locale', 'VARCHAR', false, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? MeedleSeoTableMap::CLASS_DEFAULT : MeedleSeoTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (MeedleSeo object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MeedleSeoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MeedleSeoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MeedleSeoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MeedleSeoTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MeedleSeoTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = MeedleSeoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MeedleSeoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MeedleSeoTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(MeedleSeoTableMap::ID);
            $criteria->addSelectColumn(MeedleSeoTableMap::VIEW_NAME);
            $criteria->addSelectColumn(MeedleSeoTableMap::VIEW_ID);
            $criteria->addSelectColumn(MeedleSeoTableMap::OG_URL);
            $criteria->addSelectColumn(MeedleSeoTableMap::OG_TITLE);
            $criteria->addSelectColumn(MeedleSeoTableMap::OG_DESCRIPTION);
            $criteria->addSelectColumn(MeedleSeoTableMap::FILE);
            $criteria->addSelectColumn(MeedleSeoTableMap::OG_TYPE);
            $criteria->addSelectColumn(MeedleSeoTableMap::LOCALE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.VIEW_NAME');
            $criteria->addSelectColumn($alias . '.VIEW_ID');
            $criteria->addSelectColumn($alias . '.OG_URL');
            $criteria->addSelectColumn($alias . '.OG_TITLE');
            $criteria->addSelectColumn($alias . '.OG_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.FILE');
            $criteria->addSelectColumn($alias . '.OG_TYPE');
            $criteria->addSelectColumn($alias . '.LOCALE');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(MeedleSeoTableMap::DATABASE_NAME)->getTable(MeedleSeoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(MeedleSeoTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(MeedleSeoTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new MeedleSeoTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a MeedleSeo or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or MeedleSeo object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MeedleSeo\Model\MeedleSeo) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MeedleSeoTableMap::DATABASE_NAME);
            $criteria->add(MeedleSeoTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = MeedleSeoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { MeedleSeoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { MeedleSeoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the meedle_seo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MeedleSeoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MeedleSeo or Criteria object.
     *
     * @param mixed               $criteria Criteria or MeedleSeo object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MeedleSeo object
        }

        if ($criteria->containsKey(MeedleSeoTableMap::ID) && $criteria->keyContainsValue(MeedleSeoTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MeedleSeoTableMap::ID.')');
        }


        // Set the correct dbName
        $query = MeedleSeoQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // MeedleSeoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MeedleSeoTableMap::buildTableMap();
