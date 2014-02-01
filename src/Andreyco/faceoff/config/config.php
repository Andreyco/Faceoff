<?php

return array(
    /**
     * Initialize a Facebook Application.
     *
     * The configuration:
     * - appId: the application ID
     * - secret: the application secret
     * - fileUpload: (optional) boolean indicating if file uploads are enabled
     * - allowSignedRequest: (optional) boolean indicating if signed_request is
     *                       allowed in query parameters or POST body.  Should be
     *                       false for non-canvas apps.  Defaults to true.
     */

    'init'  => array(
        'appId' => null,
        'secret' => null,
        'fileUpload' => false,
        'allowSignedRequest' => true,
        'trustForwarded' => false,
    ),

);
