<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\InvalidPostDataException;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class PostLoader
{
    public function __construct(
        private PostRepository $postRepository,
        private CategoryRepository $categoryRepository,
        private CommonMarkConverter $parser
    ) {
    }

    public function fromFile(SplFileInfo $file): bool
    {
        $slug = $file->getFilenameWithoutExtension();
        [$rawMeta, $mdContent] = explode('---', $file->getContents(), 2);
        $meta = Yaml::parse($rawMeta);
        if (empty($meta['category']) || empty($meta['date']) || empty($meta['title'])) {
            throw new InvalidPostDataException("Invalid metadata for post: {$file->getPathname()}");
        }
        $category = $this->categoryRepository->getCategory($meta['category']);
        if ($category === null) {
            throw new InvalidPostDataException("Unknown category for post: {$file->getPathname()}");
        }

        $mdContent = trim($mdContent);
        $htmlContent = $this->parser->convertToHtml($mdContent);

        $data = [
            'category_id' => $category['id'],
            'date' => (new \DateTime($meta['date']))->format('Y-m-d H:i:s'),
            'title' => $meta['title'],
            'slug' => $slug,
            'description' => $meta['description'] ?? null,
            'keywords' => $meta['keywords'] ?? null,
            'main_image_alt' => $meta['main_image_alt'] ?? null,
            'content_md' => $mdContent,
            'content_html' => $htmlContent
        ];

        $post = $this->postRepository->getPost($slug);
        if ($post === null) {
            return $this->postRepository->create($data);
        } else {
            return $this->postRepository->update((int)$post['id'], $data);
        }
    }
}
