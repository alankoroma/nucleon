<?php

namespace App\Controller\Auth;

use App\Controller\WebController;
use App\Form\Auth\LogInForm;
use App\Application\Auth\LogIn\LogIn;
use App\Application\Auth\LogIn\LogInCommand;
use App\Application\Auth\LogIn\IncorrectCredentialsException;

class LoginController extends WebController
{
    /**
     * @var LogIn
     */
    private $logIn;

    /**
     * @var LogInForm
     */
    private $form;

    /**
     * Creates a new login controller.
     *
     * @param LogIn $log_in
     * @param LogInForm $form
     */
    function __construct(LogIn $log_in, LogInForm $form)
    {
        $this->logIn = $log_in;
        $this->form = $form;
    }

    public function get()
    {
        $user = $this->request->getAttribute('user');

        if ($user) {

            return $this->redirect(SITE_PATH . '/dashboard');
        }

        $this->render('auth/login.html.twig');
    }

    public function post()
    {
        try {

            $body = $this->request->getParsedBody();

            $id = null;
            $name = '';
            $email = '';

            if (!$this->form->validate($body)) {
                throw new \Exception();
            }

            $this->form->setCommandClass(LogInCommand::class);
            $command = $this->form->getTransfer();

            $session_key = $this->logIn->execute($command);

            return $this
                ->response
                ->withStatus(302)
                ->withHeader('Location', 'dashboard');

        } catch (IncorrectCredentialsException $e) {

            $email = $command->email;

            return $this->render('auth/login.html.twig',
                array(
                    'email' => $email,
                    'form' => $this->form,
                    'error' => 'Incorrect Credentials'
                )
            );

        } catch (\Exception $e) {

            $this->render('auth/login.html.twig',
                array(
                    'form' => $this->form,
                    'errors' => $this->form->errors()
                )
            );
        }
    }
}
