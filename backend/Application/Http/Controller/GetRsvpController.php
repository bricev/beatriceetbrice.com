<?php

namespace Wedding\Application\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Wedding\Domain\Guestlist;
use Wedding\Domain\Notebook;
use Wedding\Domain\ValueObject\Identifier;

final class GetRsvpController
{
    /** @var Guestlist */
    private $guestlist;

    /** @var  Notebook */
    private $notebook;

    /**
     *
     * @param Guestlist $guestList
     * @param Notebook $notebook
     */
    public function __construct(Guestlist $guestList, Notebook $notebook)
    {
        $this->guestlist = $guestList;
        $this->notebook = $notebook;
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

        if (is_null($group = $this->guestlist->findGroup($identifier))) {
            throw new BadRequestHttpException('Unknown code');
        }

        $rsvp = $this->notebook->find(
            $identifier,
            $this->guestlist
        );

        return JsonResponse::create([
            'group' => $group,
            'rsvp' => $rsvp,
        ]);
    }
}
