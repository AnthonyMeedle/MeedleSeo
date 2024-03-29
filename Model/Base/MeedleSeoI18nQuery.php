<?php

namespace MeedleSeo\Model\Base;

use \Exception;
use \PDO;
use MeedleSeo\Model\MeedleSeoI18n as ChildMeedleSeoI18n;
use MeedleSeo\Model\MeedleSeoI18nQuery as ChildMeedleSeoI18nQuery;
use MeedleSeo\Model\Map\MeedleSeoI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'meedle_seo_i18n' table.
 *
 *
 *
 * @method     ChildMeedleSeoI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMeedleSeoI18nQuery orderByMeedleSeoId($order = Criteria::ASC) Order by the meedle_seo_id column
 * @method     ChildMeedleSeoI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildMeedleSeoI18nQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildMeedleSeoI18nQuery orderByChapo($order = Criteria::ASC) Order by the chapo column
 * @method     ChildMeedleSeoI18nQuery orderByPostscriptum($order = Criteria::ASC) Order by the postscriptum column
 * @method     ChildMeedleSeoI18nQuery orderByMetaTitle($order = Criteria::ASC) Order by the meta_title column
 * @method     ChildMeedleSeoI18nQuery orderByMetaDescription($order = Criteria::ASC) Order by the meta_description column
 * @method     ChildMeedleSeoI18nQuery orderByMetaKeywords($order = Criteria::ASC) Order by the meta_keywords column
 *
 * @method     ChildMeedleSeoI18nQuery groupById() Group by the id column
 * @method     ChildMeedleSeoI18nQuery groupByMeedleSeoId() Group by the meedle_seo_id column
 * @method     ChildMeedleSeoI18nQuery groupByTitle() Group by the title column
 * @method     ChildMeedleSeoI18nQuery groupByDescription() Group by the description column
 * @method     ChildMeedleSeoI18nQuery groupByChapo() Group by the chapo column
 * @method     ChildMeedleSeoI18nQuery groupByPostscriptum() Group by the postscriptum column
 * @method     ChildMeedleSeoI18nQuery groupByMetaTitle() Group by the meta_title column
 * @method     ChildMeedleSeoI18nQuery groupByMetaDescription() Group by the meta_description column
 * @method     ChildMeedleSeoI18nQuery groupByMetaKeywords() Group by the meta_keywords column
 *
 * @method     ChildMeedleSeoI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMeedleSeoI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMeedleSeoI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMeedleSeoI18n findOne(ConnectionInterface $con = null) Return the first ChildMeedleSeoI18n matching the query
 * @method     ChildMeedleSeoI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMeedleSeoI18n matching the query, or a new ChildMeedleSeoI18n object populated from the query conditions when no match is found
 *
 * @method     ChildMeedleSeoI18n findOneById(int $id) Return the first ChildMeedleSeoI18n filtered by the id column
 * @method     ChildMeedleSeoI18n findOneByMeedleSeoId(int $meedle_seo_id) Return the first ChildMeedleSeoI18n filtered by the meedle_seo_id column
 * @method     ChildMeedleSeoI18n findOneByTitle(string $title) Return the first ChildMeedleSeoI18n filtered by the title column
 * @method     ChildMeedleSeoI18n findOneByDescription(string $description) Return the first ChildMeedleSeoI18n filtered by the description column
 * @method     ChildMeedleSeoI18n findOneByChapo(string $chapo) Return the first ChildMeedleSeoI18n filtered by the chapo column
 * @method     ChildMeedleSeoI18n findOneByPostscriptum(string $postscriptum) Return the first ChildMeedleSeoI18n filtered by the postscriptum column
 * @method     ChildMeedleSeoI18n findOneByMetaTitle(string $meta_title) Return the first ChildMeedleSeoI18n filtered by the meta_title column
 * @method     ChildMeedleSeoI18n findOneByMetaDescription(string $meta_description) Return the first ChildMeedleSeoI18n filtered by the meta_description column
 * @method     ChildMeedleSeoI18n findOneByMetaKeywords(string $meta_keywords) Return the first ChildMeedleSeoI18n filtered by the meta_keywords column
 *
 * @method     array findById(int $id) Return ChildMeedleSeoI18n objects filtered by the id column
 * @method     array findByMeedleSeoId(int $meedle_seo_id) Return ChildMeedleSeoI18n objects filtered by the meedle_seo_id column
 * @method     array findByTitle(string $title) Return ChildMeedleSeoI18n objects filtered by the title column
 * @method     array findByDescription(string $description) Return ChildMeedleSeoI18n objects filtered by the description column
 * @method     array findByChapo(string $chapo) Return ChildMeedleSeoI18n objects filtered by the chapo column
 * @method     array findByPostscriptum(string $postscriptum) Return ChildMeedleSeoI18n objects filtered by the postscriptum column
 * @method     array findByMetaTitle(string $meta_title) Return ChildMeedleSeoI18n objects filtered by the meta_title column
 * @method     array findByMetaDescription(string $meta_description) Return ChildMeedleSeoI18n objects filtered by the meta_description column
 * @method     array findByMetaKeywords(string $meta_keywords) Return ChildMeedleSeoI18n objects filtered by the meta_keywords column
 *
 */
abstract class MeedleSeoI18nQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MeedleSeo\Model\Base\MeedleSeoI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MeedleSeo\\Model\\MeedleSeoI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMeedleSeoI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMeedleSeoI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MeedleSeo\Model\MeedleSeoI18nQuery) {
            return $criteria;
        }
        $query = new \MeedleSeo\Model\MeedleSeoI18nQuery();
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
     * @return ChildMeedleSeoI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MeedleSeoI18nTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MeedleSeoI18nTableMap::DATABASE_NAME);
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
     * @return   ChildMeedleSeoI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, MEEDLE_SEO_ID, TITLE, DESCRIPTION, CHAPO, POSTSCRIPTUM, META_TITLE, META_DESCRIPTION, META_KEYWORDS FROM meedle_seo_i18n WHERE ID = :p0';
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
            $obj = new ChildMeedleSeoI18n();
            $obj->hydrate($row);
            MeedleSeoI18nTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMeedleSeoI18n|array|mixed the result, formatted by the current formatter
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
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MeedleSeoI18nTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MeedleSeoI18nTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MeedleSeoI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MeedleSeoI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the meedle_seo_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMeedleSeoId(1234); // WHERE meedle_seo_id = 1234
     * $query->filterByMeedleSeoId(array(12, 34)); // WHERE meedle_seo_id IN (12, 34)
     * $query->filterByMeedleSeoId(array('min' => 12)); // WHERE meedle_seo_id > 12
     * </code>
     *
     * @param     mixed $meedleSeoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMeedleSeoId($meedleSeoId = null, $comparison = null)
    {
        if (is_array($meedleSeoId)) {
            $useMinMax = false;
            if (isset($meedleSeoId['min'])) {
                $this->addUsingAlias(MeedleSeoI18nTableMap::MEEDLE_SEO_ID, $meedleSeoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($meedleSeoId['max'])) {
                $this->addUsingAlias(MeedleSeoI18nTableMap::MEEDLE_SEO_ID, $meedleSeoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::MEEDLE_SEO_ID, $meedleSeoId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the chapo column
     *
     * Example usage:
     * <code>
     * $query->filterByChapo('fooValue');   // WHERE chapo = 'fooValue'
     * $query->filterByChapo('%fooValue%'); // WHERE chapo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $chapo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByChapo($chapo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($chapo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $chapo)) {
                $chapo = str_replace('*', '%', $chapo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::CHAPO, $chapo, $comparison);
    }

    /**
     * Filter the query on the postscriptum column
     *
     * Example usage:
     * <code>
     * $query->filterByPostscriptum('fooValue');   // WHERE postscriptum = 'fooValue'
     * $query->filterByPostscriptum('%fooValue%'); // WHERE postscriptum LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postscriptum The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByPostscriptum($postscriptum = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postscriptum)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $postscriptum)) {
                $postscriptum = str_replace('*', '%', $postscriptum);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::POSTSCRIPTUM, $postscriptum, $comparison);
    }

    /**
     * Filter the query on the meta_title column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaTitle('fooValue');   // WHERE meta_title = 'fooValue'
     * $query->filterByMetaTitle('%fooValue%'); // WHERE meta_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaTitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMetaTitle($metaTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaTitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaTitle)) {
                $metaTitle = str_replace('*', '%', $metaTitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::META_TITLE, $metaTitle, $comparison);
    }

    /**
     * Filter the query on the meta_description column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaDescription('fooValue');   // WHERE meta_description = 'fooValue'
     * $query->filterByMetaDescription('%fooValue%'); // WHERE meta_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMetaDescription($metaDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaDescription)) {
                $metaDescription = str_replace('*', '%', $metaDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::META_DESCRIPTION, $metaDescription, $comparison);
    }

    /**
     * Filter the query on the meta_keywords column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaKeywords('fooValue');   // WHERE meta_keywords = 'fooValue'
     * $query->filterByMetaKeywords('%fooValue%'); // WHERE meta_keywords LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaKeywords The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function filterByMetaKeywords($metaKeywords = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaKeywords)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaKeywords)) {
                $metaKeywords = str_replace('*', '%', $metaKeywords);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeedleSeoI18nTableMap::META_KEYWORDS, $metaKeywords, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMeedleSeoI18n $meedleSeoI18n Object to remove from the list of results
     *
     * @return ChildMeedleSeoI18nQuery The current query, for fluid interface
     */
    public function prune($meedleSeoI18n = null)
    {
        if ($meedleSeoI18n) {
            $this->addUsingAlias(MeedleSeoI18nTableMap::ID, $meedleSeoI18n->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the meedle_seo_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoI18nTableMap::DATABASE_NAME);
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
            MeedleSeoI18nTableMap::clearInstancePool();
            MeedleSeoI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMeedleSeoI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMeedleSeoI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MeedleSeoI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MeedleSeoI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MeedleSeoI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MeedleSeoI18nQuery
