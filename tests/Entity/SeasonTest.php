<?php

namespace App\Tests\Entity;

use App\Entity\Episode;
use App\Entity\Season;
use PHPUnit\Framework\TestCase;

class SeasonTest extends TestCase
{
    public function testAddEpisodeToSeason(): void
    {
        // arrange
        $season = new Season(number: 1);

        $episode1 = new Episode(1);
        $episode2 = new Episode(2);

        $season->addEpisode($episode1);
        $season->addEpisode($episode2);

        // act
        $episodes = $season->getEpisodes();

        // assert
        self::assertCount(2, $episodes);
        self::assertSame($episode1, $episodes->first());
    }
}
