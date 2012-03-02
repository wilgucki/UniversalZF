<?php
class Batman_Form_Horizontal extends Zend_Form
{
    public function init()
    {
        $this->clearDecorators();
        $this->addDecorator('FormElements')
      	     ->addDecorator('HtmlTag', array('tag' => 'div'))
      		 ->addDecorator('Form');
        $this->addAttribs(array('class' => 'form-horizontal'));

        $this->setElementDecorators(array(
            'PrepareElements',
            array('ViewScript', array('viewScript' => 'form_element.phtml'))
        ));

        /**
         * @var $element Zend_Form_Element
         */
        foreach($this->getElements() as $element) {
            switch($element->getType()) {
                case 'Zend_Form_Element_Submit':
                    $cssClass = $element->getAttrib('class');
                    if($cssClass === null) $element->setAttrib('class', 'btn btn-primary');
                    else $element->setAttrib('class', ' btn btn-primary' . $cssClass);
                    $element->setDecorators(array(
                        array('ViewHelper')
                    ));
                    break;
            }
        }
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