<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use DateTimeImmutable;

abstract class EOLResource extends JsonResource implements EOLResourceInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'  => $this->getName(),
            'items' => $this->getResource($this->resource),
        ];
    }

    /**
     * Get resource items
     *
     * @param Collection $resource
     * @return array
     */
    protected function getResource(Collection $resource): array
    {
        $items = [];

        foreach ($resource->all() as $item) {
            $data = [
                'cycle'        => $this->getCycle($item['cycle']),
                'release'      => $this->getReleaseDate($item['releaseDate']),
                'eol'          => $this->getEndofLife($item['eol']),
                'link'         => null,
                'latest'       => $this->getLatest($item['latest']),
                'lts'          => $this->getLTS($item['lts']),
                'support'      => null,
                'discontinued' => null,
            ];

            // Optional data
            if (array_key_exists('link', $item)) {
                $data['link'] = $this->getLink($item['link']);
            }

            if (array_key_exists('support', $item)) {
                $data['support'] = $this->getSupport($item['support']);
            }

            if (array_key_exists('discontinued', $item)) {
                $data['discontinued'] = $this->getDiscontinued($item['discontinued']);
            }

            $items[] = $data;
        }

        return $items;
    }

    /**
     * @inheritDoc
     */
    public function getCycle(string $cycle): string
    {
        return (string) $cycle;
    }

    /**
     * @inheritDoc
     */
    public function getEndofLife(string $eol): ?string
    {
        if ($eol) {
            return (new DateTimeImmutable($eol))->format(DateTime::W3C);
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getReleaseDate(string $date): string
    {
        return (new DateTimeImmutable($date))->format(DateTime::W3C);
    }

    /**
     * @inheritDoc
     */
    public function getLatest(string $latest): string
    {
        return (string) $latest;
    }

    /**
     * @inheritDoc
     */
    public function getLink(?string $link): ?string
    {
        return $link;
    }

    /**
     * @inheritDoc
     */
    public function getLTS(string $lts): bool
    {
        if (in_array($lts, ['0', '1', 'true', 'false'])) {
            return (bool) $lts;
        }

        if ($lts && is_string($lts)) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getSupport(string $support): string
    {
        return $support;
    }

    /**
     * @inheritDoc
     */
    public function getDiscontinued(string $discontinued): string
    {
        return $discontinued;
    }
}
