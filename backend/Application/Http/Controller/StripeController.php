<?php

namespace Wedding\Application\Http\Controller;

use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class StripeController
{
    /**
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        if (is_null($request->get('amount'))) {
            throw new BadRequestHttpException('Missing amount');
        }

        if (($amount = (int) $request->get('amount') * 100) < 100) {
            throw new BadRequestHttpException('Invalid amount');
        }

        /** @var Session $session */
        $session = Session::create([
            'success_url'          => 'https://beatriceetbrice.com/#/stripe-success',
            'cancel_url'           => 'https://beatriceetbrice.com/#/stripe-cancel',
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'amount'           => $amount,
                'currency'         => 'eur',
                'quantity'         => 1,
                'name'             => 'Béatrice & Brice Honey Moon',
                'description'      => 'Don offert dans le cadre du mariage de Béatrice Menu et Brice Vercoustre afin de participer au financement du voyage de noces.',
                'images'           => ['https://beatriceetbrice.com/img/stripe_bb.jpg'],
            ]]
        ], [
            'stripe_version' => '2018-11-08; checkout_sessions_beta=v1'
        ]);

        return JsonResponse::create([
            'session' => $session->id
        ]);
    }
}
