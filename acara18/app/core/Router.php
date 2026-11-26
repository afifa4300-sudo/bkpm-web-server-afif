<?php
class Router {
    private array $map = [
        'mahasiswa' => 'MahasiswaController',
    ];

    public function dispatch(): void {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $segments = explode('/', $uri);
        $resource = end($segments) ?: 'mahasiswa';

        $controllerName = $this->map[$resource] ?? null;
        if (!$controllerName) {
            // Langkah 4 BKPM Acara 18: Response 404 seragam via Response::json
            Response::json(404, false, 'Endpoint tidak ditemukan');
        }

        $controller = new $controllerName();
        $id = $_GET['id'] ?? null;

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $controller->index();
                break;
            case 'POST':
                $controller->store();
                break;
            case 'PUT':
                $controller->update($id);
                break;
            case 'DELETE':
                $controller->destroy($id);
                break;
            default:
                // Langkah 4 BKPM Acara 18: Response 405 seragam via Response::json
                Response::json(405, false, 'Method tidak diizinkan');
                break;
        }
    }
}
