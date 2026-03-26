<?php

namespace App\Application\UseCase;

use App\Application\DTO\OutputDTO\UserOutpuDTO;
use App\Application\Factory\UserOutPutDTOFactory;
use App\Domain\User\Entity\User;

class MeUseCase
{
    public function __construct(
        private UserOutPutDTOFactory $userOutPutDTOFactory,
    )
    {
    }

    /**
     * @param User $user
     * @return UserOutpuDTO
     */
    public function me(User $user): UserOutpuDTO
    {
        return $this->userOutPutDTOFactory->makeMeOutPutDTO($user);
    }
}
