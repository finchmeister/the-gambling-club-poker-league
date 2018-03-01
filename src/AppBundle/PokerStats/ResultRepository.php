<?php


namespace AppBundle\PokerStats;


use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\Collection;

class ResultRepository
{

    public function getMaxCountWinsPlayer(Collection $results): ?Player
    {
        if ($results->isEmpty()) {
            return null;
        }
        $winningResults = $this->getWinningResults($results);
        $winningPlayers = $winningResults->map(function (Result $result) {
            return $result->getPlayer();
        });
        $winningPlayerIds = $winningPlayers->map(function (Player $player) {
            return $player->getId();
        });
        $countWinningPlayers = array_count_values($winningPlayerIds->toArray());

        $commonValues = array_keys($countWinningPlayers, max($countWinningPlayers));
        if (count($commonValues) > 1) {
            return null;
        }
        $players = array_combine($winningPlayerIds->toArray(), $winningPlayers->toArray());
        return $players[$commonValues[0]];
    }

    public function getCountPlayerWins(Player $player, Collection $results)
    {
        $results = $this->getWinningResults($results);
        return $results->filter(function (Result $result) use ($player) {
            return $result->getPlayer() === $player;
        })->count();
    }

    public function getMaxCountWins(Collection $results): ?int
    {
        if ($player = $this->getMaxCountWinsPlayer($results)) {
            return $this->getCountPlayerWins($player, $results);
        };
        return null;
    }

    public function getSumCashWon(Collection $results): int
    {
        return array_sum($this->getCashWon($results)->toArray());
    }

    public function getCountGamesWon(Collection $results): int
    {
        return $this->getWinningResults($results)->count();
    }

    public function getSumBoughtIn(Collection $results): int
    {
        return array_sum($results->map(
            function (Result $result) {
                return $result->getBoughtIn();
            }
        )->toArray());
    }

    public function getSumRebuys(Collection $results): int
    {
        return array_sum($results->map(
            function (Result $result) {
                return $result->getNoOfRebuys();
            }
        )->toArray());
    }

    public function getCountGamesPaid(Collection $results): int
    {
        return $results->filter(
            function (Result $result) {
                return $result->getWinnings() > 0;
            }
        )->count();
    }

    public function getPositions(Collection $results): Collection
    {
        return $results->map(
            function (Result $result) {
                return $result->getPosition();
            }
        );
    }

    public function getWinningResults(Collection $results): Collection
    {
        return $results->filter(
            function (Result $result) {
                return $result->getPosition() === 1;
            }
        );
    }

    public function getCashWon(Collection $results): Collection
    {
        return $results->map(
            function (Result $result) {
                return $result->getWinnings();
            }
        );
    }

    public function getBoughtIn(Collection $results): Collection
    {
        return $results->map(
            function (Result $result) {
                return $result->getBoughtIn();
            }
        );
    }

    public function getNet(Collection $results): Collection
    {
        return $results->map(
            function (Result $result) {
                return $result->getNet();
            }
        );
    }

    public function getMinPosition(Collection $results): ?int
    {
        return $results->count() > 0
            ? min($this->getPositions($results)->toArray())
            : null;
    }

    public function getMaxPosition(Collection $results): ?int
    {
        return $results->count() > 0
            ? max($this->getPositions($results)->toArray())
            : null;
    }

    public function getMaxCashWon(Collection $results): ?int
    {
        return $results->count() > 0
            ? max($this->getCashWon($results)->toArray())
            : null;
    }

    public function getMaxNet(Collection $results): int
    {
        return $results->count() > 0
            ? max($this->getNet($results)->toArray())
            : null;
    }

    public function getMinNet(Collection $results): int
    {
        return $results->count() > 0
            ? min($this->getNet($results)->toArray())
            : null;
    }


    public function getMaxBoughtIn(Collection $results): ?int
    {
        return $results->count() > 0
            ? max($this->getBoughtIn($results)->toArray())
            : null;
    }

    public function getSumGeneralPoints(Collection $results): float
    {
        return array_sum($results->map(
            function (Result $result) {
                return $result->getGeneralPoints();
            }
        )->toArray());
    }

    public function getSumLeaguePoints(Collection $results): float
    {
        return array_sum($results->map(
            function (Result $result) {
                return $result->getLeaguePoints();
            }
        )->toArray());
    }
}

