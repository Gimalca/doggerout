<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Description of RegisterForm
 *
 * @author Pedro
 */
class ContactForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttribute('action', '/application/contact');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'id' => 'name',
                'class' => 'form-control input-lg',
                'placeholder' => 'Nombre',
                'size' => 30,
                'required' => true,
                
            ),
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                
                'id' => 'firstname',
                'class' => 'form-control input-lg',
                'placeholder' => 'Correo Electrónico',
                'required' => true,
               
            ),
        ));
       
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'messaje',
           'attributes' => array(              
                'id' => 'messaje',
                'class' => 'form-control input-lg',
                'placeholder' => 'Mensaje',
                'required' => true,
               
        
            ),
        ));

        // Crear y configurar el elemento confirmarPassword:
      
         $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
    }

    //put your code here
}
