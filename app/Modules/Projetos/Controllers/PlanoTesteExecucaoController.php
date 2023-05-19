<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\NotFoundException;
use App\System\Http\Controllers\Controller;
use App\System\PermisissionEnum;
use Illuminate\Http\Request;
use Spatie\LaravelData\DataCollection;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class PlanoTesteExecucaoController extends Controller
{
    public function __construct(
        private readonly PlanoTesteExecucaoBusinessContract $planoTesteExecucaoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness,
        private readonly CasoTesteExecucaoBusinessContract $casoTesteExecucaoBusiness
    )
    {
        $this->middleware = ['middleware' => 'permission:'.PermisissionEnum::EXECUTAR_CASO_TESTE->value];
    }

    public function executar(Request $request, int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {
        try{

            $planoTesteExecucao = $this->planoTesteExecucaoBusiness->buscarUltimoPlanoTesteExecucaoPorPlanoTeste($idPlanoTeste);
            $casosTeste = $this->casoTesteBusiness->buscarCasoTestePorPlanoTeste($idPlanoTeste);
            return $this->exibirViewExecucao($request, $planoTesteExecucao, $casosTeste, $idAplicacao, $idProjeto);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Não existe execução para o plano de teste #'.$idPlanoTeste]]);
        }


    }
    private function exibirViewExecucao(Request $request, PlanoTesteExecucaoDTO $planoTesteExecucao, DataCollection $casosTeste, ?int $idAplicacao = null, ?int $idProjeto = null){
        if($casosTeste->count() == 0){
            $request->session()->flash(Controller::MESSAGE_KEY_WARNING, ['Este plano de teste não possui casos de teste a ser executado']);
        }
        return view('projetos::plano_teste_execucao.home', [...compact(
                'planoTesteExecucao',
                'casosTeste',
                'idAplicacao',
                'idProjeto'
            ),'casoTesteExecucaoBusiness' => $this->casoTesteExecucaoBusiness]
        );
    }

    public function criar(int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {

        $this->planoTesteExecucaoBusiness->criarExecucaoTeste($idPlanoTeste);
        return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
            ->with([Controller::MESSAGE_KEY_SUCCESS => ['Execução criada com sucesso'],]);

    }

    public function executarCasoTeste(Request $request,
                                      int $idAplicacao,
                                      int $idProjeto,
                                      int $idPlanoTeste,
                                      int $idPlanoTesteExecucao,
                                      int $idCasoTeste)
    {
        try{
            $this->casoTesteExecucaoBusiness->executarCasoTeste($idPlanoTesteExecucao, $idCasoTeste, $request->status);
            return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de teste executado com sucesso']]);
        }catch (ConflictException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Este caso de teste já foi executado']]);
        }

    }
    public function finalizar(Request $request,
                                      int $idAplicacao,
                                      int $idProjeto,
                                      int $idPlanoTeste,
                                      int $idPlanoTesteExecucao
    )
    {
        try {
            $this->planoTesteExecucaoBusiness->finalizarPlanoTesteExecucao($idPlanoTesteExecucao);
            return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Plano de teste finalizado com sucesso']]);
        }catch (ConflictException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Plano de teste não existe']]);
        }

    }

    public function executarGeral(Request $request,
                                  int $idAplicacao,
                                  int $idProjeto,
                                  int $idPlanoTeste,
                                  int $idPlanoTesteExecucao
    ){
        try{
            $planoTesteExecucao = $this->planoTesteExecucaoBusiness->buscarPlanoTesteExecucaoPorId($idPlanoTesteExecucao);
            $casosTeste = $this->casoTesteBusiness->buscarCasoTestePorPlanoTeste($planoTesteExecucao->plano_teste->id);
            return $this->exibirViewExecucao($request, $planoTesteExecucao, $casosTeste, $idAplicacao, $idProjeto);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste-execucao.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Não existe esta excução']]);

        }


    }

}
