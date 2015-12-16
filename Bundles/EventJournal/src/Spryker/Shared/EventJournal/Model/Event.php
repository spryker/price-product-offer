<?php

/**
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace Spryker\Shared\EventJournal\Model;

class Event implements EventInterface
{

    const FIELD_NAME = 'name';

    const FIELD_EVENT_ID = '_event_id';

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected static $staticFields  = [];

    public function __construct()
    {
        $this->setField(self::FIELD_NAME, null);
        $this->setField(self::FIELD_EVENT_ID, uniqid('', true));
    }

    /**
     * @param $name
     * @param $data
     *
     * @throws DataInvalidException
     *
     * @return void
     */
    public function setStaticField($name, $data) {
        $this->validateData($name, $data);
        self::$staticFields[$name] = $data;
    }

    /**
     * @param string $name
     * @param array|string $data
     *
     * @throws DataInvalidException
     *
     * @return void
     */
    public function setField($name, $data)
    {
        $this->validateData($name, $data);
        if(isset(static::$staticFields[$name])) {
            static::$staticFields[$name] = $data;
            return;
        }
        $this->fields[$name] = $data;
    }

    /**
     * @param array|string $data
     *
     * @return bool
     */
    private function isValidData($data)
    {
        $check = !is_object($data);

        if (is_array($data)) {
            foreach ($data as $childElements) {
                $check |= $this->isValidData($childElements);
            }
        }

        return $check;
    }

    /**
     * @param array $fields
     *
     * @throws DataInvalidException
     *
     * @return void
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $name => $data) {
            $this->setField($name, $data);
        }
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return array_merge_recursive(self::$staticFields, $this->fields);
    }

    /**
     * @param $name
     * @param $data
     *
     * @throws DataInvalidException
     *
     * @return void
     */
    protected function validateData($name, $data)
    {
        if (!$this->isValidData($data)) {
            throw new DataInvalidException(sprintf(
                'Data contains invalid elements (maybe objects) for key %s',
                $name
            ));
        }
    }

}
