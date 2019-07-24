<?php

namespace MeedleSeo\Model\Base;

use \Exception;
use \PDO;
use MeedleSeo\Model\MeedleSeo as ChildMeedleSeo;
use MeedleSeo\Model\MeedleSeoQuery as ChildMeedleSeoQuery;
use MeedleSeo\Model\Map\MeedleSeoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'meedle_seo' table.
 *
 *
 *
 * @method     ChildMeedleSeoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMeedleSeoQuery orderByViewName($order = Criteria::ASC) Order by the view_name column
 * @method     ChildMeedleSeoQuery orderByViewId($order = Criteria::ASC) Order by the view_id column
 * @method     ChildMeedleSeoQuery orderByOgUrl($order = Criteria::ASC) Order by the og_url column
 * @method     ChildMeedleSeoQuery orderByOgTitle($order = Criteria::ASC) Order by the og_title column
 * @method     ChildMeedleSeoQuery orderByOgDescription($order = Criteria::ASC) Order by the og_description column
 * @method     ChildMeedleSeoQuery orderByFile($order = Criteria::ASC) Order by the file column
 * @method     ChildMeedleSeoQuery orderByOgType($order = Criteria::ASC) Order by the og_type column
 * @method     ChildMeedleSeoQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildMeedleSeoQuery orderByNofollow($order = Criteria::ASC) Order by the nofollow column
 *
 * @method     ChildMeedleSeoQuery groupById() Group by the id column
 * @method     ChildMeedleSeoQuery groupByViewName() Group by the view_name column
 * @method     ChildMeedleSeoQuery groupByViewId() Group by the view_id column
 * @method     ChildMeedleSeoQuery groupByOgUrl() Group by the og_url column
 * @method     ChildMeedleSeoQuery groupByOgTitle() Group by the og_title column
 * @method     ChildMeedleSeoQuery groupByOgDescription() Group by the og_description column
 * @method     ChildMeedleSeoQuery groupByFile() Group by the file column
 * @method     ChildMeedleSeoQuery groupByOgType() Group by the og_type column
 * @method     ChildMeedleSeoQuery groupByLocale() Group by the locale column
 * @method     ChildMeedleSeoQuery groupByNofollow() Group by the nofollow column
 *
 * @method     ChildMeedleSeoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMeedleSeoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMeedleSeoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMeedleSeo findOne(ConnectionInterface $con = null) Return the first ChildMeedleSeo matching the query
 * @method     ChildMeedleSeo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMeedleSeo matching the query, or a new ChildMeedleSeo object populated from the query conditions when no match is found
 *
 * @method     ChildMeedleSeo findOneById(int $id) Return the first ChildMeedleSeo filtered by the id column
 * @method     ChildMeedleSeo findOneByViewName(string $view_name) Return the first ChildMeedleSeo filtered by the view_name column
 * @method     ChildMeedleSeo findOneByViewId(int $view_id) Return the first ChildMeedleSeo filtered by the view_id column
 * @method     ChildMeedleSeo findOneByOgUrl(string $og_url) Return the first ChildMeedleSeo filtered by the og_url column
 * @method     ChildMeedleSeo findOneByOgTitle(string $og_title) Return the first ChildMeedleSeo filtered by the og_title column
 * @method     ChildMeedleSeo findOneByOgDescription(string $og_description) Return the first ChildMeedleSeo filtered by the og_description column
 * @method     ChildMeedleSeo findOneByFile(string $file) Return the first ChildMeedleSeo filtered by the file column
 * @method     ChildMeedleSeo findOneByOgType(string $og_type) Return the first ChildMeedleSeo filtered by the og_type column
 * @method     ChildMeedleSeo findOneByLocale(string $locale) Return the first ChildMeedleSeo filtered by the locale column
 * @method     ChildMeedleSeo findOneByNofollow(int $nofollow) Return the first ChildMeedleSeo filtered by the nofollow column
 *
 * @method     array findById(int $id) Return ChildMeedleSeo objects filtered by the id column
 * @method     array findByViewName(string $view_name) Return ChildMeedleSeo objects filtered by the view_name column
 * @method     array findByViewId(int $view_id) Return ChildMeedleSeo objects filtered by the view_id column
 * @method     array findByOgUrl(string $og_url) Return ChildMeedleSeo objects filtered by the og_url column
 * @method     array findByOgTitle(string $og_title) Return ChildMeedleSeo objects filtered by the og_title column
 * @method     array findByOgDescription(string $og_description) Return ChildMeedleSeo objects filtered by the og_description column
 * @method     array findByFile(string $file) Return ChildMeedleSeo objects filtered by the file column
 * @method     array findByOgType(string $og_type) Return ChildMeedleSeo objects filtered by the og_type column
 * @method     array findByLocale(string $locale) Return ChildMeedleSeo objects filtered by the locale column
 * @method     array findByNofollow(int $nofollow) Return ChildMeedleSeo objects filtered by the nofollow column
 *
 */
abstract class MeedleSeoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MeedleSeo\Model\Base\MeedleSeoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MeedleSeo\\Model\\MeedleSeo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMeedleSeoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMeedleSeoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MeedleSeo\Model\MeedleSeoQuery) {
            return $criteria;
        }
        $query = new \MeedleSeo\Model\MeedleSeoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMeedleSeo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MeedleSeoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MeedleSeoTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildMeedleSeo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, VIEW_NAME, VIEW_ID, OG_URL, OG_TITLE, OG_DESCRIPTION, FILE, OG_TYPE, LOCALE, NOFOLLOW FROM meedle_seo WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildMeedleSeo();
            $obj->hydrate($row);
            MeedleSeoTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildMeedleSeo|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MeedleSeoTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MeedleSeoTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MeedleSeoTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MeedleSeoTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the view_name column
     *
     * Example usage:
     * <code>
     * $query->filterByViewName('fooValue');   // WHERE view_name = 'fooValue'
     * $query->filterByViewName('%fooValue%'); // WHERE view_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $viewName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByViewName($viewName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($viewName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $viewName)) {
                $viewName = str_replace('*', '%', $viewName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::VIEW_NAME, $viewName, $comparison);
    }

    /**
     * Filter the query on the view_id column
     *
     * Example usage:
     * <code>
     * $query->filterByViewId(1234); // WHERE view_id = 1234
     * $query->filterByViewId(array(12, 34)); // WHERE view_id IN (12, 34)
     * $query->filterByViewId(array('min' => 12)); // WHERE view_id > 12
     * </code>
     *
     * @param     mixed $viewId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByViewId($viewId = null, $comparison = null)
    {
        if (is_array($viewId)) {
            $useMinMax = false;
            if (isset($viewId['min'])) {
                $this->addUsingAlias(MeedleSeoTableMap::VIEW_ID, $viewId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($viewId['max'])) {
                $this->addUsingAlias(MeedleSeoTableMap::VIEW_ID, $viewId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::VIEW_ID, $viewId, $comparison);
    }

    /**
     * Filter the query on the og_url column
     *
     * Example usage:
     * <code>
     * $query->filterByOgUrl('fooValue');   // WHERE og_url = 'fooValue'
     * $query->filterByOgUrl('%fooValue%'); // WHERE og_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ogUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByOgUrl($ogUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ogUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ogUrl)) {
                $ogUrl = str_replace('*', '%', $ogUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::OG_URL, $ogUrl, $comparison);
    }

    /**
     * Filter the query on the og_title column
     *
     * Example usage:
     * <code>
     * $query->filterByOgTitle('fooValue');   // WHERE og_title = 'fooValue'
     * $query->filterByOgTitle('%fooValue%'); // WHERE og_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ogTitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByOgTitle($ogTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ogTitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ogTitle)) {
                $ogTitle = str_replace('*', '%', $ogTitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::OG_TITLE, $ogTitle, $comparison);
    }

    /**
     * Filter the query on the og_description column
     *
     * Example usage:
     * <code>
     * $query->filterByOgDescription('fooValue');   // WHERE og_description = 'fooValue'
     * $query->filterByOgDescription('%fooValue%'); // WHERE og_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ogDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByOgDescription($ogDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ogDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ogDescription)) {
                $ogDescription = str_replace('*', '%', $ogDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::OG_DESCRIPTION, $ogDescription, $comparison);
    }

    /**
     * Filter the query on the file column
     *
     * Example usage:
     * <code>
     * $query->filterByFile('fooValue');   // WHERE file = 'fooValue'
     * $query->filterByFile('%fooValue%'); // WHERE file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $file The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByFile($file = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($file)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $file)) {
                $file = str_replace('*', '%', $file);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::FILE, $file, $comparison);
    }

    /**
     * Filter the query on the og_type column
     *
     * Example usage:
     * <code>
     * $query->filterByOgType('fooValue');   // WHERE og_type = 'fooValue'
     * $query->filterByOgType('%fooValue%'); // WHERE og_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ogType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByOgType($ogType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ogType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ogType)) {
                $ogType = str_replace('*', '%', $ogType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::OG_TYPE, $ogType, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the nofollow column
     *
     * Example usage:
     * <code>
     * $query->filterByNofollow(1234); // WHERE nofollow = 1234
     * $query->filterByNofollow(array(12, 34)); // WHERE nofollow IN (12, 34)
     * $query->filterByNofollow(array('min' => 12)); // WHERE nofollow > 12
     * </code>
     *
     * @param     mixed $nofollow The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function filterByNofollow($nofollow = null, $comparison = null)
    {
        if (is_array($nofollow)) {
            $useMinMax = false;
            if (isset($nofollow['min'])) {
                $this->addUsingAlias(MeedleSeoTableMap::NOFOLLOW, $nofollow['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nofollow['max'])) {
                $this->addUsingAlias(MeedleSeoTableMap::NOFOLLOW, $nofollow['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeedleSeoTableMap::NOFOLLOW, $nofollow, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMeedleSeo $meedleSeo Object to remove from the list of results
     *
     * @return ChildMeedleSeoQuery The current query, for fluid interface
     */
    public function prune($meedleSeo = null)
    {
        if ($meedleSeo) {
            $this->addUsingAlias(MeedleSeoTableMap::ID, $meedleSeo->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the meedle_seo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MeedleSeoTableMap::clearInstancePool();
            MeedleSeoTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMeedleSeo or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMeedleSeo object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MeedleSeoTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MeedleSeoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MeedleSeoTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MeedleSeoQuery
