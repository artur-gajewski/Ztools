<?php

/**
 * The Ztools_Table component is used to maintain set of data and
 * to create nice looking dataset table for the view.
 *
 * @copyright  2011 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.2.5
 */
class Ztools_Table
{
    /**
     * Data string
     *
     * @var string $_data
     */
    private $_data = array();

    /**
     * Table output container
     *
     * @var string $_table
     */
    private $_table;

    /**
     * List of columns to be rendered in the table
     *
     * @var array $_columns
     */
    private $_columns = array();

    /**
     * ID of the table to be rendered
     *
     * @var string $_id
     */
    private $_id;

    /**
     * CSS class of the table to be rendered
     *
     * @var string $_class
     */
    private $_class;

    /**
     * Should the counter be visible
     * Possible values: above / below
     * @var boolean $_count
     */
    private $_count = false;

    /**
     * Resultset's minimum to be displayed
     * @var int $_min
     */
    private $_min = 1;

    /**
     * Resultset's minimum + offset to be displayed
     * @var int $_offset
     */
    private $_offset = 100;

		/**
     * Sets the data container columns.
     *
     * @param array $columns
     * @throws Ztools_Table_Exception
     * @return Ztools_Table
     */
    public function setColumns($columns)
    {
        if (!$this->isAssociativeArray($columns)) {
          throw new Ztools_Table_Exception("Array must have \"key => value\" data for each column");
        }

        if (is_array($columns)) {
          $this->_columns = $columns;
        } else {
          throw new Ztools_Table_Exception("Column data must be an array");
        }
        return $this;
    }

		/**
     * Gets the data container columns.
     *
     * @return $this->_columns
     */
    public function getColumns()
    {
        return $this->_columns;
    }

		/**
     * Sets the table ID value.
     *
     * @param string $id
     * @throws Ztools_Table_Exception
     * @return Ztools_Table
     */
    public function setId($id)
    {
        if (!$id) {
            throw new Ztools_Table_Exception("Table ID must have a value");
        }
        $this->_id = $id;
        return $this;
    }

		/**
     * Get the table ID value.
     *
     * @return $this->_id
     */
    public function getId()
    {
        return $this->_id;
    }

		/**
     * Sets the table CLASS value.
     *
     * @param string $class
     * @throws Ztools_Table_Exception
     * @return Ztools_Table
     */
    public function setClass($class)
    {
        if (!$class) {
            throw new Ztools_Table_Exception("Table CLASS must have a value");
        }
        $this->_class = $class;
        return $this;
    }

		/**
     * Get the table CLASS value.
     *
     * @return $this->_class
     */
    public function getClass()
    {
        return $this->_class;
    }

		/**
     * Sets the result row count.
     *
     * @param boolean $value
     * @throws Ztools_Table_Exception
     * @return Ztools_Table
     */
    public function setCount($value)
    {
        $this->_count = $value;
        return $this;
    }

		/**
     * Gets the result row count.
     *
     * @return $this->_count
     */
    public function getCount()
    {
        return $this->_count;
    }

		/**
     * Sets the first row's value.
     *
     * @param int $min
     * @throws Ztools_Table_Exception
     * @return Ztools_Table
     */
    public function setMin($min)
    {
        $this->_min = $min;
        return $this;
    }

		/**
     * Gets the first row's value.
     *
     * @return $this->_min
     */
    public function getMin()
    {
        return $this->_min;
    }

		/**
     * Sets the last row's value (min+offset).
     *
     * @param int $offset
     * @throws Ztools_Table_Exception
     * @return Ztools_Table
     */
    public function setOffset($offset)
    {
        $this->_offset = $offset;
        return $this;
    }

		/**
     * Gets the last row's value (min+offset).
     *
     * @return $this->_offset
     */
    public function getOffset()
    {
        return $this->_offset;
    }

    /**
     * Sets the data container.
     *
     * @param string $value
     * @return Ztools_Table
     */
    public function setData($value)
    {
        $this->_data = $value;
        return $this;
    }

    /**
     * Gets the data container.
     *
     * @return $this->_data
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Adds the tag to be removed.
     *
     * @param mixed $value
     * @return $this->_table
     */
    public function createTable()
    {
        $this->_table = '';
        if (!is_array($this->_data)) {
            throw new Ztools_Table_Exception('Data is not an array');
        }

        $tableOptions = array();
        if ($this->_id) {
          $tableOptions[] = 'id="' . $this->_id . '"';
        }
        if ($this->_class) {
          $tableOptions[] = 'class="' . $this->_class . '"';
        }

        if ($tableOptions) {
          $this->_table .= '<table ' . implode(" ", $tableOptions) . '>';
        } else {
          $this->_table .= '<table>';
        }

        $this->_table .= '<tr>';
        if ($this->_count) {
          $this->_table .= '<th></th>';
        }
        foreach ($this->_columns as $key => $value) {
            $this->_table .= '<th>' . $value . '</th>';
        }
        $this->_table .= '</tr>';

        $count = 1;
        $current = 1;
        foreach ($this->_data as $row) {
          if ($current >= $this->_min && $current < ($this->_min + $this->_offset)) {
            $this->_table .= '<tr>';
            if ($this->_count) {
              $this->_table .= '<td>' . $count . '</td>';
            }
            foreach ($this->_columns as $key => $value) {
              $this->_table .= '<td>' . $row[$key] . '</td>';
            }
            $count++;
          }
          $this->_table .= '</tr>';
          $current++;
        }
        $this->_table .= '</table>';

        return $this->_table;
    }

    /**
     * Check to see if array is of type associative
     *
     * @param array $array
     * @return boolean
     */
    private function isAssociativeArray($array)
    {
        if (is_array($array) && !is_numeric(array_shift(array_keys($array)))) {
            return true;
        }
        return false;
    }

}
