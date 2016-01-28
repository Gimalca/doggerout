<?php

namespace Application\Controller;

use Application\Form\ContactForm;
use Application\Form\Validator\ContactValidator;
use Zend\Mail\Message as MailMessage;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $contactForm = new ContactForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );
            $contactForm->setInputFilter(New ContactValidator);
            $contactForm->setData($postData);
//            var_dump($contactForm->getMessages());
//            var_dump($contactForm->isValid());die;
            if ($contactForm->isValid()) {
                $contactData = $contactForm->getData();
//                var_dump($contactData);die;
                $sendMail = $this->sendMailRegisterConfirm($contactData);
            }
        }
        $view['contact_form'] = $contactForm;
        $viewM = new ViewModel($view);
        $viewM->setTerminal(true);
        return $view;
    }

    private function sendMailRegisterConfirm($contactData) {

//        print_r($contactData);die;
        $mailer = $this->getServiceLocator()->get('Mailer');
        $message = new MailMessage;
        $message->setBody('El Mensaje es: '.$contactData['messaje']);
        $message->addTo($contactData['email'])
                ->addFrom($contactData['email'])
                ->setSubject('Contacto Solicitado por Doggerout.com por '.$contactData['name']);


        $sendMail = $mailer->send($message);


        return $sendMail;
    }

}
