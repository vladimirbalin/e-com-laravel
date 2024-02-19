<?php
declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $dir;
    private string $method;
    private string $size;
    private string $folder;
    private string $file;

    private string $fullNewPath;
    private string $fullOldPath;
    private $storage;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = Storage::disk('images');

        $this->dir = 'products';
        $this->method = 'resize';
        $this->size = '150x150';
        $this->folder = today()->format('Y-m-d');
        $this->file = 'product.jpeg';
        $this->fullNewPath = "$this->dir/$this->method/$this->size/$this->folder/$this->file";
        $this->fullOldPath = "$this->dir/$this->folder/$this->file";

        BrandFactory::new()->create();
        config(['thumbnail.allowed_sizes' => ['150x150']]);
    }

    private function request(string $thumbnail): TestResponse
    {
        return $this->withoutExceptionHandling()
            ->get(route('thumbnail', [
                'dir' => $this->dir,
                'method' => $this->method,
                'size' => $this->size,
                'folder' => $this->folder,
                'file' => $thumbnail
            ]));
    }

    public function test_success()
    {
//        $product = ProductFactory::new()->create();
//
//        $this->get($product->makeThumbnail($this->size))
//            ->assertOk();
//
//        $this->storage->assertExists(
//            "$this->dir/$this->method/$this->size/" .
//            today()->format('Y-m-d') . '/' .
//            File::basename($product->thumbnail)
//        );

//        $this->request();

//        $this->mock(ImageManager::class, function (MockInterface $mock) {
//            $mock->shouldReceive('read')
//                ->once()
//                ->with("$this->dir/$this->file")
//                ->andReturn(ImageInterface::class);
//
//            [$width, $height] = explode('x', $this->size);
//            $mock->shouldReceive('resize')
//                ->once()
//                ->with($width, $height);
//            $mock->shouldReceive('save')
//                ->once()
//                ->with();
//        });

//        read
//        resize
//        save
//        $this->assertTrue(
//            $this->storage->exists($this->fullOldPath)
//        );
    }

    public function test_file_already_exists()
    {
        $file = UploadedFile::fake()->image($this->file);
//        $file->storeAs("$this->dir/$this->folder", $this->file, 'images');
        $this->storage->putFileAs("$this->dir/$this->folder", $file, $this->file);
        $this->storage->assertExists($this->fullOldPath);

//        Storage::shouldReceive('disk')
//            ->with('images')
//            ->andReturn(Filesystem::class);
//
//        Storage::shouldReceive('exists')
//            ->with(rtrim($this->fullNewPath, "/$this->file"))
//            ->andReturn(true);
//
//        Storage::shouldReceive('exists')
//            ->with($this->fullNewPath)
//            ->andReturn(true);
//
//        Storage::shouldReceive('path')
//            ->with($this->fullNewPath)
//            ->andReturn($this->storage->path($this->fullNewPath));
    }

    public function test_size_invalid()
    {
        $this->size = '300x300';
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Size not allowed');

        $product = ProductFactory::new()->create();

        $this->withoutExceptionHandling()->get($product->makeThumbnail($this->size));
    }
}
