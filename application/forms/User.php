<?php
class Application_Form_User extends Zend_Form
{
    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Imie i nazwisko');

        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login');

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
    }
}