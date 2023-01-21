<?php

namespace App\Http\Resources;

interface EOLResourceInterface
{
    /**
     * Get the product name
     */
    public function getName(): string;

    /**
     * Release Cycle
     */
    public function getCycle(string $cycle): string;

    /**
     * End of Life Date for this release cycle
     */
    public function getEndOfLife(string $eol): ?string;

    /**
     * Release Date for the first release in this cycle
     */
    public function getReleaseDate(string $date): string;

    /**
     * Latest release in this cycle
     */
    public function getLatest(string $latest): string;

    /**
     * Link to changelog for the latest release, if available
     */
    public function getLink(?string $link): ?string;

    /**
     * Whether this release cycle has long-term-support (LTS)
     */
    public function getLTS(string $lts): bool;

    /**
     * Whether this release cycle has active support
     */
    public function getSupport(string $support): string;

    /**
     * Whether this cycle is now discontinued.
     */
    public function getDiscontinued(string $discontinued): string;
}
