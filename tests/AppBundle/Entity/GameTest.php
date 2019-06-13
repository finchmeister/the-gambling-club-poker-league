<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testGetSpotifyUrl(): void
    {
        $game = new Game();

        $this->assertNull($game->getSpotifyPlaylistUrl());

        $game->setSpotifyPlaylistUri('spotify:user:thefinchmeister:playlist:729ibhOjmszqH6EAJJM7N2');

        $this->assertSame(
            'https://open.spotify.com/user/thefinchmeister/playlist/729ibhOjmszqH6EAJJM7N2',
            $game->getSpotifyPlaylistUrl()
        );
    }
}