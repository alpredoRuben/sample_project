@extends('layouts.web')


@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Custom responsive table </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-9 m-b-xs">
                            <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                <label class="btn btn-sm btn-white"> <input type="radio" id="option1"
                                        name="options"> Day </label>
                                <label class="btn btn-sm btn-white active"> <input type="radio" id="option2"
                                        name="options"> Week </label>
                                <label class="btn btn-sm btn-white"> <input type="radio" id="option3"
                                        name="options"> Month </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="button">Go!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project </th>
                                    <th>Name </th>
                                    <th>Phone </th>
                                    <th>Company </th>
                                    <th>Completed </th>
                                    <th>Task</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Project <small>This is example of project</small></td>
                                    <td>Patrick Smith</td>
                                    <td>0800 051213</td>
                                    <td>Inceptos Hymenaeos Ltd</td>
                                    <td><span class="pie">0.52/1.561</span></td>
                                    <td>20%</td>
                                    <td>Jul 14, 2013</td>
                                    <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>


</div>
@endsection
