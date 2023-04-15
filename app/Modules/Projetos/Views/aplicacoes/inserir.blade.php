@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Inserir')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">Inserir Aplicação </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('aplicacoes.salvar') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <x-adminlte-input
                                        label="Nome"
                                        name="nome"
                                        placeholder="Nome"
                                        fgroup-class="col-md-6"
                                        value="{{ old('nome','') }}"
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-textarea
                                        label="Descrição"
                                        name="descricao"
                                        placeholder="Inserir uma descrição"
                                        fgroup-class="col-md-6"
                                    >
                                    {{ old('descricao','') }}
                                    </x-adminlte-textarea>
                                </div>
                                <div class="row p-2">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="primary"
                                        icon="fas fa-disk"
                                        type="submit"
                                    />
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
