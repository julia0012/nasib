<?php
// ==========================================
// CONFIGURAÇÃO DE ERROS
// ==========================================
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// ==========================================
// SESSÃO
// ==========================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se o cliente já estiver logado, redireciona direto para a área dele
if (isset($_SESSION['usuario_id']) && (isset($_SESSION['usuario_tipo']) && strtolower($_SESSION['usuario_tipo']) !== 'admin' && strtolower($_SESSION['usuario_tipo']) !== 'adm')) {
    header("Location: usuarios/perfilusuarios.php");
    exit();
}

$mensagem_erro = "";

// ==========================================
// PROCESSAMENTO DO LOGIN
// ==========================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Dados do banco de dados
    $host = 'localhost';
    $dbname = 'nasib';
    $usuario = 'root';
    $senha = ''; 

    try {
        // ==========================================
        // CONEXÃO COM O BANCO
        // ==========================================
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $usuario,
            $senha,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        // ==========================================
        // PEGA OS DADOS DO FORMULÁRIO
        // ==========================================
        $login_input = trim($_POST['login_input'] ?? '');
        $senha       = $_POST['senha'] ?? '';

        // ==========================================
        // VERIFICA CAMPOS VAZIOS
        // ==========================================
        if ($login_input === '' || $senha === '') {
            $mensagem_erro = "Preencha o e-mail, login ou WhatsApp e a senha.";
        } else {

            // ==========================================
            // LIMPA O TELEFONE
            // ==========================================
            $telefone_limpo = preg_replace('/\D/', '', $login_input);

            // ==========================================
            // BUSCA O USUÁRIO NA TABELA 'usuarios' OU 'cadastro'
            // ==========================================
            $sql = "
                SELECT *
                FROM usuarios
                WHERE email = :email
                   OR login = :login
                   OR telefone = :telefone
                   OR telefone = :telefone_limpo
                LIMIT 1
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':email'          => $login_input,
                ':login'          => $login_input,
                ':telefone'       => $login_input,
                ':telefone_limpo' => $telefone_limpo
            ]);

            $usuario = $stmt->fetch();

            // ==========================================
            // USUÁRIO NÃO ENCONTRADO OU SENHA INCORRETA
            // ==========================================
            if (!$usuario || !isset($usuario['senha']) || empty($usuario['senha']) || !password_verify($senha, $usuario['senha'])) {
                $mensagem_erro = "E-mail, WhatsApp ou senha incorretos!";
            } else {

                // Regenera o ID da sessão por segurança
                session_regenerate_id(true);

                // ==========================================
                // CRIA AS SESSÕES DO CLIENTE
                // ==========================================
                $_SESSION['usuario_id']   = $usuario['id'] ?? $usuario['id_admin'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['nivel_acesso'] ?? 'cliente';
                $_SESSION['usuario_tel']  = $usuario['telefone'] ?? '';

                // ==========================================
                // REDIRECIONAMENTO PARA A ÁREA DO CLIENTE
                // ==========================================
                header("Location: usuarios/perfilusuarios.php");
                exit();
            }
        }

    } catch (PDOException $e) {
        $mensagem_erro = "Erro ao acessar o sistema. Verifique a conexão com o banco.";
        if (ini_get('display_errors')) {
            $mensagem_erro .= "<br><small>" . htmlspecialchars($e->getMessage()) . "</small>";
        }
    } catch (Exception $e) {
        $mensagem_erro = "Erro no sistema.";
        if (ini_get('display_errors')) {
            $mensagem_erro .= "<br><small>" . htmlspecialchars($e->getMessage()) . "</small>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Cliente - NASIB CLOTHING</title>
    
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
            --white: #ffffff;
            --danger: #ff3333;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--rose-light), var(--cream), var(--rose-border));
            color: var(--charcoal);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: var(--white);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--rose-border);
            box-shadow: 0 2px 10px rgba(194, 89, 127, 0.05);
        }

        .logo-texto {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--charcoal);
            text-decoration: none;
        }

        .nav-menu a {
            color: var(--charcoal);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .nav-menu a:hover {
            color: var(--rose-primary);
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(194, 89, 127, 0.1);
            width: 100%;
            max-width: 450px;
            border-top: 5px solid var(--rose-primary);
            border-left: 1px solid var(--rose-border);
        }

        h2 {
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            color: var(--charcoal);
            margin: 0 0 8px 0;
            letter-spacing: 1px;
        }

        .subtitulo {
            text-align: center;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--charcoal);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            color: var(--rose-primary);
            font-size: 15px;
        }

        input {
            width: 100%;
            background-color: #ffffff;
            border: 1px solid var(--rose-border);
            padding: 14px 14px 14px 45px;
            border-radius: 50px;
            color: var(--charcoal);
            font-size: 14px;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        input:focus {
            outline: none;
            border-color: var(--rose-primary);
            box-shadow: 0 0 0 3px rgba(194, 89, 127, 0.15);
        }

        .alert-error {
            background-color: rgba(255, 51, 53, 0.1);
            color: var(--danger);
            border: 1px solid rgba(255, 51, 53, 0.2);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
        }

        button {
            width: 100%;
            background-color: var(--rose-primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 4px 12px rgba(194, 89, 127, 0.3);
            margin-top: 10px;
        }

        button:hover {
            background-color: var(--rose-hover);
            transform: translateY(-1px);
        }

        .links-uteis {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            border-top: 1px solid var(--rose-border);
            padding-top: 20px;
            color: var(--text-muted);
        }

        .links-uteis a {
            color: var(--rose-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .links-uteis a:hover {
            color: var(--rose-hover);
            text-decoration: underline;
        }

        .footer {
            background-color: transparent;
            color: var(--text-muted);
            text-align: center;
            padding: 20px;
            font-size: 12px;
            border-top: 1px solid var(--rose-border);
        }
    </style>
</head>

<body>

    <!-- CABEÇALHO -->
    <div class="header">
        <a href="index.php" class="logo-texto">
            NASIB CLOTHING
        </a>
        <div class="nav-menu">
            <a href="/nasib/index.php"><i class="fas fa-home"></i> Home</a>
        </div>
    </div>

    <!-- CONTEÚDO -->
    <div class="main-content">
        <div class="login-container">

            <h2>Acessar Conta</h2>
            <div class="subtitulo">
                Entre para acompanhar seus pedidos e dados
            </div>

            <!-- MENSAGEM DE ERRO -->
            <?php if (!empty($mensagem_erro)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $mensagem_erro; ?>
                </div>
            <?php endif; ?>

            <!-- FORMULÁRIO -->
            <form action="" method="POST">

                <div class="form-group">
                    <label for="login_input">E-mail ou WhatsApp</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="login_input" name="login_input" placeholder="Seu e-mail ou celular" required autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="senha">Senha de Acesso</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="senha" name="senha" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                </div>
                 <a href="perfilusuarios.php">
                <button type="submit">
                    Entrar na Conta
                </button>

            </form>

            <!-- CADASTRO -->
            <div class="links-uteis">
                Ainda não tem cadastro? 
                <a href="cadastro.php">
                    Cadastre-se aqui
                </a>
            </div>

        </div>
    </div>

    <!-- RODAPÉ -->
    <div class="footer">
        &copy; 2026 NASIB CLOTHING. Todos os direitos reservados.
    </div>

</body>
</html>