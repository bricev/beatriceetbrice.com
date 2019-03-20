<?php

namespace Wedding\Application\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Wedding\Domain\Guestlist;
use Wedding\Domain\ValueObject\Identifier;

final class GetGroupController
{
    /** @var Guestlist */
    private $guestlist;

    /**
     *
     * @param Guestlist $guestlist
     */
    public function __construct(Guestlist $guestlist)
    {
        $this->guestlist = $guestlist;
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        if (is_null($request->get('identifier'))) {
            throw new BadRequestHttpException('Missing identifier');
        }

        $identifier = new Identifier($request->get('identifier'));
        if (!$group = $this->guestlist->findGroup($identifier)) {
            throw new BadRequestHttpException('Unknown group');
        }

        $guests = [];
        foreach ($group->getGuests() as $guest) {
            $guests[] = $guest;
        }

        return JsonResponse::create($group);
    }
}
