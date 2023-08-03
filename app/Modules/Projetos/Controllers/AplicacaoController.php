<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AplicacaoController extends Controller
{
    use EquipeTools;
    public function __construct(
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {

    }
    public function index()
    {
        Auth::user()->can(PermissionEnum::LISTAR_APLICACAO->value);
        $aplicacoes = $this->aplicacaoBusiness->buscarTodos(EquipeUtils::equipeUsuarioLogado());

        $heads = [
            ['label' => 'Id', 'width' => 10],
            'Nome',
            'Descrição',
            ['label' => 'Ações', 'width' => 20],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, null, ['orderable' => false]],
        ];
        return view('projetos::aplicacoes.home',
            compact('heads', 'config', 'aplicacoes'));
    }

    public function inserir()
    {
        Auth::user()->can(PermissionEnum::INSERIR_APLICACAO->value);
        return view('projetos::aplicacoes.inserir');
    }

    public function salvar(Request $request)
    {
        Auth::user()->can(PermissionEnum::INSERIR_APLICACAO->value);
        try {
            $aplicacaoDTO = AplicacaoDTO::from($request->except('equipes'));
            $aplicacaoDTO->equipes = $this->convertArrayEquipeInDTO($request->only('equipes'));
            $this->aplicacaoBusiness->salvar($aplicacaoDTO);
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Aplicação inserida com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('aplicacoes.inserir'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }

    public function editar(Request $request, int $id)
    {
        try{
            Auth::user()->can(PermissionEnum::ALTERAR_APLICACAO->value);
            $aplicacao = $this->aplicacaoBusiness->buscarPorId($id, EquipeUtils::equipeUsuarioLogado());
            $idsEquipe = [];
            $aplicacao->equipes->each(function($item, $key) use(&$idsEquipe){
                $idsEquipe[] = $item->id;
            });
            return view('projetos::aplicacoes.alterar',compact('aplicacao', 'idsEquipe'));
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }

    }

    public function atualizar(Request $request, int $id)
    {
        Auth::user()->can(PermissionEnum::ALTERAR_APLICACAO->value);
        try{
            $aplicacaoDTO = AplicacaoDTO::from($request->except('equipes'));
            $aplicacaoDTO->id = $id;
            $aplicacaoDTO->equipes = EquipeDTO::collection($this->convertArrayEquipeInDTO($request->only('equipes')));

            $this->aplicacaoBusiness->alterar($aplicacaoDTO, EquipeUtils::equipeUsuarioLogado());
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Aplicação alterada com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('aplicacoes.editar', $id))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
    public function excluir(Request $request, $id)
    {
        try{
            Auth::user()->can(PermissionEnum::REMOVER_APLICACAO->value);
            $this->aplicacaoBusiness->excluir($id, EquipeUtils::equipeUsuarioLogado());
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Aplicação removida com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }
    }

}
