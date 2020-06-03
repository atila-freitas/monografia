@extends('layout.page2')


@section('content')


    @foreach($centros as $centro)
        <a href="{{route('ind.centerDetails',$centro->id)}}">
        <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-blue-active">
            <span class="info-box-icon"><i class="fa fa-graduation-cap"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{ $centro->nome }}</span>
                <span class="info-box-number">{{ $centro->sigla }}</span>

                <div class="progress">
                    <div class="progress-bar" ></div>
                </div>
                <span class="progress-description">
                UECE
              </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        </a>

    @endforeach

@endsection