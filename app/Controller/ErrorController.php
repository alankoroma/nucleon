<?php

namespace App\Controller;

class ErrorController extends WebController
{
    /**
     * @var integer
     */
    private $status;

    /**
     * @var boolean
     */
    private $debugMode;

    /**
     * Creates a new error handling controller with specified
     * status code.
     *
     * @param integer $status
     */
    function __construct($status, $debug_mode)
    {
        $this->status = $status;
        $this->debugMode = $debug_mode;
    }

    public function handle()
    {
        $error_name = '';
        $error_message = '';

        if (isset($this->debugMode) && $this->debugMode == false) {

            if ((isset($_GET['error']) && $_GET['error'] == '500') ||
                (isset($this->status) && $this->status == 500)
            ) {
                $error_name = 'Internal Server Error';
                $error_message = 'This page has encountered an expected error.';
            } else {
                $error_name = 'Page Could Not Be Found';
                $error_message = 'This page does not exist.';
            }

            return $this->render('error.html.twig', array(
                'status_code' => $this->status,
                'error_name' => $error_name,
                'error_message' => $error_message
            ));
        }
    }
}
