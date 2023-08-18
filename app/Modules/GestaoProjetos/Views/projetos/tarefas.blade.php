@php use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum; @endphp
@extends('adminlte::page')

@section('title', 'QAKit - Tarefas')
@section('plugins.FrappeGant', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-10">Tarefas</h1>

    </div>

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-adminlte-datatable
                        id="tarefas"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        striped>
                        @foreach($tarefas as $tarefa)
                            @if($tarefa->tarefa_id != null && $tarefa->sprint_id != null)
                                <tr @if($tarefa->status == TarefaStatusEnum::CONCLUIDA->value) class="bg-success" @endif>
                                    <td>{{ $tarefa->tarefa_id }}</td>
                                    <td>{{ $tarefa->descricao }}</td>
                                    <td>{{ $tarefa->inicio->format('d/m/Y') }}</td>
                                    <td>{{ $tarefa->termino->format('d/m/Y') }}</td>
                                    <td>{{ $tarefa->status }}</td>

                                </tr>
                            @elseif($tarefa->sprint_id)
                                <tr class="bg-info font-weight-bold">
                                    <td>{{ $tarefa->sprint_id }}</td>
                                    <td>{{ $tarefa->descricao }}</td>
                                    <td>{{ $tarefa->inicio->format('d/m/Y') }}</td>
                                    <td>{{ $tarefa->termino->format('d/m/Y') }}</td>
                                    <td></td>

                                </tr>
                            @else
                                <tr class="bg-danger">
                                    <td>{{ $tarefa->tarefa_id }}</td>
                                    <td>{{ $tarefa->descricao }}</td>
                                    <td>{{ $tarefa->inicio->format('d/m/Y') }}</td>
                                    <td>{{ $tarefa->termino->format('d/m/Y') }}</td>
                                    <td>{{ $tarefa->status }}</td>

                                </tr>
                            @endif

                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop

