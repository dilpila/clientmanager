@extends('pila.client.layout.base')

@section('content')
    <div class="content-wrapper client">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Clients
                <small>Create</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Clients</a></li>
                <li class="active">Create</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create New Client</h3>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(Session::has('flash_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
                        @endif
                        <form role="form" id="clientForm" action=" {{ URL::route('pila::clients::save') }}" method="post" novalidate>

                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="Name">{{ trans('clientmanager::clients.name') }} <div class="error"></div></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Enter Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="Gender">{{ trans('clientmanager::clients.gender') }} <div class="error"></div></label>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="gender" id="gender" value="male" checked="">
                                            Male
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="gender" id="gender" value="female">
                                            Female
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="gender" id="gender" value="other">
                                            Other
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('clientmanager::clients.phone') }} <div class="error"></div></label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" class="form-control" name="phone" required
                                               data-inputmask="'mask': ['999-9999-999999', '+099 9999 999999']"
                                               data-mask="">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="Email">{{ trans('clientmanager::clients.email') }} <div class="error"></div></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="Enter Email" required>
                                </div>

                                <div class="form-group">
                                    <label for="Address">{{ trans('clientmanager::clients.address') }} <div class="error"></div></label>
                                    <input type="text" class="form-control" id="address" name="address"
                                           placeholder="Enter Address" required>
                                </div>

                                <div class="form-group">
                                    <label for="Nationality">{{ trans('clientmanager::clients.nationality') }} <div class="error"></div></label>
                                    <input type="text" class="form-control" id="nationality" name="nationality"
                                           placeholder="Enter Nationality" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('clientmanager::clients.dob') }} <div class="error"></div></label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                               placeholder="Enter Date of birth" data-inputmask="'alias': 'mm/dd/yyyy'"
                                               data-mask required>
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="Education">{{ trans('clientmanager::clients.education') }} <div class="error"></div></label>
                                    <input type="text" class="form-control" id="education" name="education"
                                           placeholder="Enter Education Background" required>
                                </div>

                                <div class="form-group">
                                    <label for="prefferedmode">{{ trans('clientmanager::clients.preffered') }} <div class="error"></div></label>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="preffered" id="preffered-1" value="email"
                                                   checked="">
                                            Email
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="preffered" id="preffered-2" value="phone">
                                            Phone
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="preffered" id="preffered-3" value="none">
                                            None
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Submit" name="submitBtn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop

@section('foot_script')
    @parent
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>
    <script src="{{ URL::asset('') }}assets/bjsmasth/client/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="{{ URL::asset('') }}assets/bjsmasth/client/js/client.js"></script>
@stop