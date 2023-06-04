<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Person;

final class PersonFactory
{
    private  const ALLOWED_NAME_ADDITIONS = ['van', 'von', 'de'];
    private const ALLOWED_TITLE = ['Dr.'];

    public function create(string $string): Person
    {
        $parts = explode(' ', $string);

        $username = $this->extractUsername($parts);
        $lastname = $this->extractLastname($parts);
        $title = $this->extractTitle($parts);
        $nameAddition = $this->extractNameAddition($parts);
        $firstname = $this->extractFirstname($parts);

        $person = new Person($firstname, $lastname, $username);

        if($nameAddition){
            $person->setNameAddition($nameAddition);
        }
        if ($title){
            $person->setTitle($title);
        }
        return $person;
    }

    private function extractUsername(array &$parts): string
    {
        $username = array_pop($parts);
        return str_replace(['(', ')'], '', $username);
    }

    private function extractLastname(array &$parts): string
    {
        return ltrim(array_pop($parts));
    }

    private function extractTitle(array &$parts): ?string
    {
        $title = null;
        if (in_array(reset($parts), self::ALLOWED_TITLE, true)) {
            $title = array_shift($parts);
        }
        return $title;
    }

    private function extractNameAddition(array &$parts): ?string
    {
        $nameAddition = null;
        if (in_array(end($parts), self::ALLOWED_NAME_ADDITIONS, true)){
            $nameAddition = array_pop($parts);
        }
        return $nameAddition;
    }

    private function extractFirstname(array $parts): string
    {
        return ltrim(implode(' ', $parts));
    }
}
