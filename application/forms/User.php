<?php
class Application_Form_User extends Batman_Form_Horizontal
{
    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Imie i nazwisko')
             ->setRequired(true)
             ->addValidator(new Zend_Validate_NotEmpty());

        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login')
              ->setRequired(true)
              ->addValidator(new Zend_Validate_NotEmpty());


        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Hasło')
                 ->addFilter(new Zend_Filter_Callback('md5'));

        $submit = new Zend_Form_Element_Submit('btn_save');
        $submit->setLabel('Zapisz')
               ->setIgnore(true);

        $this->addElement($name);
        $this->addElement($login);
        $this->addElement($password);
        $this->addElement($submit);

        parent::init();
    }
}