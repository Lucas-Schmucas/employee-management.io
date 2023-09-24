<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Address;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $responseData = $this->handleCsvRequest($request);
        return (new EmployeeCollection($responseData))
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

    private function handleCsvRequest(Request $request, string $separator = ",", string $lineBreak = "\n"): array
    {
        $responseData = [];

        $csvRows = str_getcsv($request->input('file'), $lineBreak);
        $csvHeaders = (str_getcsv($csvRows[0], $separator));
        $columnNames = $this->translateHeadersToColumnNames($csvHeaders);

        $addressFillables = (new Address)->getFillable();

        for ($i = 1; $i < count($csvRows); $i++) {
            $data = str_getcsv($csvRows[$i], $separator);

            $storageData = array_combine($columnNames, $data);

            $this->storeCsvData($storageData, $addressFillables);

            $responseData[] = array_combine($csvHeaders, $data);
        }
        return $responseData;
    }

    private function translateHeadersToColumnNames(array $csvHeaders): array
    {
        $columnNames = [];

        foreach ($csvHeaders as $key => $header) {
            $columnNames[$key] = self::COLUMN_MAPPING[$header];
        }
        return $columnNames;
    }

    private function storeCsvData(array $storageRow, array $addressFillables)
    {
        $addressData = array_intersect_key($storageRow, array_flip($addressFillables));
        $employeeData = array_diff_key($storageRow, $addressData);

        DB::transaction(function () use ($employeeData, $addressData) {
            $employee = Employee::create($employeeData);
            $address = new Address($addressData);
            $employee->address()->save($address);
        });
    }
}
