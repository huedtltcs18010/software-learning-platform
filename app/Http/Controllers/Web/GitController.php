<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class GitController extends BaseController
{
    // chown -R www-data:www-data /var/www/
    // su - www-data -s /bin/bash -c "ssh-keygen -t rsa -b 2048"
    // su www-data -s /usr/bin/git pull
    public function index(Request $request)
    {
        $requestToken = $request->header('X-Gitlab-Token');
        if (empty($requestToken)) {
            return response()->json(['msg' => '', 'Invalid secret token!']);
        }
        $secretToken = getenv('GITLAB_SECRECT');
        if ($requestToken != $secretToken) {
            return response()->json(['msg' => '', 'Invalid secret token!']);
        }
        exec(public_path('../pull.sh'));
        return response()->json(['msg' => '', 'Pulled!']);
    }
}
