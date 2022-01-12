<?php

namespace Components\Common\Common\Tests\Unit\Domain\UseCases;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use Components\Common\Common\Domain\Interfaces\FileRepositoryInterface;
use Components\Common\Common\Domain\UseCases\CreateFullText;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class CreateFullTextTest extends TestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * @dataProvider handleDataProvider
     */
    public function testHandle(string $path, array $contents)
    {
        $user = factory(User::class)->create();
        $repo = $this->app->make(FileRepositoryInterface::class);
        $file = $repo->makeFrom(new \SplFileInfo($path))->setOwner($user);

        $repo->save($file);

        $text = $this->app->make(CreateFullText::class)->handle($file);

        $this->assertCount(1, $file->getChildren());
        $this->assertStringStartsWith($file->getId(), $text->getName());
        $this->assertStringEndsWith('.txt', $text->getName());
        $this->assertEquals('text/plain', $text->getMimeType());
        $this->assertEquals($file->getId(), $text->getParent()->getId());

        foreach ($contents as $line) {
            $this->assertStringContainsString($line, $text->getContent());
        }
    }

    public function handleDataProvider()
    {
        return [
            'pdf with text' => [
                'path' => __DIR__ . '/data/file-with-text.pdf',
                'contents' => [
                    "This is a text file.",
                    "It has some text.",
                    "All glory to the hypnotoad.",
                ],
            ],

            'pdf with images' => [
                'path' => __DIR__ . '/data/file-with-image.pdf',
                'contents' => [
                    "This is a text file.",
                    "It has some text.",
                    "All glory to the hypnotoad.",
                ],
            ],

            'image' => [
                'path' => __DIR__ . '/data/file.jpg',
                'contents' => [
                    "This is a text file.",
                    "It has some text.",
                    "All glory to the hypnotoad.",
                ],
            ],
        ];
    }
}
