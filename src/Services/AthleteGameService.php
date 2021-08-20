<?php

namespace App\Services;

use App\Entity\AthleteGame;

class AthleteGameService
{
    public function __construct()
    {
    }

    public function update(int $id, AthleteGame $data): String|AthleteGame
    {
    }

    public function create(AthleteGame $data): String|AthleteGame
    {
    }

    public function validateData(AthleteGame $data): String|AthleteGame
    {
    }


    // check if there are already athletes with the same position, set the position passed to the current athlete and update other's athletes positions.
    // Thi is to avoid that 2 athletes for the same race have tha same position
    protected function updatePosition(AthleteGame $athleteGame, int $position):void
    {
    }

    // check if the current athlete has been disqualified and update his position and other's athletes positions accordingly.
    protected function updateDisqualified(AthleteGame $athleteGame, bool $disqualified):void
    {
    }
}
