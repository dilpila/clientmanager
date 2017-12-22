<?php

namespace Pila\ClientManager\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use Wilgucki\Csv\Facades\Reader;
use Wilgucki\Csv\Facades\Writer as CsvWriter;

class ClientController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    public function index(Request $request)
    {
        return view('pila.client.index');
    }

    public function create()
    {
        return view('pila.client.add');
    }

    /**
     * @param Request $request
     * @param null $id if not null id it will update the records TODO
     */
    public function save(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'phone' => ['required', 'regex:/^([0-9]{3})-([0-9]{4})-([0-9]{6})$/'],
            'email' => 'required|email',
            'address' => 'required',
            'nationality' => 'required',
            'dob' => 'required',
            'education' => 'required',
            'preffered' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('clients/create')
                ->withErrors($validator)
                ->withInput();
        }

        $csvPath = resource_path('pila/client/csv/clients.csv');

        $reader = Reader::open($csvPath);
        $records = $reader->readAll();

        $count = count($records);
        $writer = CsvWriter::create($csvPath);

        $input = Input::except('_token', 'submitBtn');
        $data = implode('/', $input);

        $writer->writeLine([$count + 1, $data]);
        $writer->writeAll($records);

        $writer->flush();
        $writer->close();

        Log::info('Client was successfully');
        $request->session()->flash('flash_message', 'Client has been successful added!');

        return redirect('clients/create');
    }

    /**
     * @param Request $request
     */
    public function listAll(Request $request)
    {
        if (!$request->ajax()) {
            throw new UnauthorizedHttpException('Authorized Access');
        }

        $clients = $this->getClients();
        $total_count = count($clients);

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $clients = $this->search($clients, $request->input('search')['value']);

        $filtered_count = count($clients);

        $clients = $this->paginate($clients, $limit, $offset);


        $data = [];
        $i = 0;

        foreach ($clients as $key => $client) {
            $data[$i]['DT_RowId'] = $key;
            $data[$i]['DT_RowClass'] = "$key";
            $data[$i]['id'] = $key;
            $data[$i]['name'] = $client[0];
            $data[$i]['gender'] = $client[1];
            $data[$i]['phone'] = $client[2];
            $data[$i]['email'] = $client[3];
            $data[$i]['education'] = $client[4];
            $data[$i]['address'] = $client[5];
            $data[$i]['nationality'] = $client[6];
            $data[$i]['dob'] = $client[7];
            $data[$i]['preffered'] = $client[8];
            $data[$i]['actions'] = '<div class="btn-group">
            <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
            <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
            <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
        </div>';

            $i++;
        }

        return json_encode(array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total_count,
            'recordsFiltered' => $filtered_count,
            'data' => $data,
        ));
    }

    protected function getClients()
    {
        $clients = array();

        $csvPath = resource_path('pila/client/csv/clients.csv');

        $reader = Reader::open($csvPath);
        $records = $reader->readAll();

        foreach ($records as $record) {
            $clients[$record[0]] = explode('/', $record[1]);
        }

        return $clients;
    }

    protected function getLimit(Request $request)
    {
        return min(100, $request->query->get('length'));
    }

    protected function getOffset(Request $request)
    {
        return max(0, $request->query->get('start'));
    }

    protected function search($array, $serach_key)
    {
        $result = array();

        if (empty($serach_key)) {
            return $array;
        }

        foreach ($array as $key => $value) {
            foreach ($value as $v) {
                if (mb_stripos($v, $serach_key) !== false) {
                    $result[] = $value;
                    break;
                }
            }
        }

        return $result;
    }

    protected function paginate($array, $limit, $offset)
    {
        return array_slice($array, $offset, $limit);
    }

    protected function getValidation()
    {

    }
}