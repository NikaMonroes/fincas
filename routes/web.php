<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../app/services/CorreoService.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Solo para pruebas
//echo "<pre>"; print_r($_GET); echo "</pre>";

/* cABECERA UTF-8 ERROR
header('Content-Type: text/html; charset=UTF-8');*/

$accion = $_GET['accion'] ?? 'home';

//errores
ini_set('display_errors', 1);
error_reporting(E_ALL);


switch ($accion) {

    // 🔐 AUTENTICACIÓN
    case 'login':
        require_once __DIR__ . '/../app/views/login.php';
        break;

    case 'procesar_login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $auth = new AuthController($pdo);
        $auth->login($_POST['correo'], $_POST['password']);
        break;

    case 'logout':
        session_unset();
        session_destroy();
        header('Location: ?accion=login');
        exit;

    // 👑 PANEL DE ADMINISTRADOR
    case 'admin':
        if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin') {
            require_once __DIR__ . '/../app/views/admin.php';
        } else {
            header('Location: ?accion=login');
            exit;
        }
        break;

    case 'editor':
        if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'editor') {
            require_once __DIR__ . '/../app/views/editor.php';
        } else {
            header('Location: ?accion=login');
            exit;
        }
        break;

    // 👥 USUARIOS
    case 'usuarios':
        require_once __DIR__ . '/../app/views/usuarios/usuarios.php';
        break;

    case 'crear_usuario':
        require_once __DIR__ . '/../app/views/usuarios/crear_usuario.php';
        break;

    case 'editar_usuario':
        require_once __DIR__ . '/../app/views/usuarios/editar_usuario.php';
        break;

    case 'eliminar_usuario':
        // Prevenir que un usuario se elimine a sí mismo
        if ($_GET['id'] == $_SESSION['usuario_id']) {
            echo "<script>alert('No puedes eliminarte a ti mismo'); window.location.href='?accion=usuarios';</script>";
            exit;
        }

        require_once __DIR__ . '/../app/controllers/UsuarioController.php';
        $controller = new UsuarioController($pdo);
        $controller->eliminar((int) $_GET['id']);
        header('Location: ?accion=usuarios');
        exit;
  //-------------------------------------------------------------------
          // 🏡 Fincas
        case 'fincas':
            require_once __DIR__ . '/../app/views/fincas/fincas.php';
            break;

        case 'crear_finca':
    require_once __DIR__ . '/../app/controllers/fincasControl/FincaController.php';
    $controller = new FincaController($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Manejar la imagen
        $nombreImagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreImagen = uniqid('finca_') . '.' . strtolower($ext);
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../public/img/' . $nombreImagen);
        }
         // Servicios → dentro de observaciones
        $serviciosSeleccionados = $_POST['servicios'] ?? [];
        $textoServicios = '';
        if (!empty($serviciosSeleccionados)) {
            $textoServicios = '🛎️ Servicios disponibles: ' . implode(', ', $serviciosSeleccionados) . "\n\n";
            //$textoServicios = '🛎️ Servicios disponibles: 🍕 Pizza, 🛁 Jacuzzi, 🚀 Viaje al espacio';
            /*$testTexto = '🛎️ Servicios disponibles: 📶 Wi-Fi, 🐶 Pet Friendly, 🚗 Parqueadero';

echo '<pre>';
echo $testTexto;
exit;*/
        }

        $data = [
            'ref' => $_POST['ref'],
            'nombre' => $_POST['nombre'],
            'zona' => $_POST['zona'],
            'destino' => $_POST['destino'],
            'ubicacion' => $_POST['ubicacion'],
            'distancia' => $_POST['distancia'],
            'clima' => $_POST['clima'],
            'capacidad' => $_POST['capacidad'],
            'estrellas' => $_POST['estrellas'],
            'p_temporada_alta' => $_POST['p_temporada_alta'],
            'p_temporada_baja' => $_POST['p_temporada_baja'],
            'imagen' => $nombreImagen ?? '', // vacío si no se cargó imagen
            'observaciones' => $textoServicios . $_POST['observaciones']
        ];
        // Datos de prueba
        /*
        $data = [
            'ref' => 'TEST123',
            'nombre' => 'Finca Emoji',
            'zona' => 'ZONA TEST',
            'destino' => 'DESTINO TEST',
            'ubicacion' => 'Aquí 👇',
            'distancia' => '15 km',
            'clima' => '🌤️ Soleado',
            'capacidad' => 8,
            'estrellas' => '**',
            'p_temporada_alta' => 500000,
            'p_temporada_baja' => 350000,
            'imagen' => '',
            'observaciones' => '🛎️ Servicios disponibles: 📶 Wi-Fi, 🏊 Piscina, 🍖 BBQ, 🐶 Pet Friendly, 🚗 Parqueadero'
        ];
        */

        // echo servicios exito
        /*
        $controller->crear($data);
        echo '<pre>✓ Servicios guardados con éxito</pre>';
        exit;*/

        $controller->crear($data);
        header('Location: ?accion=fincas');
        exit;
    } else {
        require_once __DIR__ . '/../app/views/fincas/crear_finca.php';
    }
    break;

    $controller->crear($data);
    header('Location: ?accion=fincas');
    exit;

        case 'editar_finca':
    require_once __DIR__ . '/../app/controllers/fincasControl/FincaController.php';
    $controller = new FincaController($pdo);
    $ref = $_GET['ref'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar nueva imagen (opcional)
        $nombreImagen = $_POST['imagen_actual'] ?? ''; // Por defecto se mantiene la actual

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreImagen = uniqid('finca_') . '.' . strtolower($ext);
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../public/img/' . $nombreImagen);
        }
        // servicios
           $serviciosSeleccionados = $_POST['servicios'] ?? [];
        $textoServicios = '';
        if (!empty($serviciosSeleccionados)) {
            $textoServicios = '🛎️ Servicios disponibles: ' . implode(', ', $serviciosSeleccionados) . "\n\n";
            //$textoServicios = '🛎️ Servicios disponibles: 🍕 Pizza, 🛁 Jacuzzi, 🚀 Viaje al espacio';
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'zona' => $_POST['zona'],
            'destino' => $_POST['destino'],
            'ubicacion' => $_POST['ubicacion'],
            'distancia' => $_POST['distancia'],
            'clima' => $_POST['clima'],
            'capacidad' => $_POST['capacidad'],
            'estrellas' => $_POST['estrellas'],
            'p_temporada_alta' => $_POST['p_temporada_alta'],
            'p_temporada_baja' => $_POST['p_temporada_baja'],
            'imagen' => $nombreImagen,
            'observaciones' => $textoServicios . $_POST['observaciones']

        ];

        $controller->actualizar($ref, $data);
        header('Location: ?accion=fincas');
        exit;
    } else {
        require_once __DIR__ . '/../app/views/fincas/editar_finca.php';
    }
    break;

        case 'eliminar_finca':
            require_once __DIR__ . '/../app/controllers/fincasControl/FincaController.php';
            $controller = new FincaController($pdo);
            $ref = $_GET['ref'] ?? null;

            if ($ref) {
                $controller->eliminar($ref);
            }

            header('Location: ?accion=fincas');
            exit;

        case 'galeria_finca':
            require_once __DIR__ . '/../app/controllers/fincasControl/FincaController.php';
            $controller = new FincaController($pdo);
            $ref = $_GET['ref'] ?? null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagenes'])) {
                $controller->subirImagenes($ref, $_FILES['imagenes']);
            }

            require_once __DIR__ . '/../app/views/fincas/galeria_finca.php';
            break;
            // eliminar imagen galeria
            case 'eliminar_imagen':
                require_once __DIR__ . '/../app/controllers/fincasControl/FincaController.php';
                $controller = new FincaController($pdo);
                $idImagen = $_GET['id'] ?? null;
                $ref = $_GET['ref'] ?? null;

                if ($idImagen && $ref) {
                    $controller->eliminarImagen($idImagen);
                }

                header('Location: ?accion=galeria_finca&ref=' . urlencode($ref));
                exit;

                // ver_finca detalles
                case 'ver_finca':
                $ref = $_GET['ref'] ?? null;
                if ($ref) {
                    require_once __DIR__ . '/../app/models/FincaModel.php';
                    $model = new FincaModel($pdo);
                    $finca = $model->leerPorReferencia($ref);

                    if ($finca) {
                        require_once __DIR__ . '/../app/views/fincas/ver_finca.php';
                        exit;
                    } else {
                        echo "<h3>Finca no encontrada</h3>";
                        exit;
                    }
                }
                break;
        // 📅 Reservas

        // -----------------------------------------------------------------
        // MOSTRAR LISTADO DE RESERVAS (PANEL ADMIN)
        // -----------------------------------------------------------------
        case 'reservas':
            require_once __DIR__ . '/../app/models/ReservaModel.php';

            $reservaModel = new ReservaModel($pdo);
            $reservas = $reservaModel->leerTodas();

            require_once __DIR__ . '/../app/views/reservas/reservas_admin.php';
            break;


        // -----------------------------------------------------------------
        // FORMULARIO PARA RESERVAR UNA FINCA
        // -----------------------------------------------------------------
        case 'reserva_finca':
            require_once __DIR__ . '/../app/views/reservas/reserva_finca.php';
            break;


        // -----------------------------------------------------------------
        // PROCESAR LA CREACIÓN DE UNA RESERVA
        // -----------------------------------------------------------------
        case 'crear_reserva':
            require_once __DIR__ . '/../app/models/ReservaModel.php';
            require_once __DIR__ . '/../app/services/CorreoService.php';

            $model = new ReservaModel($pdo);
            $correo = new CorreoService();

            // Recibir datos del formulario
            $ref_finca      = $_POST['ref_finca'] ?? '';
            $fecha_inicio   = $_POST['fecha_inicio'] ?? '';
            $fecha_fin      = $_POST['fecha_fin'] ?? '';
            $nombre         = $_POST['nombre_cliente'] ?? '';
            $email          = $_POST['email_cliente'] ?? '';
            $telefono       = $_POST['telefono_cliente'] ?? '';
            $direccion      = $_POST['direccion'] ?? '';
            $ciudad         = $_POST['ciudad_cliente'] ?? '';
            $obs            = $_POST['observaciones'] ?? '';

            // Validaciones básicas
            $inicio = strtotime($fecha_inicio);
            $fin = strtotime($fecha_fin);

            if ($fin <= $inicio || $inicio < strtotime(date('Y-m-d'))) {
                echo "<script>
                    alert('Fechas inválidas. Verifica el rango.');
                    window.history.back();
                </script>";
                exit;
            }

            $noches = ($fin - $inicio) / 86400;
            if ($noches < 2) {
                echo "<script>
                    alert('La estadía mínima es de 2 noches.');
                    window.history.back();
                </script>";
                exit;
            }

            // Verificar disponibilidad
            if ($model->hayCruceDeFechas($ref_finca, $fecha_inicio, $fecha_fin)) {
                echo "<script>
                    alert('Ya hay una reserva activa para ese rango.');
                    window.history.back();
                </script>";
                exit;
            }

            // Crear reserva
            $model->crear([
                'ref_finca'       => $ref_finca,
                'fecha_inicio'    => $fecha_inicio,
                'fecha_fin'       => $fecha_fin,
                'nombre_cliente'  => $nombre,
                'email_cliente'   => $email,
                'telefono_cliente'=> $telefono,
                'direccion'       => $direccion,
                'ciudad_cliente'  => $ciudad,
                'observaciones'   => $obs
            ]);

            // Éxito
            $_SESSION['exito'] = "Tu solicitud fue enviada exitosamente. Te contactaremos pronto.";
            header('Location: ?accion=home');
            exit;

            break;


        //gestionar reservas

            // 🔄 Verificar disponibilidad
            if ($model->hayCruceDeFechas($ref_finca, $fecha_inicio, $fecha_fin)) {
                echo "<script>
                    alert('La finca ya está reservada en ese rango de fechas.');
                    window.history.back();
                </script>";
                exit;
            }




            // ✉️ Enviar correos
            $stmt = $pdo->prepare("SELECT nombre FROM fincas WHERE ref = ?");
            $stmt->execute([$ref_finca]);
            $finca = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombreFinca = $finca['nombre'] ?? 'Sin nombre';
                        // 💾 Insertar reserva
            $model->crear([
                'ref_finca' => $ref_finca,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'nombre_cliente' => $nombre,
                'email_cliente' => $email,
                'telefono_cliente' => $telefono,
                'direccion' => $direccion,
                'ciudad_cliente' => $ciudad,
                'observaciones' => $obs
            ]);

            // phpmailer

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.tu-servidor.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'reservas@tudominio.com';
                $mail->Password = 'tu-contraseña';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('reservas@tudominio.com', 'Reservas Web');
                $mail->addAddress('admin@tudominio.com', 'Administrador');

                $mail->isHTML(true);
                $mail->Subject = '📢 Nueva solicitud de reserva';
                $mail->Body = "
                    <h3>Reserva solicitada</h3>
                    <p><strong>Cliente:</strong> {$nombre}</p>
                    <p><strong>Correo:</strong> {$email}</p>
                    <p><strong>Teléfono:</strong> {$telefono}</p>
                    <p><strong>Ciudad:</strong> {$ciudad}</p>
                    <p><strong>Finca:</strong> {$nombreFinca} ({$ref_finca})</p>
                    <p><strong>Fechas:</strong> {$fecha_inicio} al {$fecha_fin}</p>
                    <p><strong>Observaciones:</strong> " . nl2br(htmlspecialchars($obs ?: 'Ninguna')) . "</p>
                ";
                $mail->send();
            } catch (Exception $e) {
                // log del error si quieres:
                error_log("Error al enviar correo: {$mail->ErrorInfo}");
            }
// ✉️ Obtener nombre de finca ANTES del correo
$stmt = $pdo->prepare("SELECT nombre FROM fincas WHERE ref = ?");
$stmt->execute([$ref_finca]);
$finca = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreFinca = $finca['nombre'] ?? 'Sin nombre';

// 📬 Enviar correo al admin
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Asegúrate de usar el host correcto
    $mail->SMTPAuth = true;
    $mail->Username = 'reservas@tudominio.com';
    $mail->Password = 'tu-clave-app'; // <-- Aquí va tu clave real
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('reservas@tudominio.com', 'Reservas Web');
    $mail->addAddress('admin@tucorreo.com', 'Administrador');

    $mail->isHTML(true);
    $mail->Subject = '📢 Nueva solicitud de reserva';
    $mail->Body = "
        <h3>Reserva solicitada</h3>
        <p><strong>Cliente:</strong> {$nombre}</p>
        <p><strong>Correo:</strong> {$email}</p>
        <p><strong>Teléfono:</strong> {$telefono}</p>
        <p><strong>Ciudad:</strong> {$ciudad}</p>
        <p><strong>Finca:</strong> {$nombreFinca} ({$ref_finca})</p>
        <p><strong>Fechas:</strong> {$fecha_inicio} al {$fecha_fin}</p>
        <p><strong>Observaciones:</strong> " . nl2br(htmlspecialchars($obs ?: 'Ninguna')) . "</p>
    ";
    $mail->send();
} catch (Exception $e) {
    error_log("Error al enviar correo: {$mail->ErrorInfo}");
}

// ✅ Enviar al cliente y registrar mensaje
$correo->enviarACliente($email, $nombre, $ref_finca, $fecha_inicio, $fecha_fin);
$correo->notificarAlAdmin($ref_finca, $nombre, $email, $fecha_inicio, $fecha_fin);

            

            // 🎉 Mensaje de éxito y redirección
            $_SESSION['exito'] = "Tu solicitud fue enviada exitosamente. Te contactaremos pronto.";
            header('Location: ?accion=fincas');
            exit;
            header('Location: ?accion=reservas');
            exit;


            // Confirmar reserva
        case 'confirmar_reserva':
            require_once __DIR__ . '/../app/models/ReservaModel.php';
            $model = new ReservaModel($pdo);
            $model->actualizarEstado($_GET['id'], 'confirmada');
            header('Location: ?accion=reservas');
            exit;
            break;

        /* Rechazar reserva
        case 'rechazar_reserva':
            require_once __DIR__ . '/../app/models/ReservaModel.php';
            $model = new ReservaModel($pdo);
            $model->rechazar($_GET['id']);
            header('Location: ?accion=reservas');
            exit;
            break;*/
        case 'rechazar_reserva':
            require_once __DIR__ . '/../app/controllers/fincasControl/ReservaController.php';
            require_once __DIR__ . '/../app/services/CorreoService.php';

            $controller = new ReservaController($pdo);
            $correo = new CorreoService();

            $id = $_GET['id'] ?? null;
            if ($id) {
                $reserva = $controller->mostrar($id); // Trae los datos completos

                if ($reserva) {
                    $controller->cambiarEstado($id, 'cancelada'); // Actualiza estado
                    $correo->enviarRechazo(
                        $reserva['email_cliente'],
                        $reserva['nombre_cliente'],
                        $reserva['ref_finca']
                    ); // Envía el correo
                }
            }

            header('Location: ?accion=reservas');
            exit;

        // Eliminar reserva
        case 'eliminar_reserva':
            require_once __DIR__ . '/../app/models/ReservaModel.php';
            $model = new ReservaModel($pdo);
            $model->eliminar($_GET['id']);
            $_SESSION['exito'] = "Tu solicitud fue enviada exitosamente. Te contactaremos pronto.";
            header('Location: ?accion=reservas'); // Redireccionar a la lista de reservas
            exit;
            break;


        // CONSULTAS DE FINCAS

        case 'consulta_fincas':
            require_once __DIR__ . '/../app/models/FincaModel.php';
            $model = new FincaModel($pdo);

            $zona = $_GET['zona'] ?? null;
            $destino = $_GET['destino'] ?? null;

            if ($zona) {
                $fincas = $model->filtrarPorZona($zona);
                $titulo = "Fincas en la zona: $zona";
            } elseif ($destino) {
                $fincas = $model->filtrarPorDestino($destino);
                $titulo = "Fincas en el destino: $destino";
            } else {
                $fincas = $model->leerTodas();
                $titulo = "Todas las fincas disponibles";
            }

            require_once __DIR__ . '/../app/views/fincas/listado.php';
            exit;


    // 🔐 RECUPERAR CONTRASEÑA
    case 'recuperar':
        require_once __DIR__ . '/../app/views/recuperar.php';
        break;

    // 🏠 PÁGINA PRINCIPAL
    default:
        require_once __DIR__ . '/../app/views/home.php';
        break;
}