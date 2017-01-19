<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Standard;
use App\Exceptions\StateTransitionNotAllowed;

class StandardsController extends Controller
{
    public function show($id)
    {
        $standard = Standard::proposed()->findOrFail($id);

        return view('standards.show', ['standard' => $standard]);
    }

    public function propose($id)
    {
        $standard = Standard::findOrFail($id);

        try {
            $standard->propose();
        } catch (StateTransitionNotAllowed $e) {
            return response('', 409);
        }
        return response('', 204);
    }

    public function approve($id)
    {
        $standard = Standard::findOrFail($id);

        try {
            $standard->approve();
        } catch (StateTransitionNotAllowed $e) {
            return response('', 409);
        }
        return response('', 204);
    }

    public function reject($id)
    {
        $standard = Standard::findOrFail($id);

        try {
            $standard->reject();
        } catch (StateTransitionNotAllowed $e) {
            return response('', 409);
        }
        return response('', 204);
    }
}
