<?php

namespace App\Controller\User;

use App\Controller\WebController;
use App\Application\User\RegisterUser\RegisterUser;
use App\Application\User\RegisterUser\RegisterUserCommand;
use App\Form\User\RegisterForm;
use App\Application\User\RegisterUser\UserExistsException;

class RegisterUserController extends WebController
{
    /**
     * @var RegisterUser
     */
    private $registerUser;

    /**
     * @var RegisterForm
     */
    private $form;

    /**
     * Creates a new RegisterUser controller.
     *
     * @param RegisterUser $register_user
     * @param RegisterForm $form
     */
    function __construct(RegisterUser $register_user, RegisterForm $form)
    {
        $this->registerUser = $register_user;
        $this->form = $form;
    }

    public function get()
    {
        $this->render('user/register.html.twig');
    }

    public function post()
    {
        try {

            $body = $this->request->getParsedBody();

            $name = '';
            $email = '';

            if (!$this->form->validate($body)) {
                throw new \Exception();
            }

            $this->form->setCommandClass(RegisterUserCommand::class);
            $command = $this->form->getTransfer();

            $this->registerUser->execute($command);

            return $this
                ->response
                ->withStatus(302)
                ->withHeader('Location', SITE_PATH);

        } catch (UserExistsException $e) {

            $email = $command->email;

            return $this->render('user/register.html.twig',
                array(
                    'email' => $email,
                    'form' => $this->form,
                    'error' => 'User Already Exists. Please Log In'
                )
            );

        } catch (\Exception $e) {

            $this->render('user/register.html.twig',
                array(
                    'form' => $this->form,
                    'errors' => $this->form->errors()
                )
            );
        }
    }
}
