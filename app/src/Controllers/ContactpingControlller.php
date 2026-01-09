<?php

namespace App\Controllers;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Request;
use App\Lib\Http\Response;

class ContactController extends AbstractController
{
    public function process(Request $request): Response
    {
        $method = $request->getMethod();
        $filename = $request->getParam('filename');
        $dir = __DIR__ . '/../../var/contacts';

        if ($method === 'POST') {

            $data = json_decode($request->getContent(), true);

            if (!$data) {
                return new Response(json_encode(['error' => 'json error']), 400);
            }

            if (!isset($data['email']) || !isset($data['subject']) || !isset($data['message'])) {
                return new Response(json_encode(['error' => 'missing data']), 400);
            }

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $time = time();
            $file = $time . '_' . $data['email'] . '.json';

            $save = [
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'dateOfCreation' => $time,
                'dateOfLastUpdate' => $time
            ];

            file_put_contents($dir . '/' . $file, json_encode($save));

            return new Response(json_encode(['file' => $file]), 201);
        }

        if ($method === 'GET') {

            if ($filename) {
                $path = $dir . '/' . $filename;

                if (!file_exists($path)) {
                    return new Response(json_encode(['error' => 'not found']), 404);
                }

                return new Response(file_get_contents($path), 200);
            }

            if (!is_dir($dir)) {
                return new Response(json_encode([]), 200);
            }

            $files = scandir($dir);
            $res = [];

            foreach ($files as $f) {
                if ($f !== '.' && $f !== '..') {
                    $res[] = json_decode(file_get_contents($dir . '/' . $f), true);
                }
            }

            return new Response(json_encode($res), 200);
        }

        if ($method === 'PATCH') {

            if (!$filename) {
                return new Response(json_encode(['error' => 'no file']), 400);
            }

            $path = $dir . '/' . $filename;

            if (!file_exists($path)) {
                return new Response(json_encode(['error' => 'not found']), 404);
            }

            $data = json_decode($request->getContent(), true);

            if (!$data) {
                return new Response(json_encode(['error' => 'json error']), 400);
            }

            $contact = json_decode(file_get_contents($path), true);

            foreach ($data as $k => $v) {
                $contact[$k] = $v;
            }

            $contact['dateOfLastUpdate'] = time();

            file_put_contents($path, json_encode($contact));

            return new Response(json_encode($contact), 200);
        }

        if ($method === 'DELETE') {

            if (!$filename) {
                return new Response(json_encode(['error' => 'no file']), 400);
            }

            $path = $dir . '/' . $filename;

            if (!file_exists($path)) {
                return new Response(json_encode(['error' => 'not found']), 404);
            }

            unlink($path);

            return new Response('', 204);
        }

        return new Response(json_encode(['error' => 'method not allowed']), 405);
    }
}