<?php
session_start();
require('config/config.php');

// Verifica se o usuário está logado e se é cliente (ou redireciona para o login)
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'cliente') {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];

// Consulta simulada para buscar os pedidos do cliente no banco de dados
// Nota: Certifique-se de ter uma tabela 'pedidos' com colunas como: id, usuario_id, produto, forma_pagamento, rastreio, status, data
$sql_pedidos = "SELECT * FROM pedidos WHERE usuario_id = '$usuario_id' ORDER BY id DESC";
$resultado_pedidos = $conn->query($sql_pedidos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - NASIB CLOTHING</title>
    
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

    <!-- Cabeçalho do Painel -->
    <header class="bg-white/80 backdrop-blur-md border-b border-rose-100 py-4 px-6 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="index.php" class="font-serif text-2xl font-bold tracking-widest text-charcoal hover:text-rose-600 transition">
                NASIB CLOTHING
            </a>
            <div class="flex items-center space-x-4">
                <span class="text-xs font-semibold text-gray-600 hidden sm:inline">Olá, <strong class="text-charcoal"><?php echo htmlspecialchars($usuario_nome); ?></strong></span>
                <a href="logout.php" class="px-4 py-2 text-xs font-bold uppercase tracking-wider bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-full transition">
                    Sair
                </a>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="flex-grow max-w-5xl w-full mx-auto px-4 py-10">
        
        <div class="mb-8">
            <h1 class="font-serif text-3xl font-bold text-charcoal">Meus Pedidos</h1>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Acompanhe suas compras, pagamentos e rastreios</p>
        </div>

        <!-- Lista de Pedidos -->
        <div class="space-y-6">
            <?php 
            if ($resultado_pedidos && $resultado_pedidos->num_rows > 0) {
                while($pedido = $resultado_pedidos->fetch_assoc()) {
            ?>
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-md border border-rose-100/80 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    
                    <!-- Informações do Produto -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-100">
                            Pedido #<?php echo $pedido['id']; ?>
                        </span>
                        <h3 class="font-serif text-xl font-bold text-charcoal mt-2"><?php echo htmlspecialchars($pedido['produto']); ?></h3>
                        <p class="text-xs text-gray-500">Data da compra: <?php echo date('d/m/Y', strtotime($pedido['data'] ?? 'now')); ?></p>
                    </div>

                    <!-- Forma de Pagamento -->
                    <div class="text-left md:text-center">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Pagamento</span>
                        <span class="text-xs font-semibold text-charcoal bg-cream-100 px-3 py-1 rounded-full inline-block mt-1">
                            💳 <?php echo htmlspecialchars($pedido['forma_pagamento']); ?>
                        </span>
                    </div>

                    <!-- Código de Rastreio -->
                    <div class="text-left md:text-right">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Rastreamento</span>
                        <div class="mt-1 flex items-center space-x-2">
                            <span class="text-xs font-mono font-bold bg-rose-50 text-rose-700 px-3 py-1 rounded-lg border border-rose-200">
                                <?php echo !empty($pedido['rastreio']) ? htmlspecialchars($pedido['rastreio']) : 'Gerando rastreio...'; ?>
                            </span>
                        </div>
                    </div>

                </div>
            <?php 
                }
            } else {
            ?>
                <!-- Estado Vazio (Caso não tenha comprado nada ainda) -->
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-12 text-center border border-rose-100">
                    <p class="font-serif text-xl text-gray-600 mb-2">Você ainda não realizou nenhuma compra.</p>
                    <p class="text-xs text-gray-400 mb-6">Explore nossos lançamentos e monte seu estilo!</p>
                    <a href="index.php#produtos" class="inline-block py-3 px-8 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs tracking-widest uppercase transition shadow-md">
                        Ver Lançamentos
                    </a>
                </div>
            <?php } ?>
        </div>

    </main>

    <!-- Rodapé -->
    <footer class="py-6 text-center text-xs text-gray-500 border-t border-rose-100/50">
        &copy; 2026 NASIB CLOTHING. Todos os direitos reservados.
    </footer>

</body>
</html>