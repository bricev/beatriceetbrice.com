<?php

namespace Wedding\Infrastructure\Google;

abstract class GoogleSpreadsheet
{
    const TRUE = 'OUI';
    const FALSE = 'NON';
    const RANGE_GUEST = 'Invités!A2:F';
    const RANGE_GROUP = 'Groupes!A2:D';
    const RANGE_RSVP  = 'Réponses!A2:I';

    /** @var string */
    protected $spreadSheetId;

    /** @var \Google_Service_Sheets */
    protected $service;

    /**
     *
     * @param \Google_Client $client
     */
    public function __construct(\Google_Client $client, $spreadSheetId)
    {
        $this->service = new \Google_Service_Sheets($client);
        $this->spreadSheetId = $spreadSheetId;
    }
}
