<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\AudioFactory;

class AudioFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $audioFactory = new AudioFactory();

        $audio = $audioFactory->createFromProperties((object) [
            'album'             => 'Album',
            'albumArtist'       => 'Album Artist',
            'artist'            => 'Artist',
            'bitrate'           => '1',
            'composers'         => 'Composers',
            'copyright'         => 'Copyright',
            'disc'              => '2',
            'discCount'         => '3',
            'duration'          => '4',
            'genre'             => 'Genre',
            'hasDrm'            => true,
            'isVariableBitrate' => true,
            'title'             => 'Title',
            'track'             => '5',
            'trackCount'        => '6',
            'year'              => '1970',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Audio', $audio);
        $this->assertSame('Album', $audio->getAlbum());
        $this->assertSame('Album Artist', $audio->getAlbumArtist());
        $this->assertSame('Artist', $audio->getArtist());
        $this->assertSame(1, $audio->getBitrate());
        $this->assertSame('Composers', $audio->getComposers());
        $this->assertSame('Copyright', $audio->getCopyright());
        $this->assertSame(2, $audio->getDisc());
        $this->assertSame(3, $audio->getDiscCount());
        $this->assertSame(4, $audio->getDuration());
        $this->assertSame('Genre', $audio->getGenre());
        $this->assertTrue($audio->hasDrm());
        $this->assertTrue($audio->isVariableBitrate());
        $this->assertSame('Title', $audio->getTitle());
        $this->assertSame(5, $audio->getTrack());
        $this->assertSame(6, $audio->getTrackCount());
        $this->assertSame(1970, $audio->getYear());
    }
}
