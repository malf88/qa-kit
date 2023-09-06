@section('plugins.Summernote', true)

<x-adminlte-modal
    id="modalMin_tarefa_inserir_{{ $tarefa->id }}"
    title="Alterar tarefa {{ $tarefa->titulo }}"
    static-backdrop
    size="md"

>

    <div class="row">
        <div class="col-md-12">

            <form id="formAlterarTarefa_{{ $tarefa->id }}" method="post" action="{{ route('gestao-projetos.tarefas.alterar', [$projeto->id, $tarefa->id]) }}">
                @csrf
                @method('put')
                @include('gestao-projetos::Components.campos-tarefa')
                <div class="row">
                    <div class="col-md-3">
                        <div class="row pl-2">
                            <x-adminlte-button
                                label="Salvar"
                                type="button"
                                theme="success"
                                icon="fa fas-disk"
                                onclick="document.getElementById('formAlterarTarefa_{{ $tarefa->id }}').submit()"
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
    label="{{ $labelBotaoAbrir }}"
    title="{{ $labelBotaoAbrir }}"
    icon="{{ $iconeBotaoAbrir }}"
    onclick="$('.summernote').summernote();"
    data-toggle="modal"
    data-target="#modalMin_tarefa_inserir_{{ $tarefa->id }}"
/>
