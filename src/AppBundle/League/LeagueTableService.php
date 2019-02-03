<?php

namespace AppBundle\League;

use AppBundle\Entity\Result;
use Doctrine\ORM\EntityManagerInterface;

class LeagueTableService
{
    protected $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        $result = $this->em->getRepository(Result::class)
            ->getLastUpdated();
        return $result['updatedAt'] ?? null;
    }

}