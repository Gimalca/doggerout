<?php

namespace Account\Controller;

use Exception;
use Account\Form\InterviewForm;
use Account\Form\RegisterForm;
use Account\Form\Validator\RegisterValidator;
use Account\Form\Validator\InterviewValidator;
use User\Model\Dao\UserDao;
use User\Model\Entity\Interview;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message as MailMessage;
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage;   

class RegisterController extends AbstractActionController {

    public function indexAction() {


        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function addUserAction() {
        $request = $this->getRequest();
        $registerForm = new RegisterForm();

//        var_dump($registerForm);die;

        if ($request->isPost()) {
            //recibimos los datos del form
            $postData = $request->getPost();
//            var_dump($postData);die;
            //validamos los datos enviados
            $registerValidator = $registerForm->setInputFilter(New RegisterValidator($this->getServiceLocator()));
            $registerValidator->setData($postData);
//            var_dump($registerValidator->isValid());die;
            if ($registerValidator->isValid()) {  //si son validados continuamos
                //obtenemos los datos validados y filtrados 
                $registerData = $registerValidator->getData();
                $customerPrepareData = $this->prepareDataCustomer($registerData);

                //incializamos la clase Entity Customer y le inyectamos los datos
                $userEntity = new User($customerPrepareData);

                //traemos el servicio CustomerTableGateway el cual nos trae el Adapter de la DB
                $userTableGateway = $this->getService('UserTableGateway');
                //inicializamos la clase CustomerDao y le inyectamos el Adapter
                $userDao = new UserDao($userTableGateway);
                //Salvamos el registro en la bd
                $saved = $userDao->saveUser($userEntity);
//                 print_r($saved);die;

                if ($saved) { //si se guardo la fila en la BD continuamos
                    //enviamos el mail con
                    $sendMail = $this->sendMailRegisterConfirm($userEntity);
                    //seteamos el mesanje de registro exitoso
                    $this->flashMessenger()->addMessage("Registro exitoso!!. Acabamos de enviarle un correo a $userEntity->email para confirmar su cuenta", 'success');
                    //$this->flashMessenger()->addMessage("Bienvenido $customerEntity->firstname $customerEntity->lastname !!. Acabamos de enviarle un correo de confirmacion ", 'success');
                    return $this->redirect()->toRoute('account');
                } else {
                    $this->flashMessenger()->addMessage("Disculpe no pudimos procesar su registro ", "error");
                    // throw new \Exception("Not Save Row");
                    return $this->redirect()->toRoute('account');
                }
            } else {
                $messages = $registerValidator->getMessages();
                //print_r($messages);die;
                $this->flashMessenger()->addMessage($messages, 'error');
                return $this->redirect()->toRoute('account');
            }
        }
    }
    
    public function addInterviewAction() {
        $request = $this->getRequest();
        $interviewForm = new InterviewForm();

//        var_dump($registerForm);die;

        if ($request->isPost()) {
            //recibimos los datos del form
            $postData = $request->getPost();
//            var_dump($postData);die;
            //validamos los datos enviados
            $interviewValidator = $interviewForm->setInputFilter(new InterviewValidator());
            $interviewValidator->setData($postData);
//            var_dump($interviewValidator->isValid());die;
            if ($interviewValidator->isValid()) {  //si son validados continuamos
                //obtenemos los datos validados y filtrados 
                $interviewData = $interviewValidator->getData();
                $interviewPrepareData = $this->prepareDataInterview($interviewData);

                //incializamos la clase Entity Customer y le inyectamos los datos
                $interviewEntity = new Interview($interviewPrepareData);

                //traemos el servicio CustomerTableGateway el cual nos trae el Adapter de la DB
                $interviewTableGateway = $this->getService('InterviewTableGateway');
                //inicializamos la clase CustomerDao y le inyectamos el Adapter
                $userDao = new UserDao($interviewTableGateway);
                //Salvamos el registro en la bd
                $saved = $userDao->saveInterview($interviewEntity);
//                 print_r($saved);die;

                if ($saved) { //si se guardo la fila en la BD continuamos
                    //enviamos el mail con
                    $sendMail = $this->sendMailInterviewConfirm($interviewEntity);
                    //seteamos el mesanje de registro exitoso
                    $this->flashMessenger()->addMessage("Registro exitoso!!. Acabamos de enviarle un correo a $interviewEntity->email para confirmar su cuenta", 'success');
                    //$this->flashMessenger()->addMessage("Bienvenido $customerEntity->firstname $customerEntity->lastname !!. Acabamos de enviarle un correo de confirmacion ", 'success');
                    return $this->redirect()->toRoute('account');
                } else {
                    $this->flashMessenger()->addMessage("Disculpe no pudimos procesar su registro ", "error");
                    // throw new \Exception("Not Save Row");
                    return $this->redirect()->toRoute('account');
                }
            } else {
                $messages = $interviewValidator->getMessages();
                //print_r($messages);die;
                $this->flashMessenger()->addMessage($messages, 'error');
                return $this->redirect()->toRoute('account');
            }
        }
    }

    private function prepareDataCustomer($customerData) {
        $customerData['salt'] = time();
        $customerData['password'] = md5($customerData['password'] . $customerData['salt']);

        return $customerData;
    }
    private function prepareDataInterview($interviewData) {
        $interviewData['date_created'] = date("Y-m-d H:i:s");

        return $interviewData;
    }

    private function sendMailRegisterConfirm($userEntity) {
        //print_r($body);die;
        $mailer = $this->getServiceLocator()->get('Mailer');
        $message = new MailMessage;
        $message->setBody('prueba');
        $message->addTo($userEntity->email)
                ->addFrom('oaps212@gmail.com')
                ->setSubject('Registro de Usuario Exitoso');


        $sendMail = $mailer->send($message);


        return $sendMail;
    }
    private function sendMailInterviewConfirm($interviewEntity) {
        //print_r($body);die;
        $mailer = $this->getServiceLocator()->get('Mailer');
        $message = new MailMessage;
        $message->setBody('prueba');
        $message->addTo($interviewEntity->email)
                ->addFrom('oaps212@gmail.com')
                ->setSubject('Creaciion de cita exitosa');


        $sendMail = $mailer->send($message);


        return $sendMail;
    }

    public function confirmEmailAction() {
        $token = $this->params()->fromRoute('id');
        // echo print_r($token).' - token';die;
        $viewModel = new ViewModel(array('token' => $token));
        try {
            //traemos el servicio CustomerTableGateway el cual nos trae el Adapter de la DB
            $customerTableGateway = $this->getService('CustomerTableGateway');
            //inicializamos la clase CustomerDao y le inyectamos el Adapter
            $userDao = new UserDao($customerTableGateway);
            $user = $userDao->getUserByToken($token);
            //print_r($user);die;
            $usr_id = $user->customer_id;
            //print_r($user);die;
            $userDao->activateUser($usr_id);

            $loginAccount = $this->getService('Account\Model\LoginAccount');

            $loginAccount->login($user->email, $user->password);
            $this->flashMessenger()->addMessage("Usuario Activado", 'success');

            return $this->redirect()->toRoute('account');
            //seteamos el mesanje de registro exitoso
//             return $this->redirect()->toRoute('account', array(
//                        'controller' => 'register',
//                        'action' => 'add'
//            ));
        } catch (Exception $e) {
            $this->flashMessenger()->addMessage("Token invalido", "error");
            return $this->redirect()->toRoute('account', array(
                        'controller' => 'register',
                        'action' => 'add'
            ));
            //echo $e->getMessage();
            //$viewModel->setTemplate('auth/registration/confirm-email-error.phtml');
        }
        return $viewModel;
    }

    public function getService($serviceName) {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);

        return $service;
    }

}
