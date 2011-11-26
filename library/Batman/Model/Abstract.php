<?php
abstract class Batman_Model_Abstract implements Batman_Model_Interface
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    private $_dbTable = null;
    protected $_modelName = null;

    /**
     * @param Zend_Db_Table_Abstract $dbTable
     * @return void
     */
    public function setDbTable(Zend_Db_Table_Abstract $dbTable)
    {
        $this->_dbTable = $dbTable;
    }

    /**
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if($this->_dbTable === null) {
            $modelClass = get_called_class();
            $classParts = explode('_', $modelClass);
            $className = array_pop($classParts);
            array_push($classParts, 'DbTable', $className);
            $dbTableClass = implode('_', $classParts);
            $this->_dbTable = new $dbTableClass();
        }
        return $this->_dbTable;
    }

    /**
     * @param string|array|Zend_Db_Table_Select $where
     * @param string|array $order
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getItems($where = null, $order = null)
    {
        return $this->getDbTable()->fetchAll($where, $order);
    }

    /**
     * @param mixed $id
     * @return Zend_Db_Table_Row_Abstract
     */
    public function getItem($id)
    {
        return $this->getDbTable()->find($id)->current();
    }

    /**
     * @throws Batman_Model_Exception
     * @param array $data
     * @param null|Zend_Db_Table_Row_Abstract $item
     * @return mixed
     */
    public function save(array $data, Zend_Db_Table_Row_Abstract $item = null)
    {
        $dbTable = $this->getDbTable();
        if($item === null) {
            $item = $dbTable->createRow();
        }

        $cols = $dbTable->info(Zend_Db_Table_Abstract::COLS);

        foreach($data as $k => $v) {
            if(!in_array($k, $cols)) throw new Batman_Model_Exception('Column ' . $k . 'does not exist');
            $item->{$k} = $v;
        }

        return $item->save();
    }

    /**
     * @param array|string $where
     * @return int
     */
    public function delete($where)
    {
        return $this->getDbTable()->delete($where);
    }

    /**
     * @return Zend_Form
     */
    public function getForm()
    {
        if($this->_modelName === null) {
            $this->_modelName = strtolower(array_pop(explode('_', get_called_class())));
        }

        $className = $this->_modelName;
        $appnamespace = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('appnamespace');
        $formClass = $appnamespace . '_Form_' . ucfirst($className);
        return new $formClass;
    }
}