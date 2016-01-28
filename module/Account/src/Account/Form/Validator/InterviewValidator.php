<?php

/**
 * Description of LoginValidator
 *
 * @author Pedro
 */

namespace Account\Form\Validator;

use Zend\InputFilter\InputFilter;

class InterviewValidator extends InputFilter
{
    
    protected $opcionesAlnum = array(
        'allowWhiteSpace' => true,
     
    );
    protected $opcionesAlnum2 = array(
        'allowWhiteSpace' => false,
       
    );
    protected $opcionesAlpha2 = array(
        'allowWhiteSpace' => false,
      
    );
    protected $filterGeneric = array(
        array(
            'name' => 'StripTags'
        ),
        array(
            'name' => 'StringTrim'
        ),
        array(
            'name' => 'StringToLower',
            'options' => array(
                'encoding' => 'UTF-8'
                ),      
        )
    );
    
    public function __construct()
    {
       
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
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        
                    )
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                       
                    )
                ),
             
            )
        ));      
      
       
    }

}
