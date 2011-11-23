<?php
interface Batman_Model_Interface
{
    public function getItems($where = null, $order = null);
    public function getItem($id);
    public function save(array $data, Zend_Db_Table_Row_Abstract $currentItem = null);
    public function delete($id);
    public function getForm();
}