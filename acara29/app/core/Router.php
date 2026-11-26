<?php
class Router {
    private array $map = [
        'mahasiswa' => 'MahasiswaController',
        'register'  => 'AuthController',
        'login'     => 'AuthController',
    ];

    public function dispatch(): void {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $segments = explode('/', $uri);
        $resource = end($segments) ?: 'mahasiswa';

        // Jika user membuka root URL publik (misal: /acara27/public atau /acara27/public/), arahkan ke tampilan dashboard
        if ($resource === 'public') {
            header('Location: views/dashboard.html');
            exit;
        }

        $controllerName = $this->map[$resource] ?? null;
        if (!$controllerName) {
            Response::json(404, false, 'Endpoint tidak ditemukan');
        }

        $controller = new $controllerName();

        if ($resource === 'login') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->login();
            } else {
                Response::json(405, false, 'Method tidak diizinkan pada endpoint login');
            }
            return;
        }

        if ($resource === 'register') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->register();
            } else {
                Response::json(405, false, 'Method tidak diizinkan pada endpoint register');
            }
            return;
        }

        $id = $_GET['id'] ?? ($_POST['id'] ?? null);
        $method = $_SERVER['REQUEST_METHOD'];

        // Mendukung HTTP Method Spoofing via header X-HTTP-Method-Override atau parameter _method
        // Penting untuk request multipart/form-data upload file yang dikirim via POST tetapi semantik aksinya adalah PUT
        if ($method === 'POST') {
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $overrideHeader = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] 
                ?? ($headers['X-HTTP-Method-Override'] ?? ($headers['x-http-method-override'] ?? null));
            $override = $overrideHeader ?? ($_POST['_method'] ?? null);
            if ($override) {
                $method = strtoupper($override);
            }
        }

        switch ($method) {
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
                Response::json(405, false, 'Method tidak diizinkan');
                break;
        }
    }
}
