<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    private const COLUMN_MAPPING = [
        //csv_key => db_key

        //Employee
        'Emp ID' => 'id',
        'User Name' => 'username',
        'Name Prefix' => 'prefix', // Maybe store together with firstname, could be too much work for little gain
        'First Name' => 'firstname',
        'Middle Initial' => 'middle_initial',
        'Last Name' => 'lastname',
        'Gender' => 'gender',
        'E Mail' => 'email',
        'Date of Birth' => 'date_of_birth', // Maybe store together with time
        'Time of Birth' => 'time_of_birth',
        'Age in Yrs.' => null,
        'Date of Joining' => 'date_of_joining',
        'Age in Company (Years)' => null,
        'Phone No. ' => 'phone_number',

        //Address
        'Place Name' => 'place_name', // = City??
        'County' => 'country',
        'City' => 'city',
        'Zip' => 'zip',
        'Region' => 'region',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return (new EmployeeResource(Employee::all()))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->parseCsvRequest($request);
        foreach ($data as $employee) {
            Employee::create([
                $employee
            ]);
        }
        return (new EmployeeResource($request))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return (new EmployeeResource($employee))
                ->response()
                ->setStatusCode(200);
        }

        return response()->json(['error' => 'Resource not found'], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

        $employee = Employee::find($id);

        if ($employee) {
            $employee->delete();
            return response()->json(null, 204);
        }

        return response()->json(['error' => 'Resource not found'], 404);
    }

    private function parseCsvRequest(Request $request, string $separator = ",", string $lineBreak = "\n"): array
    {
        $csvData = [];
        $header = [];

        $data = str_getcsv($request->input(0), $lineBreak);

        foreach ($data as $row) {
            if (empty($header)) {
                $header = $this->translateCsvToDatabaseColumn(str_getcsv($row, $separator));
                continue;
            }
            $array = str_getcsv($row, $separator);
            $csvData[] = array_combine($header, $array);
        }

        return $csvData;
    }

    function translateCsvToDatabaseColumn(array $csvHeaders) : array
    {
        $translatedHeaders = [];

        foreach ($csvHeaders as $key => $header){
            $translatedHeaders[$key] = self::COLUMN_MAPPING[$header];
        }
        return $translatedHeaders;
    }
}
