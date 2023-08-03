@section('plugins.Summernote', true)

<x-adminlte-modal
    id="modalMin_tarefa_inserir_"
    title="Inserir nova tarefa para ${task.name}"
    static-backdrop
    size="md"

>

    <div class="row">
        <div class="col-md-12">

            <form method="post" action="{{ route('gestao-projetos.tarefas.salvar') }}">
                @csrf
                <input type="hidden" id="idProjeto" name="projeto_id" value="${task.id}">
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
                    <div class="col-md-6">
                        <div class="row">
                            <x-adminlte-input
                                label="Estimativa de início"
                                name="inicio_estimado"
                                placeholder="Data"
                                type="date"
                                fgroup-class="col-md-12"
                                value="{{ old('inicio_estimado','') }}"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <x-adminlte-input
                                label="Estimativa de término"
                                name="termino_estimado"
                                placeholder="Data"
                                type="date"
                                fgroup-class="col-md-12"
                                value="{{ old('termino_estimado','') }}"
                            />
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
                        <div class="row">
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
