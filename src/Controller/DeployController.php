<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DeployService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeployController extends AbstractController
{
    public function __construct(private readonly DeployService $deployService, private readonly string $deployToken)
    {
    }

    public function content(Request $request): Response
    {
        $token = $request->headers->get('X-Token');
        if ($token !== $this->deployToken) {
            return $this->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $this->deployService->prepareContent();

        return $this->json([]);
    }
}
