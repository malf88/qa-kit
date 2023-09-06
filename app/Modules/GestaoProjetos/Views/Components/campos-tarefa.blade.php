<div class="row">
    <div class="col-md-12">
        <div class="row">
            <x-adminlte-input
                label="Título"
                name="titulo"
                placeholder="Título"
                fgroup-class="col-md-12"
                value="{{ old('titulo',(isset($tarefa) ? $tarefa->titulo : '')) }}"
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
                value="{{ old('inicio_estimado',(isset($tarefa) ? $tarefa->inicio_estimado->format('Y-m-d') : '')) }}"
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
                value="{{ old('termino_estimado',(isset($tarefa) ? $tarefa->termino_estimado->format('Y-m-d')  : '')) }}"
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
                        value="{{ $sprint->id }}" {{ $sprint->id == old('sprint_id', (isset($tarefa) ? $tarefa->sprint_id : '') ) ? 'selected':'' }}>{{ $sprint->nome }}</option>
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
                {{ old('descricao',(isset($tarefa) ? $tarefa->descricao : '')) }}
            </x-adminlte-text-editor>
        </div>
    </div>
</div>

