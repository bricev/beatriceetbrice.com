<?php

namespace Wedding\Application\Http;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Wedding\Application\Http\Controller\GetGroupController;
use Wedding\Application\Http\Controller\GetRsvpController;
use Wedding\Application\Http\Controller\PostRsvpController;
use Wedding\Application\Http\Controller\StripeController;
use Wedding\Domain\Guestlist;
use Wedding\Domain\Notebook;

final class Routing extends RouteCollection
{
    public function __construct(Guestlist $guestList, Notebook $notebook)
    {
        $this->add('get_group', new Route('/api/group/{identifier}', [
            '_controller' => [new GetGroupController($guestList), 'handle']
        ]));

        $this->add('get_rsvp', new Route('/api/rsvp/{identifier}', [
            '_controller' => [new GetRsvpController($guestList, $notebook), 'handle']
        ]));

        $this->add('post_rsvp', new Route('/api/rsvp', [
            '_controller' => [new PostRsvpController($guestList, $notebook), 'handle']
        ]));

        $this->add('stripe', new Route('/api/stripe/{amount}', [
            '_controller' => [new StripeController, 'handle']
        ], [
            'amount' => '[0-9]+'
        ]));
    }
}
