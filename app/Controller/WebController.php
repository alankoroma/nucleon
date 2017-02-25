<?php

namespace App\Controller;

use Slim\Views\PhpRenderer;

class WebController extends BaseController
{
    /**
     * @var PhpRenderer
     */
    private $view;

    /**
     * @var \ArrayAccess
     */
    private $flashStorage;

    /**
     * Renders the specified template with the provided
     * data.
     *
     * @param  string $template
     * @param  array  $data
     * @return ResponseInterface
     */
    protected function render($template, array $data = [])
    {
        $data = array_merge($data);
        return $this->view->render(
            $this->response,
            $template,
            $data
        );
    }

    /**
     * Returns the response with a 302 status and
     * location header.
     *
     * @param  string $location
     * @return ResponseInterface
     */
    protected function redirect($location)
    {
        return $this
            ->response
            ->withStatus(302)
            ->withHeader('Location', $location);
    }

    /**
     * Sets the controller's view renderer.
     *
     * @param  PhpRenderer $view
     * @return null
     */
    public function setView(PhpRenderer $view)
    {
        $this->view = $view;
    }
}
