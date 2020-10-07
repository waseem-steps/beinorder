@extends('layouts.master-ar')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>إدارة الفروع</small></h3>
            </div>

        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>الاسم</th>
                                                <th>الايميل</th>
                                                <th>تاريخ الإنشاء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($admins as $admin)
                                            <tr>
                                                <td></td>
                                                <td><a data-toggle="tooltip" data-placement="bottom" title="تعديل"
                                                        href="{{ Route('branch-admin.edit-ar',$admin->id) }}"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a onclick="return confirm('هل أنت متأكد من حذف العنصر؟?');"
                                                        data-toggle="tooltip" data-placement="bottom" title="حذف"
                                                        href="{{ Route('branch-admin.delete-ar',$admin->id) }}"><i
                                                            class="fa fa-remove"></i></a></td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->created_at }}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
