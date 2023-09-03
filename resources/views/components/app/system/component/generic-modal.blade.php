@section('plugins.BsCustomFileInput', true)
<x-adminlte-modal
    id="modalMin_generic_{{ $idModal }}"
    :title="$title"
    static-backdrop
>

    <div class="row">
        <div class="col-md-12">
            {{ $slot }}
            <x-slot name="footerSlot">
                <x-adminlte-button
                    label="Fechar"
                    theme="danger"
                    icon="fas fa-undo"
                    data-dismiss="modal"
                />
            </x-slot>
        </div>
    </div>
</x-adminlte-modal>
<x-adminlte-button
    class="btn-sm mb-2"
    theme="primary"
    label="{{ $labelBtnAbrir }}"
    title="Upload"
    icon="{{ $icon }}"
    data-toggle="modal"
    data-target="#modalMin_generic_{{ $idModal }}"
/>
