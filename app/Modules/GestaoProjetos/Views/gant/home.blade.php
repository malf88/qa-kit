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
            {
                id: 'Task 1',
                name: 'Redesign website',
                start: '2016-12-28',
                end: '2016-12-31',
                progress: 20,
                dependencies: 'Task 2, Task 3'
            },
        ]
        var gantt = new Gantt("#gantt", tasks);
    </script>
@stop
