<?php
class Application_Plugin_Universal extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $controllerName = $request->getControllerName();
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $universal = $bootstrap->getOption('universal');
        if(!in_array($controllerName, $universal['page'])) return;

        if(isset($universal['page'][$controllerName]['model'])) {
            $model = new $universal['page'][$controllerName]['model'];
        }
        else {
            $model = new Batman_Model(strtolower($controllerName));
        }

        $request->setControllerName('universal');
        $request->setParams(
            array(
                'universal_hash' => $universal['hash'],
                'original_controller' => $controllerName,
                'model' => $model
            )
        );
    }
}