<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetService;

class GoogleSheetController extends Controller
{
    protected $googleSheetService;

    public function __construct(GoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    // Form Submit
    public function store(Request $request)
    {
        $data = [
            $request->name,
            $request->email,
            $request->mobile
        ];

        $this->googleSheetService->insertData($data);
        return response()->json(['message' => 'Data inserted successfully']);
    }

    // Fetch Data
    public function index()
    {
        $data = $this->googleSheetService->fetchData();
        return response()->json($data);
    }

    // Delete Row
    public function destroy($rowIndex)
    {
        $this->googleSheetService->deleteRow($rowIndex);
        return response()->json(['message' => 'Row deleted successfully']);
    }
}
