<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\VideoRepository;
use Illuminate\Support\Facades\Storage;

class VideoPlaybackControllerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    public function test_playback_page_loads()
    {
        Storage::fake('videos');
        
        $repository = app(VideoRepository::class);
        
        $video = $repository->create('1', '1', 'test.mp4', 'video/mp4');

        // Fake that video upload and processing has been completed
        $video->completed = true;
        $video->save();

        $this->actingAsApplication(1);

        $response = $this->get('/play/' . $video->video_id);
        
        $response->assertViewIs('video');
        $response->assertViewHas('video');
        $response->assertSee('data-dash="'. $video->dash_stream .'"');
        $response->assertSee('application/json+oembed');
        
    }

    public function test_playback_page_loads_if_video_is_processing()
    {
        Storage::fake('videos');
        
        $repository = app(VideoRepository::class);
        
        $video = $repository->create('1', '1', 'test.mp4', 'video/mp4');

        $this->actingAsApplication(1);

        $response = $this->get('/play/' . $video->video_id);
        
        $response->assertViewIs('video');
        $response->assertViewHas('video');
        $response->assertDontSee('data-dash');
        
        
    }
}
