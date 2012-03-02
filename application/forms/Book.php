<?php
class Application_Form_Book extends Batman_Form_Horizontal
{
    public function init()
    {
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Tytuł')
              ->setRequired(true)
              ->addValidator(new Zend_Validate_NotEmpty());

        $submit = new Zend_Form_Element_Submit('btn_save');
        $submit->setLabel('Zapisz')
               ->setIgnore(true);

        $this->addElement($title);
        $this->addElement($submit);

        parent::init();
    }
}