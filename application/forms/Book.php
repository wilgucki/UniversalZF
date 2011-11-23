<?php
class Application_Form_Book extends Zend_Form
{
    public function init()
    {
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Tytuł');

        $submit = new Zend_Form_Element_Submit('btn_save');
        $submit->setLabel('Zapisz')
               ->setIgnore(true);

        $this->addElement($title);
        $this->addElement($submit);
    }
}