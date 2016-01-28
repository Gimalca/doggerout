<?php

namespace Account\Form;

use Zend\Form\Form;

/**
 * Description of RegisterForm
 *
 * @author Pedro
 */
class RegisterForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttribute('action', 'account/register/addUser');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                
                'id' => 'email',
                'class' => 'form-control input-lg',
                'placeholder' => 'Email',
                'required' => true,
               
            ),
        ));
       
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
           'attributes' => array(              
                'id' => 'password',
                'class' => 'form-control input-lg',
                'placeholder' => 'Contraseña',
                'required' => true,
               
        
            ),
        ));

        // Crear y configurar el elemento confirmarPassword:
      
//         $this->add(array(
//            'name' => 'csrf',
//            'type' => 'Zend\Form\Element\Csrf',
//        ));
    }

    //put your code here
}
