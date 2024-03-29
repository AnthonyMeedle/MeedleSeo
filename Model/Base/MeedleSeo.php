<?php

namespace MeedleSeo\Model\Base;

use \Exception;
use \PDO;
use MeedleSeo\Model\MeedleSeoQuery as ChildMeedleSeoQuery;
use MeedleSeo\Model\Map\MeedleSeoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class MeedleSeo implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MeedleSeo\\Model\\Map\\MeedleSeoTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the view_name field.
     * @var        string
     */
    protected $view_name;

    /**
     * The value for the view_id field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $view_id;

    /**
     * The value for the og_url field.
     * @var        string
     */
    protected $og_url;

    /**
     * The value for the og_title field.
     * @var        string
     */
    protected $og_title;

    /**
     * The value for the og_description field.
     * @var        string
     */
    protected $og_description;

    /**
     * The value for the file field.
     * @var        string
     */
    protected $file;

    /**
     * The value for the og_type field.
     * @var        string
     */
    protected $og_type;

    /**
     * The value for the locale field.
     * @var        string
     */
    protected $locale;

    /**
     * The value for the nofollow field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $nofollow;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->view_id = 0;
        $this->nofollow = 0;
    }

    /**
     * Initializes internal state of MeedleSeo\Model\Base\MeedleSeo object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>MeedleSeo</code> instance.  If
     * <code>obj</code> is an instance of <code>MeedleSeo</code>, delegates to
     * <code>equals(MeedleSeo)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return MeedleSeo The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return MeedleSeo The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [view_name] column value.
     *
     * @return   string
     */
    public function getViewName()
    {

        return $this->view_name;
    }

    /**
     * Get the [view_id] column value.
     *
     * @return   int
     */
    public function getViewId()
    {

        return $this->view_id;
    }

    /**
     * Get the [og_url] column value.
     *
     * @return   string
     */
    public function getOgUrl()
    {

        return $this->og_url;
    }

    /**
     * Get the [og_title] column value.
     *
     * @return   string
     */
    public function getOgTitle()
    {

        return $this->og_title;
    }

    /**
     * Get the [og_description] column value.
     *
     * @return   string
     */
    public function getOgDescription()
    {

        return $this->og_description;
    }

    /**
     * Get the [file] column value.
     *
     * @return   string
     */
    public function getFile()
    {

        return $this->file;
    }

    /**
     * Get the [og_type] column value.
     *
     * @return   string
     */
    public function getOgType()
    {

        return $this->og_type;
    }

    /**
     * Get the [locale] column value.
     *
     * @return   string
     */
    public function getLocale()
    {

        return $this->locale;
    }

    /**
     * Get the [nofollow] column value.
     *
     * @return   int
     */
    public function getNofollow()
    {

        return $this->nofollow;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MeedleSeoTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [view_name] column.
     *
     * @param      string $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setViewName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->view_name !== $v) {
            $this->view_name = $v;
            $this->modifiedColumns[MeedleSeoTableMap::VIEW_NAME] = true;
        }


        return $this;
    } // setViewName()

    /**
     * Set the value of [view_id] column.
     *
     * @param      int $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setViewId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->view_id !== $v) {
            $this->view_id = $v;
            $this->modifiedColumns[MeedleSeoTableMap::VIEW_ID] = true;
        }


        return $this;
    } // setViewId()

    /**
     * Set the value of [og_url] column.
     *
     * @param      string $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setOgUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->og_url !== $v) {
            $this->og_url = $v;
            $this->modifiedColumns[MeedleSeoTableMap::OG_URL] = true;
        }


        return $this;
    } // setOgUrl()

    /**
     * Set the value of [og_title] column.
     *
     * @param      string $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setOgTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->og_title !== $v) {
            $this->og_title = $v;
            $this->modifiedColumns[MeedleSeoTableMap::OG_TITLE] = true;
        }


        return $this;
    } // setOgTitle()

    /**
     * Set the value of [og_description] column.
     *
     * @param      string $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setOgDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->og_description !== $v) {
            $this->og_description = $v;
            $this->modifiedColumns[MeedleSeoTableMap::OG_DESCRIPTION] = true;
        }


        return $this;
    } // setOgDescription()

    /**
     * Set the value of [file] column.
     *
     * @param      string $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setFile($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->file !== $v) {
            $this->file = $v;
            $this->modifiedColumns[MeedleSeoTableMap::FILE] = true;
        }


        return $this;
    } // setFile()

    /**
     * Set the value of [og_type] column.
     *
     * @param      string $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setOgType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->og_type !== $v) {
            $this->og_type = $v;
            $this->modifiedColumns[MeedleSeoTableMap::OG_TYPE] = true;
        }


        return $this;
    } // setOgType()

    /**
     * Set the value of [locale] column.
     *
     * @param      string $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setLocale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locale !== $v) {
            $this->locale = $v;
            $this->modifiedColumns[MeedleSeoTableMap::LOCALE] = true;
        }


        return $this;
    } // setLocale()

    /**
     * Set the value of [nofollow] column.
     *
     * @param      int $v new value
     * @return   \MeedleSeo\Model\MeedleSeo The current object (for fluent API support)
     */
    public function setNofollow($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->nofollow !== $v) {
            $this->nofollow = $v;
            $this->modifiedColumns[MeedleSeoTableMap::NOFOLLOW] = true;
        }


        return $this;
    } // setNofollow()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->view_id !== 0) {
                return false;
            }

            if ($this->nofollow !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MeedleSeoTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MeedleSeoTableMap::translateFieldName('ViewName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->view_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MeedleSeoTableMap::translateFieldName('ViewId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->view_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MeedleSeoTableMap::translateFieldName('OgUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->og_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MeedleSeoTableMap::translateFieldName('OgTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->og_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : MeedleSeoTableMap::translateFieldName('OgDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->og_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : MeedleSeoTableMap::translateFieldName('File', TableMap::TYPE_PHPNAME, $indexType)];
            $this->file = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : MeedleSeoTableMap::translateFieldName('OgType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->og_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : MeedleSeoTableMap::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locale = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : MeedleSeoTableMap::translateFieldName('Nofollow', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nofollow = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = MeedleSeoTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \MeedleSeo\Model\MeedleSeo object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MeedleSeoTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMeedleSeoQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see MeedleSeo::setDeleted()
     * @see MeedleSeo::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildMeedleSeoQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeedleSeoTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                MeedleSeoTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[MeedleSeoTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MeedleSeoTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MeedleSeoTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::VIEW_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'VIEW_NAME';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::VIEW_ID)) {
            $modifiedColumns[':p' . $index++]  = 'VIEW_ID';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::OG_URL)) {
            $modifiedColumns[':p' . $index++]  = 'OG_URL';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::OG_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'OG_TITLE';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::OG_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'OG_DESCRIPTION';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::FILE)) {
            $modifiedColumns[':p' . $index++]  = 'FILE';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::OG_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'OG_TYPE';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::LOCALE)) {
            $modifiedColumns[':p' . $index++]  = 'LOCALE';
        }
        if ($this->isColumnModified(MeedleSeoTableMap::NOFOLLOW)) {
            $modifiedColumns[':p' . $index++]  = 'NOFOLLOW';
        }

        $sql = sprintf(
            'INSERT INTO meedle_seo (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'VIEW_NAME':
                        $stmt->bindValue($identifier, $this->view_name, PDO::PARAM_STR);
                        break;
                    case 'VIEW_ID':
                        $stmt->bindValue($identifier, $this->view_id, PDO::PARAM_INT);
                        break;
                    case 'OG_URL':
                        $stmt->bindValue($identifier, $this->og_url, PDO::PARAM_STR);
                        break;
                    case 'OG_TITLE':
                        $stmt->bindValue($identifier, $this->og_title, PDO::PARAM_STR);
                        break;
                    case 'OG_DESCRIPTION':
                        $stmt->bindValue($identifier, $this->og_description, PDO::PARAM_STR);
                        break;
                    case 'FILE':
                        $stmt->bindValue($identifier, $this->file, PDO::PARAM_STR);
                        break;
                    case 'OG_TYPE':
                        $stmt->bindValue($identifier, $this->og_type, PDO::PARAM_STR);
                        break;
                    case 'LOCALE':
                        $stmt->bindValue($identifier, $this->locale, PDO::PARAM_STR);
                        break;
                    case 'NOFOLLOW':
                        $stmt->bindValue($identifier, $this->nofollow, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MeedleSeoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getViewName();
                break;
            case 2:
                return $this->getViewId();
                break;
            case 3:
                return $this->getOgUrl();
                break;
            case 4:
                return $this->getOgTitle();
                break;
            case 5:
                return $this->getOgDescription();
                break;
            case 6:
                return $this->getFile();
                break;
            case 7:
                return $this->getOgType();
                break;
            case 8:
                return $this->getLocale();
                break;
            case 9:
                return $this->getNofollow();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['MeedleSeo'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MeedleSeo'][$this->getPrimaryKey()] = true;
        $keys = MeedleSeoTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getViewName(),
            $keys[2] => $this->getViewId(),
            $keys[3] => $this->getOgUrl(),
            $keys[4] => $this->getOgTitle(),
            $keys[5] => $this->getOgDescription(),
            $keys[6] => $this->getFile(),
            $keys[7] => $this->getOgType(),
            $keys[8] => $this->getLocale(),
            $keys[9] => $this->getNofollow(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }


        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MeedleSeoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setViewName($value);
                break;
            case 2:
                $this->setViewId($value);
                break;
            case 3:
                $this->setOgUrl($value);
                break;
            case 4:
                $this->setOgTitle($value);
                break;
            case 5:
                $this->setOgDescription($value);
                break;
            case 6:
                $this->setFile($value);
                break;
            case 7:
                $this->setOgType($value);
                break;
            case 8:
                $this->setLocale($value);
                break;
            case 9:
                $this->setNofollow($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = MeedleSeoTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setViewName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setViewId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setOgUrl($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setOgTitle($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setOgDescription($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setFile($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setOgType($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setLocale($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setNofollow($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MeedleSeoTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MeedleSeoTableMap::ID)) $criteria->add(MeedleSeoTableMap::ID, $this->id);
        if ($this->isColumnModified(MeedleSeoTableMap::VIEW_NAME)) $criteria->add(MeedleSeoTableMap::VIEW_NAME, $this->view_name);
        if ($this->isColumnModified(MeedleSeoTableMap::VIEW_ID)) $criteria->add(MeedleSeoTableMap::VIEW_ID, $this->view_id);
        if ($this->isColumnModified(MeedleSeoTableMap::OG_URL)) $criteria->add(MeedleSeoTableMap::OG_URL, $this->og_url);
        if ($this->isColumnModified(MeedleSeoTableMap::OG_TITLE)) $criteria->add(MeedleSeoTableMap::OG_TITLE, $this->og_title);
        if ($this->isColumnModified(MeedleSeoTableMap::OG_DESCRIPTION)) $criteria->add(MeedleSeoTableMap::OG_DESCRIPTION, $this->og_description);
        if ($this->isColumnModified(MeedleSeoTableMap::FILE)) $criteria->add(MeedleSeoTableMap::FILE, $this->file);
        if ($this->isColumnModified(MeedleSeoTableMap::OG_TYPE)) $criteria->add(MeedleSeoTableMap::OG_TYPE, $this->og_type);
        if ($this->isColumnModified(MeedleSeoTableMap::LOCALE)) $criteria->add(MeedleSeoTableMap::LOCALE, $this->locale);
        if ($this->isColumnModified(MeedleSeoTableMap::NOFOLLOW)) $criteria->add(MeedleSeoTableMap::NOFOLLOW, $this->nofollow);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(MeedleSeoTableMap::DATABASE_NAME);
        $criteria->add(MeedleSeoTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MeedleSeo\Model\MeedleSeo (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setViewName($this->getViewName());
        $copyObj->setViewId($this->getViewId());
        $copyObj->setOgUrl($this->getOgUrl());
        $copyObj->setOgTitle($this->getOgTitle());
        $copyObj->setOgDescription($this->getOgDescription());
        $copyObj->setFile($this->getFile());
        $copyObj->setOgType($this->getOgType());
        $copyObj->setLocale($this->getLocale());
        $copyObj->setNofollow($this->getNofollow());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \MeedleSeo\Model\MeedleSeo Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->view_name = null;
        $this->view_id = null;
        $this->og_url = null;
        $this->og_title = null;
        $this->og_description = null;
        $this->file = null;
        $this->og_type = null;
        $this->locale = null;
        $this->nofollow = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MeedleSeoTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
