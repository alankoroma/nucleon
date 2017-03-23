<?php

namespace App\Controller\User;

use App\Controller\WebController;
use App\Application\User\UpdateUser\UpdateUser;
use App\Application\User\UpdateUser\UpdateUserCommand;
use App\Form\User\UpdateForm;
use App\Application\DoesNotExistException;

class UpdateUserController extends WebController
{
    /**
     * @var UpdateUser
     */
    private $updateUser;

    /**
     * @var UpdateForm
     */
    private $form;

    /**
     * Creates a new UpdateUser controller.
     *
     * @param UpdateUser $update_user
     * @param UpdateForm $form
     */
    function __construct(UpdateUser $update_user, UpdateForm $form)
    {
        $this->updateUser = $update_user;
        $this->form = $form;
    }

    public function get()
    {
        $user = $this->request->getAttribute('user');

        if ($user) {

            try {

                $user_id = null;

                if (isset($this->segments['id'])) {

                    $user_id = $this->segments['id'];

                    if ($user_id == $user->id) {

                        $this->form->setCommandClass(UpdateUserCommand::class);
                        $command = $this->updateUser->commandFor($user_id);

                        $this->form->loadTransfer($command);
                    } else {
                        throw new DoesNotExistException();
                    }
                }

                $this->render('user/update.html.twig', array(
                    'user_id' => $user_id,
                    'user' => $user,
                    'form' => $this->form
                ));

            } catch (DoesNotExistException $e) {
                return $this->redirect(SITE_PATH . '/');
            }

        } else {

            return $this->redirect(SITE_PATH);
        }

    }

    public function post()
    {
        $user = $this->request->getAttribute('user');

        try {

            $body = $this->request->getParsedBody();

            if (!$this->form->validate($body)) {
                throw new \Exception();
            }

            $this->form->setCommandClass(UpdateUserCommand::class);
            $command = $this->form->getTransfer();

            $this->updateUser->execute($command);

            return $this
                ->response
                ->withStatus(302)
                ->withHeader('Location', SITE_PATH . '/user/update/' . $id);

        } catch (DoesNotExistException $e) {

            $email = $command->email;

            return $this->render('user/update.html.twig',
                array(
                    'email' => $email,
                    'form' => $this->form,
                    'error' => 'User Does Not Exists'
                )
            );

        } catch (\Exception $e) {

            if ($user && isset($this->segments['id'])) {
                $user_id = $this->segments['id'];
            }

            $this->render('user/update.html.twig',
                array(
                    'form' => $this->form,
                    'user_id' => $user_id,
                    'user' => $user,
                    'errors' => $this->form->errors()
                )
            );
        }
    }

}
