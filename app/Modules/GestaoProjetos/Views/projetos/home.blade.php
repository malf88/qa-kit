@extends('adminlte::page')

@section('title', 'QAKit - Gestão de Projetos - Projetos')
@section('plugins.FrappeGant', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-10">Projetos</h1>

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
                end: '{{$projeto->termino->format('Y-m-d')}}',
                progress: {{ $projeto->andamento }},
                teste: 'teste'
            },
            @endforeach

        ]
        var gantt = new Gantt("#gantt", tasks, {
            view_mode: 'Month',
            date_format: 'DD-MM-YYYY',
            language: 'ptBr',
            bar_height: 50,
            step: 24,
            on_click: function (task) {
                console.log(task);
            },
            on_date_change: function(task, start, end) {
                console.log(task, start, end);
            },
            custom_popup_html: function(task) {
                // the task object will contain the updated
                // dates and progress value
                const end_date = moment(task.end).format('DD/MM/YYYY');

                return `
                    <div style="width:45em; height: max-content;">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                  <div class="col-md-12">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <h5>${task.name}</h5>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                          <p>Estimativa de término ${end_date}</p>
                                        </div>
                                        <div class="col-md-6">
                                          <p>${parseFloat(task.progress).toFixed(2)}% completo!</p>
                                        </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                    </div>
                  `;
            }
        });
    </script>
@stop
