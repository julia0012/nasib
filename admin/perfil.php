
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexão centralizada
require_once __DIR__ . '/../config/config.php';

// Proteção do painel administrativo
$nivel_usuario = strtolower(
    $_SESSION['usuario_tipo'] ??
    $_SESSION['usuario_nivel'] ??
    $_SESSION['usuario_nivel_acesso'] ??
    ''
);

if (!isset($_SESSION['usuario_id']) || !in_array($nivel_usuario, ['admin', 'adm', 'administrador'], true)) {
    header('Location: ../loginadm.php');
    exit;
}

$nome_adm = htmlspecialchars($_SESSION['usuario_nome'] ?? 'Administrador');

// Verifica se a conexão PDO existe
if (!isset($pdo) || !($pdo instanceof PDO)) {
    die("Erro: a conexão PDO não foi encontrada em config/config.php.");
}

try {
    // Busca os clientes
    $query_clientes = "
        SELECT *
        FROM usuarios
        WHERE LOWER(nivel_acesso) = 'cliente'
    ";

    $consulta_clientes = $pdo->prepare($query_clientes);
    $consulta_clientes->execute();

    $resultado_clientes = $consulta_clientes;

    // Busca os últimos pedidos
    $query_pedidos = "
        SELECT *
        FROM pedidos
        ORDER BY data_pedido DESC
        LIMIT 10
    ";

    $consulta_pedidos = $pdo->prepare($query_pedidos);
    $consulta_pedidos->execute();

    $resultado_pedidos = $consulta_pedidos;
    $tabela_pedidos_existe = true;

} catch (PDOException $e) {
    error_log("Erro no painel administrativo: " . $e->getMessage());

    $resultado_clientes = false;
    $resultado_pedidos = false;
    $tabela_pedidos_existe = false;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - NASIB CLOTHING</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --rose-primary: #C2597F;
            --rose-hover: #A03D61;
            --rose-light: #FFF5F7;
            --rose-border: #FFD6E0;
            --cream: #FAF8F5;
            --charcoal: #2D2926;
            --text-muted: #666666;
            --white-real: #ffffff;
            --danger: #ff3333;
            --success: #25d366;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--cream);
            color: var(--charcoal);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        header {
            background-color: var(--white-real);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 60px;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--rose-border);
            box-shadow: 0 4px 12px rgba(194, 89, 127, 0.05);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        h1.brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--charcoal);
            text-transform: uppercase;
        }

        .nav-menu {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-menu a {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--charcoal);
            transition: color 0.3s ease;
        }

        .nav-menu a:hover, .nav-menu a.active {
            color: var(--rose-primary);
        }

        .dropdown-conta {
            position: relative;
            display: inline-block;
        }

        .menu-conta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 10px 18px; 
            background: var(--rose-light);
            border-radius: 50px;
            border: 1px solid var(--rose-border);
            transition: background 0.2s ease;
        }

        .menu-conta:hover {
            background: var(--rose-border);
        }

        .dropdown-conteudo {
            display: none;
            position: absolute;
            right: 0;
            background-color: var(--white-real);
            min-width: 180px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
            z-index: 1100;
            margin-top: 10px;
            border: 1px solid var(--rose-border);
        }

        .dropdown-conteudo a {
            color: var(--charcoal) !important;
            padding: 12px 16px; 
            font-size: 13px !important;
            text-transform: none !important;
            font-weight: 500 !important;
            display: flex !important;
            align-items: center;
            gap: 10px;
            transition: background 0.2s ease;
        }

        .dropdown-conteudo a:hover {
            background-color: var(--rose-light);
            color: var(--rose-primary) !important;
        }

        .dropdown-conta:hover .dropdown-conteudo,
        .dropdown-conta:focus-within .dropdown-conteudo {
            display: block;
        }

        main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            flex: 1;
            width: 100%;
        }

        .welcome-box {
            background: linear-gradient(135deg, var(--rose-primary), var(--rose-hover));
            color: var(--white-real);
            padding: 35px;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 10px 25px rgba(194, 89, 127, 0.2);
        }

        .welcome-box h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .welcome-box p {
            opacity: 0.9;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .dashboard-section {
            background-color: var(--white-real);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border-top: 5px solid var(--rose-primary);
            border-left: 1px solid var(--rose-border);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            border-bottom: 2px dashed var(--rose-light);
            padding-bottom: 15px;
        }

        .section-header i {
            font-size: 22px;
            color: var(--rose-primary);
        }

        .section-header h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            color: var(--charcoal);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: var(--rose-light);
            color: var(--charcoal);
            padding: 14px 16px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--rose-border);
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--rose-border);
            color: var(--charcoal);
        }

        tr:hover td {
            background-color: var(--cream);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-ativo {
            background-color: rgba(37, 211, 102, 0.15);
            color: #1b9e42;
        }

        .btn-action {
            padding: 8px 14px; 
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-cancel {
            background-color: rgba(255, 51, 53, 0.1);
            color: var(--danger);
        }

        .btn-cancel:hover {
            background-color: var(--danger);
            color: var(--white-real);
        }

        footer {
            background-color: var(--white-real);
            color: var(--text-muted);
            padding: 25px 20px;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid var(--rose-border);
            margin-top: auto;
        }

        @media (max-width: 850px) {
            header { padding: 15px 20px; flex-direction: column; gap: 15px; text-align: center;}
            .nav-menu { flex-direction: column; gap: 12px; width: 100%; }
            .dropdown-conta { width: 100%; }
            .menu-conta { display: flex; width: 100%; justify-content: center; padding: 12px; }
            .dropdown-conteudo { width: 100%; position: relative; margin-top: 5px; box-shadow: none; border: 1px solid var(--rose-border); }
        }
    </style>
</head>
<body>

    <header>
        <div class="header-brand">
            <h1 class="brand-title">Nasib Clothing</h1>
        </div>

        <nav class="nav-menu">
            <a href="#" class="active">Painel Administrativo</a>
            
         <div class="dropdown-conta">

    <button type="button" class="menu-conta">
        <i class="fas fa-user-shield" style="color: var(--rose-primary);"></i>
        <span><?php echo $nome_adm; ?></span>
        <i class="fas fa-caret-down"></i>
    </button>

    <div class="dropdown-conteudo">

        <a href="/nasib/index.php">
            <i class="fas fa-tachometer-alt"></i>
            Ver Loja 
        </a>

        <a href="/nasib/logout.php" style="color: var(--danger) !important;">
            <i class="fas fa-sign-out-alt"></i>
            Sair
        </a>

    </div>
</div>
        </nav>
    </header>

    <!-- SEÇÃO DE PEDIDOS -->
<section class="dashboard-section">

    <div class="section-header">
        <i class="fas fa-shopping-bag"></i>
        <h3>Pedidos e Endereços de Entrega</h3>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nº do Pedido</th>
                    <th>Cliente</th>
                    <th>Endereço de Entrega</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Valor Total</th>
                </tr>
            </thead>

            <tbody>

                <?php if ($resultado_pedidos && $resultado_pedidos->rowCount() > 0): ?>

                    <?php while ($pedido = $resultado_pedidos->fetch(PDO::FETCH_ASSOC)): ?>

                        <tr>
                            <td>
                                #<?php echo htmlspecialchars($pedido['id_pedidos'] ?? ''); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($pedido['id_clientes'] ?? ''); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($pedido['endereco'] ?? 'Endereço não informado'); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($pedido['data_pedido'] ?? ''); ?>
                            </td>

                            <td>
                                <span class="badge badge-ativo">
                                    <?php echo htmlspecialchars($pedido['status_pedido'] ?? 'Pendente'); ?>
                                </span>
                            </td>

                            <td>
                                R$ <?php echo number_format((float)($pedido['valor_total'] ?? 0), 2, ',', '.'); ?>
                            </td>
                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" style="text-align:center; color: var(--text-muted);">
                            Nenhum pedido cadastrado no momento.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>

</section>

    <footer>
        <p>&copy; 2026 NASIB CLOTHING. Todos os direitos reservados.</p>
        <p>Painel Administrativo Restrito</p>
    </footer>

</body>
</html>