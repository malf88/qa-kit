@php
    use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
    use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QAKit - Tarefas')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

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
                    <div class="row">
                        <h2 class="col-md-6 text-lg">Projeto: {{ $projeto->nome }}</h2>
                        <div class="col-md-3">
                            <p>Início: {{ $projeto->inicio->format('d/m/Y') }}</p>
                            <p>Término: {{ $projeto->termino->format('d/m/Y') }}</p>
                        </div>

                    </div>
                    <hr />
                    <form method="post" action="">
                        @csrf
                        <x-adminlte-datatable
                            id="tarefas"
                            :heads="$heads"
                            :config="$config"
                            compressed
                            hoverable
                            bordered
                            striped>
                            @foreach($tarefas as $tarefa)
                                @if($tarefa->tarefa_id != null)
                                    <tr
                                        @if($tarefa->status == TarefaStatusEnum::CONCLUIDA->value)
                                            class="bg-gradient-lime"
                                        @else
                                            class="{{ ($tarefa->sprint_id == null) ? 'bg-gradient-red' : '' }}"
                                        @endif>
                                        <td>{{ $tarefa->tarefa_id }}</td>
                                        <td>
                                            @if($projetoController->podeEditarTarefa($tarefa->tarefa_id))
                                                <select name="sprint[{{ $tarefa->tarefa_id }}]" class="w-100">
                                                    <option value=""></option>
                                                    @foreach($sprints as $sprint)
                                                        <option value="{{ $sprint->id }}" {{ ($sprint->id == $tarefa->sprint_id)? 'selected' : '' }}>{{ $sprint->nome }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>{{ $tarefa->descricao }}</td>
                                        <td>{{ $tarefa->inicio->format('d/m/Y') }}</td>
                                        <td>{{ $tarefa->termino->format('d/m/Y') }}</td>
                                        <td>{{ $tarefa->status }}</td>
                                    </tr>
                                @else
                                    <tr class="bg-gradient-info font-weight-bold">
                                        <td>{{ $tarefa->sprint_id }}</td>
                                        <td></td>
                                        <td>{{ $tarefa->descricao }}</td>
                                        <td>{{ $tarefa->inicio->format('d/m/Y') }}</td>
                                        <td>{{ $tarefa->termino->format('d/m/Y') }}</td>
                                        <td>&nbsp</td>

                                    </tr>
                                @endif

                            @endforeach
                        </x-adminlte-datatable>
                        <div class="row">
                            <div class="col-md-2">
                                <x-adminlte-button
                                    label="Salvar"
                                    theme="success"
                                    icon="fas fa-save"
                                    type="submit"
                                    class="w-100"
                                />
                            </div>
                            <div class="col-md-5">
                                <x-upload-modal
                                    idModal="uploadPlanilhaTarefas"
                                    message="Selecione o arquivo para importar"
                                    routeAction="{{ route('aplicacoes.casos-teste.upload-caso-teste') }}"
                                    labelBtnEnviar="Importar tarefas"
                                />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

