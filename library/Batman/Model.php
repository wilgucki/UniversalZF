<?php
class Batman_Model extends Batman_Model_Abstract
{
    public function __construct($modelName)
    {
        $this->_modelName = $modelName;
        $this->setDbTable(new Zend_Db_Table($modelName));
    }
}