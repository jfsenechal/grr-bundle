<?php

namespace Grr\GrrBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Grr\Core\Contrat\Entity\EntryInterface;
use Grr\Core\Entry\Entity\EntryTrait;
use Grr\GrrBundle\Entry\Validator as GrrEntryAssert;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;

/**
 * @ORM\Table(name="entry")
 * @ORM\Entity(repositoryClass="Grr\GrrBundle\Entry\Repository\EntryRepository")
 * @GrrEntryAssert\BusyRoom
 * @GrrEntryAssert\AreaTimeSlot
 * @ApiResource
 */
class Entry implements EntryInterface, TimestampableInterface
{
    use EntryTrait;
}
