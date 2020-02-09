<?php

namespace Grr\GrrBundle\EventSubscriber;

use Grr\Core\Area\Events\AreaEventAssociatedEntryType;
use Grr\Core\Area\Events\AreaEventCreated;
use Grr\Core\Area\Events\AreaEventDeleted;
use Grr\Core\Area\Events\AreaEventUpdated;
use Grr\Core\Authorization\Events\AuthorizationEventCreated;
use Grr\Core\Authorization\Events\AuthorizationEventDeleted;
use Grr\Core\Authorization\Events\AuthorizationEventUpdated;
use Grr\Core\Entry\Events\EntryEventCreated;
use Grr\Core\Entry\Events\EntryEventDeleted;
use Grr\Core\Entry\Events\EntryEventUpdated;
use Grr\Core\EntryType\Events\EntryTypeEventCreated;
use Grr\Core\EntryType\Events\EntryTypeEventDeleted;
use Grr\Core\EntryType\Events\EntryTypeEventUpdated;
use Grr\Core\Password\Events\PasswordEventUpdated;
use Grr\Core\Room\Events\RoomEventCreated;
use Grr\Core\Room\Events\RoomEventDeleted;
use Grr\Core\Room\Events\RoomEventUpdated;
use Grr\Core\Setting\Events\SettingEventUpdated;
use Grr\Core\User\Events\UserEventCreated;
use Grr\Core\User\Events\UserEventDeleted;
use Grr\Core\User\Events\UserEventUpdated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class FlashSubscriber implements EventSubscriberInterface
{
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function onEntryTypeDeleted(EntryTypeEventDeleted $entryTypeEvent): void
    {
        $this->flashBag->add('success', 'flash.typeEntry.deleted');
    }

    public function onEntryTypeUpdated(EntryTypeEventUpdated $entryTypeEvent): void
    {
        $this->flashBag->add('success', 'flash.typeEntry.updated');
    }

    public function onEntryTypeCreated(EntryTypeEventCreated $entryTypeEvent): void
    {
        $this->flashBag->add('success', 'flash.typeEntry.created');
    }

    public function onRoomDeleted(RoomEventDeleted $roomEvent): void
    {
        $this->flashBag->add('success', 'flash.room.deleted');
    }

    public function onRoomUpdated(RoomEventUpdated $roomEvent): void
    {
        $this->flashBag->add('success', 'flash.room.updated');
    }

    public function onRoomCreated(RoomEventCreated $roomEvent): void
    {
        $this->flashBag->add('success', 'flash.room.created');
    }

    public function onSettingUpdated(): void
    {
        $this->flashBag->add('success', 'flash.setting.updated');
    }

    public function onUserDeleted(UserEventDeleted $userEvent): void
    {
        $this->flashBag->add('success', 'flash.user.deleted');
    }

    public function onUserUpdated(UserEventUpdated $userEvent): void
    {
        $this->flashBag->add('success', 'flash.user.updated');
    }

    public function onUserCreated(UserEventCreated $userEvent): void
    {
        $this->flashBag->add('success', 'flash.user.created');
    }

    public function onEntryCreated(EntryEventCreated $event): void
    {
        $this->flashBag->add('success', 'flash.entry.created');
    }

    public function onEntryUpdated(EntryEventUpdated $event): void
    {
        $this->flashBag->add('success', 'flash.entry.updated');
    }

    public function onEntryDeleted(EntryTypeEventDeleted $event): void
    {
        $this->flashBag->add('success', 'flash.entry.deleted');
    }

    public function onAreaDeleted(AreaEventDeleted $areaEvent): void
    {
        $this->flashBag->add('success', 'flash.area.deleted');
    }

    public function onAreaUpdated(AreaEventUpdated $areaEvent): void
    {
        $this->flashBag->add('success', 'flash.area.updated');
    }

    public function onAreaCreated(AreaEventCreated $areaEvent): void
    {
        $this->flashBag->add('success', 'flash.area.created');
    }

    public function onAuthorizationDeleted(AuthorizationEventDeleted $event): void
    {
        $this->flashBag->add('success', 'flash.authorization.deleted');
    }

    public function onAuthorizationCreated(AuthorizationEventUpdated $event): void
    {
        $this->flashBag->add('success', 'flash.authorization.created');
    }

    public function onAreaAssociatedEntryType(): void
    {
        $this->flashBag->add('success', 'flash.area.setEntryType');
    }

    public function onPasswordUpdated(PasswordEventUpdated $userEvent): void
    {
        $this->flashBag->add('success', 'flash.password.updated');
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EntryEventCreated::class => 'onEntryCreated',
            EntryEventUpdated::class => 'onEntryUpdated',
            EntryEventDeleted::class => 'onEntryDeleted',

            AreaEventCreated::class => 'onAreaCreated',
            AreaEventUpdated::class => 'onAreaUpdated',
            AreaEventDeleted::class => 'onAreaDeleted',
            AreaEventAssociatedEntryType::class => 'onAreaAssociatedEntryType',

            RoomEventCreated::class => 'onRoomCreated',
            RoomEventUpdated::class => 'onRoomUpdated',
            RoomEventDeleted::class => 'onRoomDeleted',

            EntryTypeEventCreated::class => 'onEntryTypeCreated',
            EntryTypeEventUpdated::class => 'onEntryTypeUpdated',
            EntryTypeEventDeleted::class => 'onEntryTypeDeleted',

            UserEventCreated::class => 'onUserCreated',
            UserEventUpdated::class => 'onUserUpdated',
            UserEventDeleted::class => 'onUserDeleted',
            PasswordEventUpdated::class => 'onPasswordUpdated',

            AuthorizationEventCreated::class => 'onAuthorizationCreated',
            AuthorizationEventDeleted::class => 'onAuthorizationDeleted',

            SettingEventUpdated::class => 'onSettingUpdated',
        ];
    }

}
