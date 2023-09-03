@section('plugins.Summernote', true)

<x-adminlte-modal
    id="modalMin_tarefa_inserir_"
    title="Inserir nova tarefa para {{ $projeto->nome }}"
    static-backdrop
    size="md"

>

    <div class="row">
        <div class="col-md-12">

            <form method="post" action="{{ route('gestao-projetos.tarefas.salvar', $projeto->id) }}">
                @csrf
                <input type="hidden" id="idProjeto" name="projeto_id" value="{{ $projeto->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <x-adminlte-input
                                label="Título"
                                name="titulo"
                                placeholder="Título"
                                fgroup-class="col-md-12"
                                value="{{ old('titulo','') }}"
                                required
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <x-adminlte-input
                                label="Est. de início"
                                name="inicio_estimado"
                                placeholder="Data"
                                type="date"
                                fgroup-class="col-md-12"
                                value="{{ old('inicio_estimado','') }}"
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <x-adminlte-input
                                label="Est. de término"
                                name="termino_estimado"
                                placeholder="Data"
                                type="date"
                                fgroup-class="col-md-12"
                                value="{{ old('termino_estimado','') }}"
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <x-adminlte-select
                                name="sprint_id"
                                label="Sprint"
                                fgroup-class="col-md-12"
                            >
                                <option value="">Selecione uma sprint</option>
                                @foreach($sprints as $sprint)
                                    <option
                                        value="{{ $sprint->id }}">{{ $sprint->nome }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row px-2">
                            <x-adminlte-text-editor
                                class="summernote"
                                id="descricao"
                                name="descricao"
                                required
                            >
                                {{ old('descricao','') }}
                            </x-adminlte-text-editor>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="row pl-2">
                            <x-adminlte-button
                                label="Salvar"
                                type="submit"
                                theme="success"
                                icon="fas fa-save"
                            />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <x-adminlte-button
                                label="Fechar"
                                theme="danger"
                                icon="fas fa-undo"
                                data-dismiss="modal"
                            />
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <x-slot name="footerSlot">
    </x-slot>
</x-adminlte-modal>
<x-adminlte-button
    class="btn-sm "
    theme="primary"
    label="Inserir tarefa"
    title="Inserir tarefa"
    icon="fas fa-tasks"
    onclick="$('.summernote').summernote();"
    data-toggle="modal"
    data-target="#modalMin_tarefa_inserir_"
/>
