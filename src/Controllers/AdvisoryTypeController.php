<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\AdvisoryTypeRepository;

class AdvisoryTypeController
{
    private $repository;

    public function __construct(AdvisoryTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $data = $this->repository->getAll();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getById(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $this->repository->getById($id);
        if ($data) {
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(404)->write(json_encode(['error' => 'Not found']));
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $created = $this->repository->create($data);
        $response->getBody()->write(json_encode($created));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $updated = $this->repository->update($id, $data);
        $response->getBody()->write(json_encode($updated));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function partialUpdate(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $updated = $this->repository->partialUpdate($id, $data);
        $response->getBody()->write(json_encode($updated));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $result = $this->repository->delete($id);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
