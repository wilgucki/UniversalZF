<?php
class UniversalController extends Zend_Controller_Action
{
    /**
     * @var Batman_Model_Abstract
     */
    private $_model = null;

    public function init()
    {
        $universal = $this->getInvokeArg('bootstrap')->getOption('universal');
        if($universal['hash'] != $this->_getParam('universal_hash')) {
            throw new UnexpectedValueException('Invalid universal hash');
        }
        $this->_model = $this->_getParam('model');
    }

    public function indexAction()
    {
        $cols = $this->_model->getDbTable()->info(Zend_Db_Table_Abstract::COLS);
        $universal = $this->getInvokeArg('bootstrap')->getOption('universal');
        $controller = $this->_getParam('controller');

        if(isset($universal['page'][$controller]) && isset($universal['page'][$controller]['skipCols'])) {
            $cols = array_diff($cols, $universal['page'][$controller]['skipCols']);
        }

        $this->view->cols = $cols;
        $this->view->items = $this->_model->getItems();
        $this->_renderView($controller, $this->_getParam('action'));
    }

    public function addAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = (int)$this->_getParam('id', 0);
        $item = $this->_model->getItem($id);
        $form = $this->_model->getForm();

        if($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if($form->isValid($post)) {
                $this->_model->save($form->getValues(), $item);
                $this->_helper->redirector(null, $this->_getParam('original_controller'));
            }
        }
        else {
            $form->populate($item !== null ? $item->toArray() : array());
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $id = (int)$this->_getParam('id', 0);
        $this->_model->delete(array('id = ?' => $id));
        $this->_helper->redirector(null, $this->_getParam('original_controller'));
    }

    private function _renderView($controller, $action)
    {
        $universal = $this->getInvokeArg('bootstrap')->getOption('universal');
        if(isset($universal['page'][$controller]['view'][$action])) {
            $this->renderScript($universal['page'][$controller]['view'][$action]);
        }
    }
}