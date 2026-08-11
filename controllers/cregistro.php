<?php
header('Content-Type: application/json; charset=utf-8');

// Controlador gestor del flujo inicial de registro
echo json_encode(['ok' => true, 'msg' => 'Flujo de registro inicializado correctamente.']);
