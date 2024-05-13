<?php

declare(strict_types=1);

namespace BotAcademy\Users\Http\Requests\Auth\DTO;

class SignUpUserDTO
{
    private string $name;

    private string $email;

    private string $password;

    private bool $isRemember;

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param bool $isRemember
     */
    public function __construct(
        string $name,
        string $email,
        string $password,
        bool $isRemember
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->isRemember = $isRemember;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isRemember(): bool
    {
        return $this->isRemember;
    }
}
