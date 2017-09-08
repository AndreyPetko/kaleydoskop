@extends('admin.layouts.admin')


@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Форма обновления описания по умолчанию</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="/admin/update-description" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <textarea name="description" id="" cols="30" rows="10"
                                      class="form-control">{!! $description !!}</textarea>
                            <input type="submit" class="form-control" style="margin-top: 10px" value="Обновить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop