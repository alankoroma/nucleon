<?php

namespace App\Controller\Dashboard;

use App\Controller\WebController;
use App\Application\DoesNotExistException;

class DashboardController extends WebController
{
    public function get()
    {
        $user = $this->request->getAttribute('user');

        try {

            if ($user) {

                return $this->render('dashboard/index.html.twig',
                    array(
                        'user_id' => $user->id,
                        'user' => $user,
                    )
                );
            }

            return $this->redirect(SITE_PATH);

        } catch (DoesNotExistException $e) {

            return $this->render('dashboard/index.html.twig');
        }
    }
}
