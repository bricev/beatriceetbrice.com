<?php

namespace Wedding\Application\Http;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Wedding\Application\Http\Controller\ExceptionController;
use Wedding\Domain\Guestlist;
use Wedding\Domain\Notebook;

final class Kernel extends HttpKernel
{
    public function __construct(Guestlist $guestList, Notebook $notebook)
    {
        $matcher = new UrlMatcher(new Routing($guestList, $notebook), new RequestContext);

        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new ExceptionListener([ExceptionController::class, 'handle']));
        $dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack));
        $dispatcher->addListener(KernelEvents::REQUEST, [$this, 'onKernelRequest']);
        $dispatcher->addListener(KernelEvents::RESPONSE, [$this, 'onKernelResponse']);

        parent::__construct($dispatcher, new ControllerResolver, new RequestStack, new ArgumentResolver);
    }

    /**
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Don't do anything if it's not the master request.
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();
        if ('OPTIONS' !== $request->getMethod()) {
            return;
        }

        // perform preflight checks
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        $response->headers->set('Access-Control-Max-Age', 3600);

        $event->setResponse($response);
    }

    /**
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');

        $event->setResponse($response);
    }
}
