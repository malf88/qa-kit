@extends('adminlte::page')

@section('title', 'QAKit - Gráfico de Gant')
@section('plugins.FrappeGant', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-10">Gráfico de Gant</h1>

    </div>

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <svg id="gantt"></svg>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        var tasks = [
            @foreach($projetos as $projeto)
            {
                id: '{{$projeto->id}}',
                name: '{{$projeto->nome}}',
                start: '{{$projeto->inicio->format('Y-m-d')}}',
                end: '{{$projeto->termino->format('Y-m-d')}}'
            },
            @endforeach

        ]
        var gantt = new Gantt("#gantt", tasks, {
            view_mode: 'Month',
            date_format: 'DD-MM-YYYY',
            language: 'ptBr',
            custom_popup_html: null,
            step: 24
        });
    </script>
@stop
