<?php

namespace Wedding\Infrastructure\Google;

use Wedding\Domain\Guestlist;
use Wedding\Domain\Rsvp;
use Wedding\Domain\Notebook;
use Wedding\Domain\ValueObject\Identifier;
use Wedding\Domain\ValueObject\Name;

final class NotebookSpreadsheet extends GoogleSpreadsheet implements Notebook
{
    /**
     *
     * @param Rsvp $rsvp
     */
    public function register(Rsvp $rsvp)
    {
        // Delete previous RSVP rows from sheet
        $index = 1; // starts at 1, will be incremented first to match second row (skipping the header row)
        foreach ($this->getRows() as $row) {
            $index++;

            if ($row[0] !== (string) $rsvp->getGroupIdentifier()) {
                continue;
            }

            $request = new \Google_Service_Sheets_Request(
                ['deleteDimension' =>  [
                    'range' => [
                        'sheetId'   => 1439469953,
                        'dimension' => 'ROWS',
                        'startIndex'=> $index - 1,
                        'endIndex'  => $index,
                    ]
                ]]
            );

            $batchRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
                    'requests' => [
                        $request,
                    ]
                ]
            );

            $this
                ->service
                ->spreadsheets
                ->batchUpdate('1qQcBxpIjjHCQpR0Wn3VEjSD3TFOtBDsd8aOfwzJx0Eg', $batchRequest)
            ;
        }

        // Save the new RSVP
        $this
            ->service
            ->spreadsheets_values
            ->append(
                $this->spreadSheetId,
                self::RANGE_RSVP,
                new \Google_Service_Sheets_ValueRange([
                    'values' => [
                        array_values($rsvp->__toArray())
                    ],
                ]),
                [
                    'valueInputOption' => 'RAW',
                    'insertDataOption' => 'INSERT_ROWS',
                ]
            )
        ;
    }

    /**
     *
     * @param Identifier $groupId
     * @param Guestlist  $guestlist
     * @return null|Rsvp
     * @throws \Exception
     */
    public function find(Identifier $groupId, Guestlist $guestlist): ?Rsvp
    {
        $entries = $this
            ->service
            ->spreadsheets_values
            ->get($this->spreadSheetId, self::RANGE_RSVP)
            ->getValues();

        if (is_null($entries)) {
            return null;
        }

        foreach ($entries as $entry) {
            list(
                $groupIdentifier,
                $comingGuests,
                $needBabysitter,
                $needDriver,
                $hasAllergy,
                $favorite60sTube,
                $favorite70sTube,
                $favorite80sTube,
                $favoriteContemporaryTube
            ) = $entry;

            if ((string) $groupId !== $groupIdentifier) {
                continue;
            }

            $guests = [];
            foreach (array_filter(explode(PHP_EOL, $comingGuests)) as $guestName) {
                if (!$guest = $guestlist->findGuest(new Name($guestName))) {
                    throw new \Exception(sprintf('Impossible to find "%s" in the guestlist', $guestName));
                }

                $guests[] = $guest;
            }

            return new Rsvp(
                $identifier = new Identifier($entry[0]),
                $guests,
                (bool) preg_match(sprintf('/%s/', self::TRUE), $needBabysitter),
                (bool) preg_match(sprintf('/%s/', self::TRUE), $needDriver),
                (bool) preg_match(sprintf('/%s/', self::TRUE), $hasAllergy),
                (string) $favorite60sTube,
                (string) $favorite70sTube,
                (string) $favorite80sTube,
                (string) $favoriteContemporaryTube
            );
        }

        return null;
    }

    /**
     *
     * @return array RSVP rows from sheet
     */
    private function getRows(): array
    {
        // List all RSVP rows from sheet
        $rows = $this
            ->service
            ->spreadsheets_values
            ->get($this->spreadSheetId, self::RANGE_RSVP)
            ->getValues();

        return is_null($rows) ? [] : $rows;
    }
}
