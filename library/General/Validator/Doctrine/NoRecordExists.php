<?php

namespace General\Validator\Doctrine;

use Doctrine\ORM\EntityManager;
use Zend\Validator\AbstractValidator;

/**
 * Created by PhpStorm.
 * User: David Dattée
 * Date: 09/10/2016
 * Time: 17:39
 */
class NoRecordExists extends AbstractValidator
{
    const ENTITY_FOUND = 'entityFound';

    /**
     * Error messages
     *
     * @var array
     */
    protected $messageTemplates = array();

    /**
     * Doctrine entity manager
     *
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * Query to check record existence
     * @param string
     */
    protected $query;

    /**
     * Entity name to query
     * @param string
     */
    protected $entity;

    /**
     * Field to query
     * @var string
     */
    protected $field;


    /**
     * Determines if empty values (null, empty string) will <b>NOT</b> be included in the check.
     * Defaults to true
     * @var bool
     */
    protected $ignoreEmpty = true;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        // Init messages
        $this->messageTemplates[self::ENTITY_FOUND] = $this->translate('There is already a record with this value.');

        parent::__construct($options);
    }

    /**
     * Check if record exist for the given entity
     *
     * @throws \Exception in case EntityManager or query is missing
     */
    public function isValid($value)
    {
        // Fetch entityManager
        $em = $this->getEntityManager();

        if(null === $em)
            throw new \Exception(__METHOD__ . ' There is no entityManager set.');

        // Fetch query
        $query = $this->getQuery();

        if(null === $query)
            throw new \Exception(__METHOD__ . ' There is no query set.');

        // Ignore empty values?
        if((null === $value || '' === $value) && $this->getIgnoreEmpty())
            return true;

        $queryObj = $em->createQuery($query)->setMaxResults(1);
        $entitiesFound = count($queryObj->execute(array(':value' => $value)));

        // Set Error message
        if($entitiesFound)
            $this->error(self::ENTITY_FOUND);

        // Valid if no records are found -> result count is 0
        return ! $entitiesFound;
    }

    /**
     * Translate error messages
     *
     * @param string $msg
     *
     * @return string
     */
    public function translate($msg)
    {
        return $msg;
    }

    /**
     * Get ignore empty param
     *
     * @return the $ignoreEmpty
     */
    public function getIgnoreEmpty()
    {
        return $this->ignoreEmpty;
    }

    /**
     * Ignore empty value
     *
     * @param boolean $ignoreEmpty Ignore empty
     *
     * @return $this
     */
    public function setIgnoreEmpty($ignoreEmpty)
    {
        $this->ignoreEmpty = $ignoreEmpty;
        return $this;
    }

    /**
     * Set entity manager
     *
     * @param EntityManager $entityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * Get checking query
     *
     * @return the $query
     */
    public function getQuery()
    {
        if (empty($this->query)) {
            $query = 'SELECT e FROM %1$s e WHERE e.%2$s = :value';
            $this->query = sprintf(
                $query,
                $this->getEntity(),
                $this->getField()
            );
        }
        return $this->query;
    }

    /**
     * Set query to chec existence
     *
     * @param field_type $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Get entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }


}