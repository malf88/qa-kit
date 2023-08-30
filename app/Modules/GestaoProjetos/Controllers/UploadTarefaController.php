<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\UploadTarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\TransactionDatabase;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class UploadTarefaController extends Controller
{
    use TransactionDatabase;
    const ID_PLANILHA_GOOGLE = 5;
    public function __construct(
        private readonly UploadTarefaBusinessContract $uploadTarefaBusiness
    )
    {
    }
    public function uploadTarefa(Request $request,int $idProjeto)
    {
        try{
            $idPlanilha = $this->extrairIdPlanilha($request->post('url'));
            $this->uploadTarefaBusiness->processarPlanilha($idPlanilha, $idProjeto, EquipeUtils::equipeUsuarioLogado());
            return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Planilha processada com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
                ->with([Controller::MESSAGE_KEY_ERROR => [$exception->getMessage()]]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
                ->with([Controller::MESSAGE_KEY_ERROR => $exception->getMessage()])
                ->withErrors($exception->getValidator())
                ->withInput();
        }catch (\Exception $exception){
            throw $exception;
            return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
                ->with([Controller::MESSAGE_KEY_ERROR => [$exception->getMessage()]]);
        }

    }

    private function extrairIdPlanilha(string $url):string
    {
        $urlExploded = explode('/', $url);
        return $urlExploded[self::ID_PLANILHA_GOOGLE];
    }

}
