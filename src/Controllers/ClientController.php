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

    protected $csvPath;

    public function __construct()
    {
        $this->csvPath = resource_path('pila/client/csv/clients.csv');
    }

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
        $validator = $this->getValidation($request);

        if ($validator->fails()) {
            return redirect('clients/create')
                ->withErrors($validator)
                ->withInput();
        }

        $oldData = $this->getClients();
        $records = $oldData['records'];

        $writer = CsvWriter::create($this->csvPath);

        $input = Input::except('_token', 'submitBtn');

        if ($id) {
            $clients = $oldData['clients'];

            foreach ($clients as $key => $client) {
                if ($key == $id) {
                    foreach ($records as $k => $v) {
                        if ($v[0] == $id) {
                            unset($records[$k]);
                            break;
                        }
                    }
                    $data = implode('/', $input);
                    $writer->writeLine([$id, $data]);
                    break;
                }
            }
        } else {
            $data = implode('/', $input);
            $writer->writeLine([time(), $data]);
        }

        $writer->writeAll($records);

        $writer->flush();
        $writer->close();

        Log::info('Client was successfully');
        $request->session()->flash('flash_message', 'Client has been successful added!');

        return redirect('clients');
    }

    protected function getClients()
    {
        $clients = array();

        $reader = Reader::open($this->csvPath);
        $records = $reader->readAll();

        foreach ($records as $key => $record) {
            $clients[$record[0]] = explode('/', $record[1]);
            $clients[$record[0]]['id'] = $record[0];
        }

        return [
            'clients' => $clients,
            'records' => $records
        ];
    }

    /**
     * @param Request $request
     */
    public function listAll(Request $request)
    {
        if (!$request->ajax()) {
            throw new UnauthorizedHttpException('Authorized Access');
        }

        $clients = $this->getClients()['clients'];
        $total_count = count($clients);

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $clients = $this->search($clients, $request->input('search')['value']);

        $filtered_count = count($clients);

        $clients = $this->paginate($clients, $limit, $offset);


        $data = [];
        $i = 0;

        foreach ($clients as $client) {
            $data[$i]['DT_RowId'] = $client['id'];
            $data[$i]['DT_RowClass'] = $client['id'];
            $data[$i]['id'] = $client['id'];
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
            <a class="btn btn-primary" href="' . route('pila::clients::edit', ['id' => $client['id']]) . '">Edit</i></a>
            <a class="btn btn-danger" href="' . route('pila::clients::delete', ['id' => $client['id']]) . '">Delete</a>
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

    public function edit(Request $request, $id)
    {
        $records = $this->getClients()['clients'];

        $data = [];

        foreach ($records as $record) {
            if ($record['id'] == $id) {
                $data = $record;
            }
        }

        return view('pila.client.edit', ['client' => $data]);
    }

    public function delete(Request $request, $id)
    {
        $oldData = $this->getClients();
        $records = $oldData['records'];

        $writer = CsvWriter::create($this->csvPath);

        $clients = $oldData['clients'];

        foreach ($clients as $key => $client) {
            if ($key == $id) {
                foreach ($records as $k => $v) {
                    if ($v[0] == $id) {
                        unset($records[$k]);
                        break;
                    }
                }
                break;
            }
        }

        $writer->writeAll($records);

        $writer->flush();
        $writer->close();

        Log::info('Client was successfully deleted');
        $request->session()->flash('flash_message', 'Client has been successful deleted!');

        return redirect('clients');
    }

    protected function getValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'phone' => ['required', 'regex:/^([0-9]{3})-([0-9]{4})-([0-9]{6})$/'],
            'email' => 'required|email',
            'address' => 'required',
            'nationality' => 'required',
            'dob' => 'required|date',
            'education' => 'required',
            'preffered' => 'required'
        ]);
    }
}