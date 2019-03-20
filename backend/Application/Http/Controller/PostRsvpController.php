<?php

namespace Wedding\Application\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Wedding\Domain\Guestlist;
use Wedding\Domain\Notebook;
use Wedding\Domain\Rsvp;
use Wedding\Domain\ValueObject\Identifier;

final class PostRsvpController
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
        $body = json_decode($request->getContent(), true);

        if (!isset($body['identifier']) or !$identifier = new Identifier($body['identifier'])) {
            throw new BadRequestHttpException('Missing identifier');
        }

        if (!$group = $this->guestlist->findGroup($identifier)) {
            throw new BadRequestHttpException('Unknown group');
        }

        if (!isset($body['comingGuests']) or !is_array($body['comingGuests'])) {
            throw new BadRequestHttpException('Missing coming guest list');
        }

        $comingGuests = [];
        foreach ($group->getGuests() as $guest) {
            if (!in_array((string) $guest, $body['comingGuests'])) {
                continue;
            }

            $comingGuests[] = $guest;
        }

        try {
            $rsvp = new Rsvp(
                $identifier,
                $comingGuests,
                isset($body['needBabysitter'])           ?   (bool) $body['needBabysitter']           : false,
                isset($body['needDriver'])               ?   (bool) $body['needDriver']               : false,
                isset($body['hasAllergy'])               ?   (bool) $body['hasAllergy']               : false,
                isset($body['favorite60sTube'])          ? (string) $body['favorite60sTube']          : null,
                isset($body['favorite70sTube'])          ? (string) $body['favorite70sTube']          : null,
                isset($body['favorite80sTube'])          ? (string) $body['favorite80sTube']          : null,
                isset($body['favoriteContemporaryTube']) ? (string) $body['favoriteContemporaryTube'] : null
            );

            $this->notebook->register($rsvp);

        } catch (\Exception $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        return JsonResponse::create([
            'identifier' => $group->getIdentifier(),
            'status' => 'Ok',
        ]);
    }
}
