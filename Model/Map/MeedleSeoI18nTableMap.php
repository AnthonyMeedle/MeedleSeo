<?php

namespace MeedleSeo\Model\Map;

use MeedleSeo\Model\MeedleSeoI18n;
use MeedleSeo\Model\MeedleSeoI18nQuery;
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
 * This class defines the structure of the 'meedle_seo_i18n' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MeedleSeoI18nTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MeedleSeo.Model.Map.MeedleSeoI18nTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'meedle_seo_i18n';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MeedleSeo\\Model\\MeedleSeoI18n';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MeedleSeo.Model.MeedleSeoI18n';

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
    const ID = 'meedle_seo_i18n.ID';

    /**
     * the column name for the MEEDLE_SEO_ID field
     */
    const MEEDLE_SEO_ID = 'meedle_seo_i18n.MEEDLE_SEO_ID';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'meedle_seo_i18n.TITLE';

    /**
     * the column name for the DESCRIPTION field
     */
    const DESCRIPTION = 'meedle_seo_i18n.DESCRIPTION';

    /**
     * the column name for the CHAPO field
     */
    const CHAPO = 'meedle_seo_i18n.CHAPO';

    /**
     * the column name for the POSTSCRIPTUM field
     */
    const POSTSCRIPTUM = 'meedle_seo_i18n.POSTSCRIPTUM';

    /**
     * the column name for the META_TITLE field
     */
    const META_TITLE = 'meedle_seo_i18n.META_TITLE';

    /**
     * the column name for the META_DESCRIPTION field
     */
    const META_DESCRIPTION = 'meedle_seo_i18n.META_DESCRIPTION';

    /**
     * the column name for the META_KEYWORDS field
     */
    const META_KEYWORDS = 'meedle_seo_i18n.META_KEYWORDS';

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
        self::TYPE_PHPNAME       => array('Id', 'MeedleSeoId', 'Title', 'Description', 'Chapo', 'Postscriptum', 'MetaTitle', 'MetaDescription', 'MetaKeywords', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'meedleSeoId', 'title', 'description', 'chapo', 'postscriptum', 'metaTitle', 'metaDescription', 'metaKeywords', ),
        self::TYPE_COLNAME       => array(MeedleSeoI18nTableMap::ID, MeedleSeoI18nTableMap::MEEDLE_SEO_ID, MeedleSeoI18nTableMap::TITLE, MeedleSeoI18nTableMap::DESCRIPTION, MeedleSeoI18nTableMap::CHAPO, MeedleSeoI18nTableMap::POSTSCRIPTUM, MeedleSeoI18nTableMap::META_TITLE, MeedleSeoI18nTableMap::META_DESCRIPTION, MeedleSeoI18nTableMap::META_KEYWORDS, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'MEEDLE_SEO_ID', 'TITLE', 'DESCRIPTION', 'CHAPO', 'POSTSCRIPTUM', 'META_TITLE', 'META_DESCRIPTION', 'META_KEYWORDS', ),
        self::TYPE_FIELDNAME     => array('id', 'meedle_seo_id', 'title', 'description', 'chapo', 'postscriptum', 'meta_title', 'meta_description', 'meta_keywords', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'MeedleSeoId' => 1, 'Title' => 2, 'Description' => 3, 'Chapo' => 4, 'Postscriptum' => 5, 'MetaTitle' => 6, 'MetaDescription' => 7, 'MetaKeywords' => 8, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'meedleSeoId' => 1, 'title' => 2, 'description' => 3, 'chapo' => 4, 'postscriptum' => 5, 'metaTitle' => 6, 'metaDescription' => 7, 'metaKeywords' => 8, ),
        self::TYPE_COLNAME       => array(MeedleSeoI18nTableMap::ID => 0, MeedleSeoI18nTableMap::MEEDLE_SEO_ID => 1, MeedleSeoI18nTableMap::TITLE => 2, MeedleSeoI18nTableMap::DESCRIPTION => 3, MeedleSeoI18nTableMap::CHAPO => 4, MeedleSeoI18nTableMap::POSTSCRIPTUM => 5, MeedleSeoI18nTableMap::META_TITLE => 6, MeedleSeoI18nTableMap::META_DESCRIPTION => 7, MeedleSeoI18nTableMap::META_KEYWORDS => 8, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'MEEDLE_SEO_ID' => 1, 'TITLE' => 2, 'DESCRIPTION' => 3, 'CHAPO' => 4, 'POSTSCRIPTUM' => 5, 'META_TITLE' => 6, 'META_DESCRIPTION' => 7, 'META_KEYWORDS' => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'meedle_seo_id' => 1, 'title' => 2, 'description' => 3, 'chapo' => 4, 'postscriptum' => 5, 'meta_title' => 6, 'meta_description' => 7, 'meta_keywords' => 8, ),
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
        $this->setName('meedle_seo_i18n');
        $this->setPhpName('MeedleSeoI18n');
        $this->setClassName('\\MeedleSeo\\Model\\MeedleSeoI18n');
        $this->setPackage('MeedleSeo.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('MEEDLE_SEO_ID', 'MeedleSeoId', 'INTEGER', true, null, 0);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', false, 255, null);
        $this->addColumn('DESCRIPTION', 'Description', 'CLOB', false, null, null);
        $this->addColumn('CHAPO', 'Chapo', 'LONGVARCHAR', false, null, null);
        $this->addColumn('POSTSCRIPTUM', 'Postscriptum', 'LONGVARCHAR', false, null, null);
        $this->addColumn('META_TITLE', 'MetaTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('META_DESCRIPTION', 'MetaDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('META_KEYWORDS', 'MetaKeywords', 'LONGVARCHAR', false, null, null);
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
        return $withPrefix ? MeedleSeoI18nTableMap::CLASS_DEFAULT : MeedleSeoI18nTableMap::OM_CLASS;
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
     * @return array (MeedleSeoI18n object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MeedleSeoI18nTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MeedleSeoI18nTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MeedleSeoI18nTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MeedleSeoI18nTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MeedleSeoI18nTableMap::addInstanceToPool($obj, $key);
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
            $key = MeedleSeoI18nTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MeedleSeoI18nTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MeedleSeoI18nTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::ID);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::MEEDLE_SEO_ID);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::TITLE);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::DESCRIPTION);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::CHAPO);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::POSTSCRIPTUM);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::META_TITLE);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::META_DESCRIPTION);
            $criteria->addSelectColumn(MeedleSeoI18nTableMap::META_KEYWORDS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.MEEDLE_SEO_ID');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.DESCRIPTION');
            $criteria->addSelectColumn($alias . '.CHAPO');
            $criteria->addSelectColumn($alias . '.POSTSCRIPTUM');
            $criteria->addSelectColumn($alias . '.META_TITLE');
            $criteria->addSelectColumn($alias . '.META_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.META_KEYWORDS');
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
        return Propel::getServiceContainer()->getDatabaseMap(MeedleSeoI18nTableMap::DATABASE_NAME)->getTable(MeedleSeoI18nTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(MeedleSeoI18nTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(MeedleSeoI18nTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new MeedleSeoI18nTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a MeedleSeoI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or MeedleSeoI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoI18nTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MeedleSeo\Model\MeedleSeoI18n) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MeedleSeoI18nTableMap::DATABASE_NAME);
            $criteria->add(MeedleSeoI18nTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = MeedleSeoI18nQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { MeedleSeoI18nTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { MeedleSeoI18nTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the meedle_seo_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MeedleSeoI18nQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MeedleSeoI18n or Criteria object.
     *
     * @param mixed               $criteria Criteria or MeedleSeoI18n object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoI18nTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MeedleSeoI18n object
        }

        if ($criteria->containsKey(MeedleSeoI18nTableMap::ID) && $criteria->keyContainsValue(MeedleSeoI18nTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MeedleSeoI18nTableMap::ID.')');
        }


        // Set the correct dbName
        $query = MeedleSeoI18nQuery::create()->mergeWith($criteria);

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

} // MeedleSeoI18nTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MeedleSeoI18nTableMap::buildTableMap();
