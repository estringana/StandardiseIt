<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Standard;
use App\Exceptions\StateTransitionNotAllowed;
use App\Standard\StatusesDecorator;
use App\Standard\StatusDecorableInterface;

class StandardsController extends Controller
{
    public function show($id)
    {
        $decoratedStandard = Standard::proposed()->findOrFail($id);

        return view('standards.show', ['standard' => $decoratedStandard]);
    }

    protected function getOrderById($id): Standard
    {
        return Standard::findOrFail($id);
    }

    protected function getDecoratedOrderById($id): StatusDecorableInterface
    {
        return new StatusesDecorator(
            $this->getOrderById($id)
        );
    }

    public function propose($id)
    {
        $decoratedStandard = $this->getDecoratedOrderById($id);

        try {
            $decoratedStandard->propose();
        } catch (StateTransitionNotAllowed $e) {
            return response('', 409);
        }
        return response('', 204);
    }

    public function approve($id)
    {
        $decoratedStandard = $this->getDecoratedOrderById($id);

        try {
            $decoratedStandard->approve();
        } catch (StateTransitionNotAllowed $e) {
            return response('', 409);
        }
        return response('', 204);
    }

    public function reject($id)
    {
        $decoratedStandard = $this->getDecoratedOrderById($id);

        try {
            $decoratedStandard->reject();
        } catch (StateTransitionNotAllowed $e) {
            return response('', 409);
        }
        return response('', 204);
    }
}
