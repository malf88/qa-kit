<?php

namespace App\System\Repositorys;

use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Impl\BaseRepository;
use App\System\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class UserRepository extends BaseRepository implements UserRepositoryContract
{

    public function buscarTodos(): DataCollection
    {
        return UserDTO::collection(
            User::with('roles')
            ->get()
        );
    }

    public function buscarPorId(int $userId): ?UserDTO
    {
        $user = User::where('id', $userId)
                    ->with('roles')
                    ->first();

        if($user != null){
            $userDTO = UserDTO::from($user);
            $userDTO->equipes = EquipeDTO::collection($user->equipes);
            return $userDTO;
        }
        return null;
    }

    public function alterar(UserDTO $userDTO): UserDTO
    {

        $user = User::find($userDTO->id);
        if(empty($userDTO->password))
            $userDTO->password = $user->password;
        try {
            DB::beginTransaction();
            $user->fill($userDTO->toArray());
            $user->update();
            $user = $this->atualizarUsuarioEquipe($userDTO, $user);
            DB::commit();
            return UserDTO::from($user);
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function vincularPerfil(array $perfil, int $userId): UserDTO
    {
        $user = User::find($userId);
        $user->syncRoles($perfil);

        return UserDTO::from($user);
    }

    public function salvar(UserDTO $userDTO): UserDTO
    {
        try {
            DB::beginTransaction();
            $user = new User($userDTO->toArray());
            $user->save();
            $user = $this->atualizarUsuarioEquipe($userDTO, $user);
            DB::commit();
            return UserDTO::from($user);
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function alterarEquipeSelecionada(int $idUsuario, int $idEquipe): bool
    {
        $user = User::find($idUsuario);
        $user->selected_equipe_id = $idEquipe;
        return $user->save();
    }
    private function atualizarUsuarioEquipe(UserDTO $userDTO, User $user):User
    {
        $userDTO->equipes->each(function ($item, $key) use ($user, &$idsEquipe) {
            $idsEquipe[] = $item->id;
        });
        $user->equipes()->sync($idsEquipe);
        return $user;
    }

    public function buscarUsuario(array $filter): DataCollection
    {
        $queryBuider = User::query();
        foreach ($filter as $field => $value){
            $queryBuider->where($field, $value);
        }
        return UserDTO::collection($queryBuider->get());
    }
}
