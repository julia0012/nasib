<?php
session_start();
require('../config/config.php');
$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipo = 'cliente'; // Por segurança, novos cadastros pelo site são sempre clientes

    // Verifica se o e-mail já está cadastrado
    $sql_verifica = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado_verifica = $conn->query($sql_verifica);

    if ($resultado_verifica && $resultado_verifica->num_rows > 0) {
        $erro = "Este e-mail já está cadastrado. Tente fazer login.";
    } else {
        // Criptografa a senha para segurança
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o novo cliente no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha_criptografada', '$tipo')";

        if ($conn->query($sql) === TRUE) {
            $sucesso = "Cadastro realizado com sucesso! Redirecionando para o login...";
            // Redireciona para a página de login após 2 segundos
            header("refresh:2;url=login.php");
        } else {
            $erro = "Erro ao cadastrar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - NASIB CLOTHING</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rose: {
                            50: '#FFF5F7',
                            100: '#FFEBF0',
                            200: '#FFD6E0',
                            300: '#FFB6C1',
                            400: '#F48FB1',
                            500: '#D87093',
                            600: '#C2597F',
                            700: '#A03D61',
                        },
                        cream: {
                            50: '#FAF8F5',
                            100: '#F5F0EB',
                            200: '#EBE3DB',
                        },
                        charcoal: '#2D2926',
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-r from-rose-50 via-cream-50 to-rose-100 font-sans text-charcoal min-h-screen flex flex-col justify-between">

    <!-- Cabeçalho -->
    <header class="py-6 text-center">
        <a href="index.php" class="font-serif text-3xl font-bold tracking-widest text-charcoal hover:text-rose-600 transition">
            NASIB CLOTHING
        </a>
        <div class="nav-menu">
            <a href="/nasib/index.php"><i class="fas fa-home"></i> Home</a>
        </div>
    </header>

    <!-- Formulário Principal -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-white/80 backdrop-blur-md p-8 rounded-3xl shadow-xl border border-rose-100/60">
            
            <div class="text-center mb-8">
                <h2 class="font-serif text-3xl font-bold text-charcoal mb-2">Crie sua Conta</h2>
                <p class="text-xs text-gray-500 uppercase tracking-widest">Junte-se à NASIB CLOTHING</p>
            </div>

            <!-- Exibição de Erro -->
            <?php if (!empty($erro)) { ?>
                <div class="mb-6 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs text-center font-semibold">
                    <?php echo $erro; ?>
                </div>
            <?php } ?>

            <!-- Exibição de Sucesso -->
            <?php if (!empty($sucesso)) { ?>
                <div class="mb-6 p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs text-center font-semibold">
                    <?php echo $sucesso; ?>
                </div>
            <?php } ?>
            
            <!-- Formulário de Cadastro -->
            <form method="POST" action="" class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal mb-2">Nome Completo</label>
                    <input type="text" name="nome" required 
                        class="w-full px-4 py-3 text-sm rounded-full bg-white border border-rose-200 focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-100 transition shadow-sm"
                        placeholder="Seu nome">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal mb-2">E-mail</label>
                    <input type="email" name="email" required 
                        class="w-full px-4 py-3 text-sm rounded-full bg-white border border-rose-200 focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-100 transition shadow-sm"
                        placeholder="seu@email.com">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal mb-2">Senha</label>
                    <input type="password" name="senha" required 
                        class="w-full px-4 py-3 text-sm rounded-full bg-white border border-rose-200 focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-100 transition shadow-sm"
                        placeholder="••••••••">
                </div>
                
                <button type="submit" 
                    class="w-full mt-2 py-3 px-6 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs tracking-widest uppercase transition shadow-md hover:shadow-lg">
                    Cadastrar
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-600">
                    Já tem uma conta? 
                    <a href="logincliente.php" class="text-rose-600 font-semibold hover:underline">Faça login</a>
                </p>
            </div>

        </div>
    </main>

    <!-- Rodapé -->
    <footer class="py-6 text-center text-xs text-gray-500 border-t border-rose-100/50">
        &copy; 2026 NASIB CLOTHING. Todos os direitos reservados.
    </footer>

</body>
</html>