<?php

/**
 * Description of LoginValidator
 *
 * @author Pedro
 */
namespace Application\Form\Validator;

use Zend\InputFilter\InputFilter;

class ContactValidator extends InputFilter
{

    protected $opcionesAlnum = array(
        'allowWhiteSpace' => true,
        'messages' => array(
            'notAlnum' => "El valor no es alfanumerico"
        )
    );
    
    protected $filterGeneric = array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            );
    

    public function __construct()
    {      
                
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum
                )
            ),
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        ));
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        ));
        $this->add(array(
            'name' => 'messaje',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        ));
       
    }
}
