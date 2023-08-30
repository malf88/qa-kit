<?php

namespace App\System\Contracts\Business;

use App\System\DTOs\UserDTO;
use App\System\Impl\BaseRepository;
use App\System\Requests\PasswordPutRequest;
use App\System\Requests\UploadPostRequest;
use App\System\Requests\UserPostRequest;
use App\System\Requests\UserPutRequest;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\DataCollection;

interface UserBusinessContract
{
    public function buscarTodos():DataCollection;
    public function buscarPorId(int $userId): ?UserDTO;
    public function alterar(UserDTO $userDTO, UserPutRequest $userPutRequest = new UserPutRequest()): UserDTO;
    public function alterarSenha(UserDTO $userDTO, PasswordPutRequest $passwordPutRequest = new PasswordPutRequest()): UserDTO;
    public function salvar(UserDTO $userDTO, UserPostRequest $userPostRequest = new UserPostRequest()): UserDTO;
    public function alterarEquipeSelecionada(int $idUsuario, int $idEquipe):bool;
    public function importarArquivoParaUser(?UploadedFile $uploadedFile, array $equipes,UploadPostRequest $uploadPostRequest = new UploadPostRequest()): void;
    public function buscarUsuario(array $filter):DataCollection;
}
