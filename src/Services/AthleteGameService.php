<?php

namespace App\Services;

use Exception;
use App\Entity\AthleteGame;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AthleteGameRepository;

class AthleteGameService
{
    protected EntityManagerInterface $entityManager;
    protected AthleteGameRepository $athleteGameRepository;
    public function __construct(
        AthleteGameRepository $athleteGameRepository,
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
        $this->athleteGameRepository = $athleteGameRepository;
    }

    public function update(int $id, AthleteGame $data): AthleteGame
    {
        $athleteGame = $this->athleteGameRepository->findOneBy(['id'=>$id]);
        if ($athleteGame === null) {
            throw new Exception('invalid id');
        }
        $athleteGame->setAthlete($data->getAthlete());
        $athleteGame->setGame($data->getGame());

        $athleteGame->setDisqualified($data->getDisqualified());
        // if the athlete has been disqualified, update other's athletes positions
        if ($data->getDisqualified() === true && $athleteGame->getDisqualified()!== $data->getDisqualified()) {
            $this->updateDisqualifieds($data->getGame()->getId());
        }

        // if the position has changed and it's not null, update other's athletes positions
        if ($athleteGame->getPosition() !== $data->getPosition() && null !== $athleteGame->getPosition()) {
            $this->updatePositions($data->getGame()->getId(), $data->getPosition());
        }
        $athleteGame->setPosition($data->getPosition());


        $this->entityManager->persist($athleteGame);
        $this->entityManager->flush();
        return $athleteGame;
    }

    public function create(AthleteGame $data): AthleteGame
    {
        $athleteGame = new AthleteGame();
        $athleteGame->setAthlete($data->getAthlete());
        $athleteGame->setGame($data->getGame());
        $athleteGame->setDisqualified($data->getDisqualified());
        // if the position is not null, update other's athletes positions
        if (null !== $athleteGame->getPosition()) {
            $this->updatePositions($data->getGame()->getId(), $data->getPosition());
        }
        $athleteGame->setPosition($data->getPosition());

        $this->entityManager->persist($athleteGame);
        $this->entityManager->flush();
        return $athleteGame;
    }
    
    /**
     * Method validateData
     *
     * @param AthleteGame $data [data passed to the service by the Api or by a Command]
     *
     * @return Exception
     */
    public function validateData(AthleteGame $data): Exception|AthleteGame
    {
        // if the athlete has been disqualified the position has to be 'null'
        if ($data->getDisqualified() === true && null !== $data->getPosition()) {
            throw new Exception("If the athlete has been disqualified the position needs to be null", 1);
        }

        return $data;
    }


      
    /**
     * Method updatePositions
     * check if there are already athletes with the same position, set the position passed to the current athlete and update other's athletes positions.
     * This is to avoid that 2 athletes for the same race have tha same position
     *
     * @param int $game [the game id in which we have to work]
     * @param int $position [the position passed to the service e.g. by the API or by a Command]
     *
     * @return void
     */
    protected function updatePositions(int $game, int $position):void
    {
        $athleteGames = $this->athleteGameRepository->findBy(['game'=>$game, 'disqualified'=>false], ['position'=>'ASC']);
        foreach ($athleteGames as $athleteGame) {
            // if the position of the current athlete is equal or greater than the position passed during the update, his position will be updated +1
            if ($athleteGame->getPosition()>=$position) {
                $athleteGame->setPosition($athleteGame->getPosition()+1);
            }
        }
    }

   
    /**
     * Method updateDisqualifieds
     * called only if the current athlete has been disqualified to update other's athletes positions.
     *
     * @param int $game [the game id in which we have to work]
     *
     * @return void
     */
    protected function updateDisqualifieds(int $game):void
    {
        $athleteGames = $this->athleteGameRepository->findBy(['game'=>$game, 'disqualified'=>false], ['position'=>'ASC']);
        for ($i=0; $i < count($athleteGames); $i++) {
            $position = $athleteGames[$i]->getPosition();
            if ($position !== ($i+1)) {
                $athleteGames[$i]->setPosition($i+1);
            }
        }
    }
}
