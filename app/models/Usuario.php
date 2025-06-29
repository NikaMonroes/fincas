<?php
class Usuario
{
    private int $id;
    private string $nombre;
    private string $correo;
    private string $password;
    private string $rol;
    private string $creadoEn;
    private string $actualizadoEn;

    public function __construct(
        int $id,
        string $nombre,
        string $correo,
        string $password,
        string $rol,
        string $creadoEn,
        string $actualizadoEn
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->password = $password;
        $this->rol = $rol;
        $this->creadoEn = $creadoEn;
        $this->actualizadoEn = $actualizadoEn;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getCorreo(): string { return $this->correo; }
    public function getPassword(): string { return $this->password; }
    public function getRol(): string { return $this->rol; }
    public function getCreadoEn(): string { return $this->creadoEn; }
    public function getActualizadoEn(): string { return $this->actualizadoEn; }

    // Setters
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setCorreo(string $correo): void { $this->correo = $correo; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setRol(string $rol): void { $this->rol = $rol; }
}