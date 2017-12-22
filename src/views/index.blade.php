@extends('pila.client.layout.base')

@section('head_style')
    @parent

    <link rel="stylesheet" href="assets/pila/client/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="assets/pila/client/css/clients.css">
@stop

@section('head_script')
    @parent

    <script>
        var pila = {};
    </script>
@stop
@section('content')
    <div class="content-wrapper clients">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Clients
                <small>List</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Clients</a></li>
                <li><a href="#">Lists</a></li>
                <li class="active">All</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Client list</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="selectall"></th>
                                    <th>{{ trans('clientmanager::clients.name') }}</th>
                                    <th>{{ trans('clientmanager::clients.gender') }}</th>
                                    <th>{{ trans('clientmanager::clients.phone') }}</th>
                                    <th>{{ trans('clientmanager::clients.email') }}</th>
                                    <th>{{ trans('clientmanager::clients.address') }}</th>
                                    <th>{{ trans('clientmanager::clients.education') }}</th>
                                    <th>{{ trans('clientmanager::clients.dob') }}</th>
                                    <th>{{ trans('clientmanager::clients.nationality') }}</th>
                                    <th>{{ trans('clientmanager::clients.preffered') }}</th>
                                    <th>{{ trans('clientmanager::clients.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@stop

@section('foot_script')
    @parent
    <script src="assets/pila/client/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/pila/client/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="assets/pila/client/js/clients.js"></script>

    <script>
        pila.clients = {
            datatables: {
                ajax: {
                    url: '{{ URL::route('pila::clients::list') }}'
                }
            }
        }
    </script>
@stop