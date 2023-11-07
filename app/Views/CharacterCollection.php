<?php
namespace App\Views;

use App\Models\Character;

class CharacterCollection
{
    private array $characters;

    public function __construct(array $characters = [])
    {
        foreach ($characters as $character) {
            $this->add($character);
        }
    }

    public function add(Character $character): void
    {
        $this->characters [] = $character;
    }

    public function getCharacters(): array
    {
        return $this->characters;
    }
}