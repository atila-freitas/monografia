@extends('layout.page2')


@section('content')

    <h1> Comparar </h1>

    <div class="content box box-default" >

        <h2> Centros </h2>

        <div class="row col-md-12">
            <div  class="col-sm-4">
                <select id="centro1" class="form-control col-sm-4">
                    @foreach($centros as $centro)
                        <option>{{$centro->sigla}}</option>
                    @endforeach
                </select>
            </div>

            <div  class="col-sm-4">
                <select id="centro2" class="form-control col-sm-4">
                    @foreach($centros as $centro)
                        <option>{{ $centro->sigla}}</option>
                    @endforeach
                </select>
            </div>

            <div  id="comparaCentro" class="col-sm-2"><button type="button" class="btn btn-block btn-primary col-sm-4">Comparar Centros</button></div>


        </div>

        <br>

        <h2> Professores </h2>

        <div class="row col-md-12">
            <div  class="col-sm-4">
                <select id="professor1" class="form-control col-sm-4">
                    @foreach($professores as $professor)
                    <option>{{ $professor->nome_completo }}</option>
                    @endforeach
                </select>
            </div>

            <div  class="col-sm-4">
                <select id="professor2" class="form-control col-sm-4">
                    @foreach($professores as $professor)
                        <option>{{ $professor->nome_completo }}</option>
                    @endforeach
                </select>
            </div>

            <div  id="comparaProfessor" class="col-sm-2"><button type="button" class="btn btn-block btn-primary col-sm-4">Comparar Professores</button></div>


        </div>


    </div>


@endsection

@section('js')
    <script>

        $("#comparaCentro").click(function() {
            var e = document.getElementById("centro1");
            var strCentro1 = e.options[e.selectedIndex].value;
            var e = document.getElementById("centro2");
            var strCentro2 = e.options[e.selectedIndex].value;
            window.location.href="compararCentros/" +strCentro1 + "/" + strCentro2;

        });


        $("#comparaProfessor").click(function() {
            var e = document.getElementById("professor1");
            var strProf1 = e.options[e.selectedIndex].value;
            var e = document.getElementById("professor2");
            var strProf2 = e.options[e.selectedIndex].value;
            window.location.href="compararProfessores/" +strProf1 + "/" + strProf2;

        });




    </script>

@endsection