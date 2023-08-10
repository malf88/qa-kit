@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

{{-- Default Content Wrapper --}}
<div class="content-wrapper {{ config('adminlte.classes_content_wrapper', '') }}">

    {{-- Content Header --}}
    @hasSection('content_header')
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="content" id="app">
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">

            @if(session()->has(\App\System\Http\Controllers\Controller::MESSAGE_KEY_SUCCESS))
                @foreach(session()->get(\App\System\Http\Controllers\Controller::MESSAGE_KEY_SUCCESS) as $message)
                    <x-adminlte-alert theme="success" title="Sucesso"    dismissable>
                        {{ $message }}
                    </x-adminlte-alert>
                @endforeach
            @endif
            @if(session()->has(\App\System\Http\Controllers\Controller::MESSAGE_KEY_ERROR))
                @foreach(session()->get(\App\System\Http\Controllers\Controller::MESSAGE_KEY_ERROR) as $message)
                    <x-adminlte-alert theme="danger" title="Erro" dismissable>
                        {{ $message }}
                    </x-adminlte-alert>
                @endforeach
            @endif
            @if(session()->has(\App\System\Http\Controllers\Controller::MESSAGE_KEY_WARNING))
                @foreach(session()->get(\App\System\Http\Controllers\Controller::MESSAGE_KEY_WARNING) as $message)
                    <x-adminlte-alert theme="warning" title="Atenção" dismissable>
                        {{ $message }}
                    </x-adminlte-alert>
                @endforeach
            @endif

            @yield('content')
        </div>
    </div>

</div>
