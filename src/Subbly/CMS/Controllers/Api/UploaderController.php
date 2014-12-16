<?php

namespace Subbly\CMS\Controllers\Api;

use Illuminate\Support\Facades\Input;

use Subbly\Subbly;

class UploaderController extends BaseController
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('@processAuthentication');
    }

    /**
     * Perform file(s) upload to the server
     *
     * @route POST /api/v1/uploader
     * @authentication required
     */
    public function store()
    {
        // TODO: to clean

        if (!Input::hasFile('file')) {
            return $this->jsonErrorResponse('"file" is required.');
        }

        Subbly::events()->fire('subbly.upload:creating', array());

        $file      = Input::file('file');
        $file_type = Input::get('file_type', 'product_image');
        
        $destination = app_upload( $file_type );
        $publicPath  = public_upload( $file_type );
        $filename    = sprintf('%s.%s',
            uniqid(),
            $file->getClientOriginalExtension()
        );

        $inputFile = Input::all();
        
        unset( $inputFile['file'] );

        $fileData = array(
          'file' => array_merge( $inputFile, array(
              'filename'  => $filename
            , 'file_path' => sprintf( '%s/%s', $publicPath, $filename )
          ))
        );

        $uploadSuccess = $file->move( $destination, $filename );

        if( $uploadSuccess )
        {
          Subbly::events()->fire( 'subbly.upload:created', $fileData );
        }
        else
        {
          Subbly::events()->fire( 'subbly.upload:error', $fileData );          
        }

        return $this->jsonResponse( $fileData ,
        array(
            'status' => array(
                'code'    => 201,
                'message' => 'Upload done',
            ),
        ));
    }
}
