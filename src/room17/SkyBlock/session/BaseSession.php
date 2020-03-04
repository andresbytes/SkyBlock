<?php
/**
 *  _____    ____    ____   __  __  __  ______
 * |  __ \  / __ \  / __ \ |  \/  |/_ ||____  |
 * | |__) || |  | || |  | || \  / | | |    / /
 * |  _  / | |  | || |  | || |\/| | | |   / /
 * | | \ \ | |__| || |__| || |  | | | |  / /
 * |_|  \_\ \____/  \____/ |_|  |_| |_| /_/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace room17\SkyBlock\session;


use room17\SkyBlock\provider\Provider;

abstract class BaseSession {

    public const RANK_DEFAULT = 0;
    public const RANK_OFFICER = 1;
    public const RANK_LEADER = 2;
    public const RANK_FOUNDER = 3;

    /** @var SessionManager */
    protected $manager;

    /** @var Provider */
    protected $provider;

    /** @var string */
    protected $lowerCaseName;

    /** @var string|null */
    protected $islandId = null;

    /** @var bool */
    protected $inChat = false;

    /** @var int */
    protected $rank = false;

    /** @var float|null */
    protected $lastIslandCreationTime;

    public function __construct(SessionManager $manager, string $name) {
        $this->manager = $manager;
        $this->lowerCaseName = strtolower($name);
        $this->provider = $manager->getPlugin()->getProvider();
        $this->provider->loadSession($this);
    }

    public function getLowerCaseName(): string {
        return $this->lowerCaseName;
    }

    public function getIslandId(): ?string {
        return $this->islandId;
    }

    public function isInChat(): bool {
        return $this->inChat;
    }

    public function getRank(): int {
        return $this->rank;
    }

    public function hasLastIslandCreationTime(): bool {
        return $this->lastIslandCreationTime != null;
    }

    public function getLastIslandCreationTime(): ?float {
        return $this->lastIslandCreationTime;
    }

    public function setIslandId(?string $identifier): void {
        $this->islandId = $identifier;
    }

    public function setInChat(bool $inChat = true): void {
        $this->inChat = $inChat;
    }

    public function setRank(int $rank = self::RANK_DEFAULT): void {
        $this->rank = $rank;
    }

    public function setLastIslandCreationTime(?float $lastIslandCreationTime): void {
        $this->lastIslandCreationTime = $lastIslandCreationTime;
    }

    public function save(): void {
        $this->provider->saveSession($this);
    }

}