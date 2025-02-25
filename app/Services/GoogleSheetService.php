<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->spreadsheetId = env('GOOGLE_SHEET_ID');

        $this->client = new Client();
        $this->client->setAuthConfig(public_path(env('GOOGLE_CREDENTIALS_PATH')));
        $this->client->addScope(Sheets::SPREADSHEETS);

        $this->service = new Sheets($this->client);
    }

    // Data Insert
    public function insertData($data)
    {
        $range = 'Sheet1!A:C'; // Column A, B, C
        $body = new Sheets\ValueRange([
            'values' => [$data]
        ]);

        $params = ['valueInputOption' => 'RAW'];
        $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
    }

    // Data Fetch
    public function fetchData()
    {
        $range = 'Sheet1!A:C';
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues();
    }

    // Row Delete
    public function deleteRow($rowIndex)
    {
        $requests = [
            new Sheets\Request([
                'deleteDimension' => [
                    'range' => [
                        'sheetId' => 0,
                        'dimension' => 'ROWS',
                        'startIndex' => $rowIndex,
                        'endIndex' => $rowIndex + 1
                    ]
                ]
            ])
        ];

        $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }
}
