<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\DTO\DTOInterface;

interface UserDTOInterface extends DTOInterface
{
    public function getEmail(): ?string;

    public function getPassword(): ?string;

    public function getFirstName(): ?string;

    public function getLastName(): ?string;
}
