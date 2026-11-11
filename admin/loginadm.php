
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se o administrador já estiver logado, redireciona para o perfil
if (
    isset($_SESSION['usuario_nivel_acesso']) &&
    in_array(strtolower($_SESSION['usuario_nivel_acesso']), ['admin', 'adm', 'administrador'], true)
) {
    header("Location: perfil.php");
    exit();
}

$erro = "";

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email_digitado = trim($_POST['email'] ?? '');
    $senha_digitada = $_POST['senha'] ?? '';

    if ($email_digitado === '' || $senha_digitada === '') {
        $erro = "Preencha o e-mail e a senha.";
    } 
        try {
            // Conexão com o banco
            $host = 'localhost';
            $dbname = 'nasib';
            $db_usuario = 'root';
            $db_senha = '';

            $pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $db_usuario,
                $db_senha,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            // Busca o administrador pelo e-mail
            // ATENÇÃO: esta consulta considera que a tabela se chama administradores.
            $sql = "SELECT * FROM administradores WHERE email = :email LIMIT 1";

            $consulta = $pdo->prepare($sql);
            $consulta->execute(['email' => $email_digitado]);

            $admin = $consulta->fetch();

            if (!$admin) {
                $erro = "E-mail ou senha incorretos.";
            } elseif (
                !in_array(
                    strtolower(trim($admin['nivel_acesso'] ?? '')),
                    ['admin', 'adm', 'administrador'],
                    true
                )
            ) {
                $erro = "Acesso negado. Esta conta não é de administrador.";
            } else {

                $senha_banco = $admin['senha'] ?? '';

                // Aceita senha com hash ou senha antiga em texto puro
                $senha_valida = password_verify($senha_digitada, $senha_banco)
                    || hash_equals((string)$senha_banco, (string)$senha_digitada);

                if ($senha_valida) {
                    session_regenerate_id(true);

                    $_SESSION['usuario_id'] = $admin['id_admin'] ?? $admin['id'] ?? null;
                    $_SESSION['usuario_nome'] = $admin['nome'] ?? 'Administrador';
                    $_SESSION['usuario_tipo'] = $admin['nivel_acesso'];
                    $_SESSION['usuario_nivel_acesso'] = $admin['nivel_acesso'];

                    header("Location: perfil.php");
                    exit();
                } else {
                    $erro = "E-mail ou senha incorretos.";
                }
            }

        } catch (PDOException $e) {
            $erro = "Erro ao acessar o banco de dados: " . $e->getMessage();
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - NASIB CLOTHING</title>
    
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

        /* Centralização perfeita adicionada aqui */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            width: 100%;
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
            text-align: center; /* Centraliza os textos e ícones dentro do card */
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
            text-align: left; /* Mantém os inputs alinhados à esquerda para boa leitura */
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

    <div class="main-content">
        <div class="login-container">
            <div class="login-header">
                <i class="fas fa-user-shield" style="font-size: 45px; color: var(--rose-primary); margin-bottom: 15px;"></i>
                <h2>Nasib Clothing</h2>
                <div class="subtitulo">Área Restrita — Painel Administrativo</div>
            </div>

            <?php if (!empty($erro)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($erro); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-login">
                
                <div class="form-group">
                    <label for="email">E-mail do Administrador</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-input" placeholder="nasib@email.com" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="senha">Senha de Acesso</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="senha" name="senha" class="form-input" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                </div>

                <button type="submit" class="btn-login">Entrar no Painel</button>
            </form>

            <a href="/nasib/index.php" class="back-to-site" style="display: inline-block; margin-top: 25px; font-size: 13px; color: var(--rose-primary); font-weight: 600; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Voltar para a Loja
            </a>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2026 NASIB CLOTHING. Todos os direitos reservados.</p>
    </div>

</body>
</html>