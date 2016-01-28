<?php

namespace Account\Controller;

use Account\Form\RegisterForm;
use Account\Form\InterviewForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{


    public function indexAction()
    {
        $userForm = new RegisterForm();
        $walkerForm = new InterviewForm();
        
        $view['register_form'] = $userForm;   
        $view['walker_form'] = $walkerForm;
        $viewModel =  new ViewModel($view);
        $viewModel->setTerminal(true);
                
        return $viewModel;
    }

}

