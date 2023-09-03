<?php

namespace App\System\Business;


use App\Modules\Projetos\Models\CasoTesteExcelModel;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\RoleDTO;
use App\System\DTOs\UserDTO;
use App\System\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use App\System\Requests\PasswordPutRequest;
use App\System\Requests\UploadPostRequest;
use App\System\Requests\UserPostRequest;
use App\System\Requests\UserPutRequest;
use App\System\Traits\EquipeTools;
use App\System\Traits\Validation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelData\DataCollection;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UserBusiness extends BusinessAbstract implements UserBusinessContract
{
    use Validation, EquipeTools;
    const COLUNA_NAME = 0;
    const COLUNA_EMAIL = 1;
    const COLUNA_REGRA = 2;
    const COLUNA_EQUIPE = 3;
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    )
    {
    }

    public function buscarTodos(): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_USUARIO->value);
        return $this->userRepository->buscarTodos();
    }

    public function buscarPorId(int $userId): ?UserDTO
    {
        $this->can(PermissionEnum::LISTAR_USUARIO->value);
        return $this->userRepository->buscarPorId($userId);
    }

    public function alterar(UserDTO $userDTO, UserPutRequest $userPutRequest = new UserPutRequest()): UserDTO
    {
        $this->can(PermissionEnum::ALTERAR_USUARIO->value);
        if($this->buscarPorId($userDTO->id) == null){
            throw new NotFoundException();
        }

        $this->validationWithoutRequest($userDTO->toArray(), $userPutRequest->rules($userDTO->id));
        $user = $this->userRepository->alterar($userDTO);
        $this->userRepository->vincularPerfil($userDTO->roles->toArray(), $user->id);
        return $user;
    }

    public function salvar(UserDTO $userDTO, UserPostRequest $userPostRequest = new UserPostRequest()): UserDTO
    {
        $this->can(PermissionEnum::INSERIR_USUARIO->value);

        $this->validation($userDTO->toArray(), $userPostRequest);
        $user = $this->userRepository->salvar($userDTO);
        $this->userRepository->vincularPerfil($userDTO->roles->toArray(), $user->id);
        return $user;
    }

    public function alterarSenha(UserDTO $userDTO, PasswordPutRequest $passwordPutRequest = new PasswordPutRequest()): UserDTO
    {
        $this->can(PermissionEnum::ALTERAR_SENHA_USUARIO->value);
        $user = $this->buscarPorId($userDTO->id);
        if($user == null){
            throw new NotFoundException();
        }
        $this->validation($userDTO->toArray(), $passwordPutRequest);
        $userDTO = UserDTO::from([...$user->except('password')->toArray(), 'password' => Hash::make($userDTO->password)]);
        $user = $this->userRepository->alterar($userDTO);
        return $user;
    }

    public function alterarEquipeSelecionada(int $idUsuario, int $idEquipe): bool
    {
        return $this->userRepository->alterarEquipeSelecionada($idUsuario, $idEquipe);
    }

    public function importarArquivoParaUser(?UploadedFile $uploadedFile,array $equipes, UploadPostRequest $uploadPostRequest = new UploadPostRequest()): void
    {
        $this->can(PermissionEnum::INSERIR_USUARIO->value);

        $this->validation(['arquivo' => $uploadedFile, ...$equipes], $uploadPostRequest);

        Storage::put('tmp/',$uploadedFile);
        $casoTeste = Excel::toCollection(new CasoTesteExcelModel(), Storage::path('tmp/'.$uploadedFile->hashName()));
        $this->userRepository->beginTransaction();
        try{
            $casoTeste->each(function($item, $key) use($equipes){
                $item->each(function ($row, $key) use($equipes){
                    $this->validarPrimeiraLinha($row, $key);
                    if($key > 0){
                        $userDTO = $this->criarUserPorLinhaXLSX($row);
                        $userDTO->equipes = $this->convertArrayEquipeInDTO($equipes);
                        $this->salvar($userDTO);
                    }
                });
            });
            $this->userRepository->commit();
        }catch (FileException $e){
            $this->userRepository->rollBack();
            throw $e;
        }
    }
    public function validarPrimeiraLinha(Collection $row, $key):bool
    {

        if($key == 0 &&
            ($row->get(self::COLUNA_NAME) != 'Nome' ||
                $row->get(self::COLUNA_EMAIL) != 'E-mail' ||
                $row->get(self::COLUNA_REGRA) != 'Regra' ||
                $row->get(self::COLUNA_EQUIPE) != 'Equipe')){
            throw new FileException('Formato do arquivo inválido.');
        }

        return true;
    }
    public function criarUserPorLinhaXLSX(Collection $row):UserDTO
    {
        return UserDTO::from([
            'name' => $row->get(0),
            'email' => $row->get(1),
            'roles' => [RoleDTO::from(['name' => $row->get(2), 'guard' => 'web'])],
            'equipes' => [EquipeDTO::from(['id' => $row->get(3)])],
            'password' => Hash::make('teste')
        ]);
    }

    public function buscarUsuario(array $filter): DataCollection
    {
        return $this->userRepository->buscarUsuario($filter);
    }

    public function buscarUsuariosPorEquipe(int $idEquipe): DataCollection
    {
        return $this->userRepository->buscarUsuariosPorEquipe($idEquipe);
    }
}
