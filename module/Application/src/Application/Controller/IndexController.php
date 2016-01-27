<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\Mail\Message as MailMessage;
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage; 
use Application\Form\ContactForm;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $contactForm = new ContactForm();
        $view['contact_form'] = $contactForm;    
        $viewM = new ViewModel($view);        
        $viewM->setTerminal(true);
        return $view;
    }
    
     private function sendMailRegisterConfirm()
    {
        $render = $this->getService('ViewRenderer');       
        $content = $render->render('account/register/email/confirm-email',array(
                'customer' => $customerEntity,
                'link' => $this->getRequest()->getServer('HTTP_ORIGIN') . $this->url()->fromRoute('account', array(
                                    'controller' => 'register',
                                    'action' => 'confirm-email',
                                    'id' => $customerEntity->token))
                ));
        

    // make a header as html  
    $html = new MimePart($content);  
    $html->type = "text/html";  
    $body = new MimeMessage();  
    $body->setParts(array($html));  
        
    //print_r($body);die;
    $mailer = $this->getServiceLocator()->get('Mailer');
            $message = new MailMessage;
            $message->setBody($body);
            $message->addTo( $customerEntity->email)
                    ->addFrom('noreply@piderapido.com')
                    ->setSubject('Piderapido.com, confirma tu registro!');
                    
            
     $sendMail =  $mailer->send($message);
           
             
    return $sendMail;         
    }
}
