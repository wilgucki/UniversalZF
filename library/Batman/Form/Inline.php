<?php
class Batman_Form_Inline extends Zend_Form
{
    public function init()
    {
        $this->clearDecorators();
        $this->addDecorator('FormElements')
      	     ->addDecorator('HtmlTag', array('tag' => 'div'))
      		 ->addDecorator('Form');
        $this->addAttribs(array('class' => 'form-inline'));

        $this->setElementDecorators(array(
            'PrepareElements',
            array('ViewHelper'),
            array('Label'),
            array('Description'),
            array('HtmlTag', array('tag' => 'span', 'class' => 'control-group'))
        ));

        /**
         * @var $element Zend_Form_Element
         */
        foreach($this->getElements() as $element) {
            if($element->getType() == 'Zend_Form_Element_Submit') {
                $cssClass = $element->getAttrib('class');
                if($cssClass === null) $element->setAttrib('class', 'btn');
                else $element->setAttrib('class', $cssClass . ' btn');
                $element->setDecorators(array(
                    array('ViewHelper')
                ));
            }
        }

        $view = $this->getView();
        $view->headScript()->appendFile('/bootstrap/js/bootstrap-tooltip.js');
        $view->headScript()->appendScript('$(".control-group input").tooltip();');
    }

    public function isValid($data)
    {
        $isValid = parent::isValid($data);

        /**
         * @var $element Zend_Form_Element
         */
        foreach($this->getElements() as $element) {
            if($element->hasErrors()) {
                $element->addDecorator('HtmlTag', array('tag' => 'span', 'class' => 'control-group error'));
            }
        }

        return $isValid;
    }
}