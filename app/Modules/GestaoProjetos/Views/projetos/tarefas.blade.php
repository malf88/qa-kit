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
                    <div class="row bg-gray-light p-2 rounded-lg font-monospace">
                        <div class="col-md-6 text-lg">Projeto: {{ $projeto->nome }}</div>
                        <div class="col-md-3">
                            <p>Início: {{ $projeto->inicio->format('d/m/Y') }}</p>
                            <p>Término: {{ $projeto->termino->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-3 align-items-center my-auto">
                            <x-generic-modal
                                idModal="uploadPlanilhaTarefas"
                                labelBtnAbrir="Importar tarefas"
                                icon="fa fas-disk"
                                title="Importar tarefas"
                            >
                                <form method="post" action="{{ route('gestao-projetos.projetos.tarefas.upload', $projeto->id) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="input-group">
                                                    <x-adminlte-input
                                                        label="Url da planilha do google"
                                                        name="url"
                                                        required
                                                        placeholder="https://docs.google.com/spreadsheets/d/1dI-cQkM9BTG-HWkMsGptSzWUa9Kh8ZG6slT7b0Adu3U/edit#gid=1224808637"
                                                        fgroup-class="col-md-12"
                                                        value="{{ old('url','') }}"
                                                    >
                                                        <x-slot name="appendSlot">
                                                            <x-adminlte-button
                                                                label="Importar"
                                                                theme="success"
                                                                icon="fas fa-file-upload"
                                                                type="submit"
                                                            />
                                                        </x-slot>
                                                    </x-adminlte-input>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </x-generic-modal>
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
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

