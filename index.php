<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nasib Clothing</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

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

    <style>
        /* Estilos personalizados para suave transição */
        .glass-header {
            background: rgba(250, 248, 245, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #FAF8F5;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #FFD6E0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #FFB6C1;
        }

        .cart-drawer-overlay {
            transition: opacity 0.3s ease-in-out;
        }
        .cart-drawer-content {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-cream-50 text-charcoal font-sans antialiased selection:bg-rose-200 selection:text-rose-700 flex flex-col min-h-screen">

    <!-- Top Announcement Bar -->
    <div class="bg-rose-300 text-charcoal text-xs tracking-wider uppercase font-medium py-2 px-4 text-center flex items-center justify-center gap-2 shadow-sm">
        <span>EM BREVE,LOJA ABERTA</span>
        <span class="hidden md:inline"></span>
    </div>

   <!-- Header Navigation -->
<header class="sticky top-0 z-40 glass-header border-b border-rose-100/60 transition-all duration-200 bg-white/80 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-full text-charcoal hover:bg-rose-100/50 transition">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <!-- Brand Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="#" class="group text-center">
                    <span class="font-serif text-2xl sm:text-3xl font-bold tracking-widest text-charcoal block group-hover:text-rose-600 transition">NASIB CLOTHING</span>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="#hero" class="text-sm font-medium hover:text-rose-500 transition relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-rose-400 hover:after:w-full after:transition-all">Início</a>
                <a href="#produtos" class="text-sm font-medium hover:text-rose-500 transition relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-rose-400 hover:after:w-full after:transition-all">Lançamentos</a>
                <a href="#categorias" class="text-sm font-medium hover:text-rose-500 transition relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-rose-400 hover:after:w-full after:transition-all">Coleções</a>
                <a href="#about" class="text-sm font-medium hover:text-rose-500 transition relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-rose-400 hover:after:w-full after:transition-all">Sobre Nós</a>
            </nav>

            <!-- Actions: Search, User Account, Wishlist, Cart -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Search Input Widget -->
                <div class="relative hidden sm:block">
                    <input type="text" id="search-input" placeholder="Buscar produtos..." 
                        class="w-36 lg:w-48 pl-9 pr-4 py-2 text-xs rounded-full bg-white border border-rose-200 focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-100 transition shadow-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"></i>
                </div>

                <!-- Botão CONTA com Menu Dropdown de Login e Cadastro -->
                <div class="relative group">
                    <button id="user-menu-btn" class="flex items-center space-x-2 px-4 py-2 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold tracking-wider transition shadow-sm cursor-pointer">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>CONTA</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-rose-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <a href="usuarios/logincliente.php" class="flex items-center px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition">
                            <i data-lucide="log-in" class="w-4 h-4 mr-2.5 text-rose-500"></i>
                            Entrar (Login)
                        </a>
                        <a href="usuarios/cadastro.php" class="flex items-center px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition border-t border-gray-100">
                            <i data-lucide="user-plus" class="w-4 h-4 mr-2.5 text-rose-500"></i>
                            Criar Conta
                        </a>
                        <a href="admin/loginadm.php" class="flex items-center px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition">
                            <i data-lucide="log-in" class="w-4 h-4 mr-2.5 text-rose-500"></i>
                            Login Admin (Login)
                        </a>
                    </div>
                </div>

                <!-- Wishlist Button -->
                <button id="wishlist-btn" class="relative p-2.5 rounded-full hover:bg-rose-100/60 text-charcoal hover:text-rose-600 transition" title="Favoritos">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                    <span id="wishlist-count" class="absolute top-1 right-1 bg-rose-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center opacity-0 transition-opacity">0</span>
                </button>

                <!-- Shopping Cart Trigger -->
                <button id="cart-toggle-btn" class="relative p-2.5 rounded-full bg-rose-200 hover:bg-rose-300 text-charcoal transition shadow-sm flex items-center justify-center" title="Carrinho de Compras">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-rose-700"></i>
                    <span id="cart-badge" class="absolute -top-1 -right-1 bg-rose-600 text-white text-[11px] font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white">0</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Search Dropdown (sm only) -->
    <div class="sm:hidden px-4 pb-3">
        <div class="relative">
            <input type="text" id="search-input-mobile" placeholder="Buscar vestidos, bolsas, acessórios..." 
                class="w-full pl-9 pr-4 py-2 text-xs rounded-full bg-white border border-rose-200 focus:outline-none focus:border-rose-400">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"></i>
        </div>
    </div>

    <!-- Mobile Navigation Menu Dropdown -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-rose-100 bg-cream-50 px-4 pt-3 pb-6 space-y-3">
        <a href="#hero" class="block py-2 text-base font-medium text-charcoal hover:text-rose-600 border-b border-rose-100/50">Início</a>
        <a href="#produtos" class="block py-2 text-base font-medium text-charcoal hover:text-rose-600 border-b border-rose-100/50">Lançamentos</a>
        <a href="#categorias" class="block py-2 text-base font-medium text-charcoal hover:text-rose-600 border-b border-rose-100/50">Coleções</a>
        <a href="#about" class="block py-2 text-base font-medium text-charcoal hover:text-rose-600 border-b border-rose-100/50">Sobre Nós</a>
        <div class="pt-2 flex flex-col space-y-2">
            <a href="login.php" class="text-center py-2 text-sm font-semibold text-white bg-rose-600 rounded-full hover:bg-rose-700 transition">Entrar</a>
            <a href="usuarios/cadastro.php" class="text-center py-2 text-sm font-semibold text-rose-600 bg-rose-100 rounded-full hover:bg-rose-200 transition">Criar Conta</a>
        <a href="admin/loginadm.php" class="text-center py-2 text-sm font-semibold text-white bg-rose-600 rounded-full hover:bg-rose-700 transition">Login adm</a>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-grow">
    
    <!-- Hero Banner Section -->
    <section id="hero" class="relative overflow-hidden bg-gradient-to-r from-rose-100 via-rose-50 to-cream-100 py-16 md:py-24">
        <!-- Decorative Subtle Blur Circles -->
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-rose-200 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-rose-300 rounded-full blur-3xl opacity-30 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Text Content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-rose-200/70 border border-rose-300 text-rose-700 text-xs font-semibold uppercase tracking-widest">
                        EM BREVE, LOJA ABERTA
                    </span>
                        <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-charcoal font-bold leading-tight tracking-tight">
                            Vista a sua melhor versão e faça do mundo a sua passarela.
                        </h1>
                        <p class="text-gray-600 text-base sm:text-lg max-w-xl mx-auto lg:mx-0 font-light leading-relaxed">
                            Nem tudo o que você veste precisa fazer sentido para os outros, desde que faça sentido para você. Crie suas próprias regras, misture tendências e mostre sua autenticidade todos os dias.
                        </p>
                        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                            <a href="#produtos" class="w-full sm:w-auto px-8 py-4 bg-rose-500 hover:bg-rose-600 text-white rounded-full font-medium text-sm tracking-wide shadow-lg shadow-rose-200/50 hover:shadow-xl transition duration-300 text-center transform hover:-translate-y-0.5">
                                Explorar Coleção
                            </a>
                            <a href="#categorias" class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-rose-50 border border-rose-200 text-charcoal rounded-full font-medium text-sm tracking-wide transition text-center">
                                Ver Categorias
                            </a>
                        </div>
                    </div>

                    <!-- Highlight Featured Card -->
                    <div class="lg:col-span-5">
                        <div class="relative max-w-md mx-auto bg-white p-4 rounded-3xl shadow-xl border border-rose-100 group">
                            <div class="aspect-[4/5] rounded-2xl overflow-hidden relative bg-rose-50">
                                <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=800&q=80" 
                                    alt="Vestido Seda Rosé" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-rose-600 uppercase tracking-wider">
                                    Destaque
                                </div>
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div>
                                    <h3 class="font-serif text-xl font-bold text-charcoal">Vestido Midi Seda Floral</h3>
                                    <p class="text-xs text-gray-500">Tecido 100% puro leve</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-rose-600 font-bold text-lg">R$ 389,90</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Category Filters -->
        <section id="categorias" class="py-12 bg-white border-b border-rose-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="font-serif text-2xl md:text-3xl font-bold text-charcoal">Categorias em Destaque</h2>
                    <span class="text-xs text-rose-500 font-semibold cursor-pointer hover:underline" id="reset-filter">Ver todas as categorias</span>
                </div>

                <div id="category-pills" class="flex items-center gap-3 overflow-x-auto pb-4 custom-scrollbar">
                    <button data-category="todos" class="category-pill active bg-rose-500 text-white px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider whitespace-nowrap shadow-sm transition">
                        Todos
                    </button>
                    <button data-category="vestidos" class="category-pill bg-rose-50 text-charcoal hover:bg-rose-100 px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider whitespace-nowrap border border-rose-200/60 transition">
                        Vestidos
                    </button>
                    <button data-category="acessorios" class="category-pill bg-rose-50 text-charcoal hover:bg-rose-100 px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider whitespace-nowrap border border-rose-200/60 transition">
                        Saias
                    </button>
                    <button data-category="calcados" class="category-pill bg-rose-50 text-charcoal hover:bg-rose-100 px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider whitespace-nowrap border border-rose-200/60 transition">
                        Calças
                    </button>
                    <button data-category="beleza" class="category-pill bg-rose-50 text-charcoal hover:bg-rose-100 px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider whitespace-nowrap border border-rose-200/60 transition">
                        Body
                    </button>
                    <button data-category="novidades" class="category-pill bg-rose-50 text-charcoal hover:bg-rose-100 px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider whitespace-nowrap border border-rose-200/60 transition">
                        Novidades ✨
                    </button>
                </div>
            </div>
        </section>

        <!-- Product Grid Section -->
        <section id="produtos" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs uppercase tracking-widest text-rose-500 font-semibold">Nossa Seleção</span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold text-charcoal">Produtos Mais Desejados</h2>
                </div>
                <p class="text-xs text-gray-500" id="product-count-text">Exibindo 8 produtos</p>
            </div>

            <!-- Grid container -->
            <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- Injected dynamically via JS -->
            </div>
        </section>

        <!-- Boutique Features Banner -->
        <section class="py-12 bg-rose-100/50 border-y border-rose-200/60 my-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="flex items-center space-x-4 p-4 bg-white/60 rounded-2xl backdrop-blur-sm border border-white">
                        <div class="p-3 bg-rose-200 rounded-xl text-rose-700">
                            <i data-lucide="truck" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-charcoal">Entrega Expressa</h4>
                            <p class="text-xs text-gray-500">Envios para toda a região</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-4 bg-white/60 rounded-2xl backdrop-blur-sm border border-white">
                        <div class="p-3 bg-rose-200 rounded-xl text-rose-700">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-charcoal">Compra Segura</h4>
                            <p class="text-xs text-gray-500">Garantia e criptografia</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-4 bg-white/60 rounded-2xl backdrop-blur-sm border border-white">
                        <div class="p-3 bg-rose-200 rounded-xl text-rose-700">
                            <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-charcoal">Devolução </h4>
                            <p class="text-xs text-gray-500">Até 20 dias após a entrega</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-4 bg-white/60 rounded-2xl backdrop-blur-sm border border-white">
                        <div class="p-3 bg-rose-200 rounded-xl text-rose-700">
                            <i data-lucide="gift" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-charcoal">Embalagem Especial</h4>
                            <p class="text-xs text-gray-500">Embalagem Exclusiva</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter Subscription Section -->
        <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-rose-200 via-rose-100 to-cream-100 rounded-3xl p-8 sm:p-12 md:p-16 text-center overflow-hidden border border-rose-200/80 shadow-sm">
                <div class="max-w-2xl mx-auto space-y-4 relative z-10">
                    <span class="text-xs uppercase tracking-widest text-rose-700 font-bold">Clube Nasib</span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold text-charcoal">Receba 10% OFF na primeira compra</h2>
                    <p class="text-gray-600 text-sm sm:text-base font-light">
                        Inscreva-se em nossa newsletter VIP para receber convites para vendas privadas, prévia de coleções e conselhos de estilo exclusivos.
                    </p>
                    <form id="newsletter-form" class="mt-6 flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                        <input type="email" required placeholder="Digite seu melhor e-mail" 
                            class="flex-1 px-5 py-3.5 rounded-full text-xs sm:text-sm bg-white border border-rose-200 focus:outline-none focus:ring-2 focus:ring-rose-400">
                        <button type="submit" class="px-8 py-3.5 bg-rose-600 hover:bg-rose-700 text-white rounded-full font-medium text-xs sm:text-sm uppercase tracking-wider transition shadow-md">
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-rose-100 pt-16 pb-8 text-charcoal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-rose-100">
                
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <span class="font-serif text-2xl font-bold tracking-widest text-charcoal block">NASIB CLOTHING</span>
                    <p class="text-xs text-gray-500 leading-relaxed max-w-sm">
                        Descubra a elegância atemporal com a Nasib Clothing. Cada peça é cuidadosamente desenhada para realçar sua beleza única, combinando tecidos nobres e cortes sofisticados.
                    </p>
                    <div class="flex items-center space-x-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white flex items-center justify-center transition">
                            <i data-lucide="instagram" class="w-4 h-4"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white flex items-center justify-center transition">
                            <i data-lucide="facebook" class="w-4 h-4"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white flex items-center justify-center transition">
                            <i data-lucide="pin" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Links 1 -->
                <div>
                    <h4 class="font-serif font-bold text-sm tracking-wider uppercase text-charcoal mb-4">Navegação</h4>
                    <ul class="space-y-2.5 text-xs text-gray-600">
                        <li><a href="#" class="hover:text-rose-600 transition">Novidades da Semana</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Vestidos de Festa</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Calças</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Body</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Saias</a></li>
                    </ul>
                </div>

                <!-- Navigation Links 2 -->
                <div>
                    <h4 class="font-serif font-bold text-sm tracking-wider uppercase text-charcoal mb-4">Atendimento</h4>
                    <ul class="space-y-2.5 text-xs text-gray-600">
                        <li><a href="#" class="hover:text-rose-600 transition">Central de Ajuda</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Acompanhar Pedido</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Trocas e Devoluções</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Politica de Frete</a></li>
                        <li><a href="#" class="hover:text-rose-600 transition">Fale Conosco</a></li>
                    </ul>
                </div>

                <!-- Payment Methods & Security -->
                <div>
                    <h4 class="font-serif font-bold text-sm tracking-wider uppercase text-charcoal mb-4">Pagamento</h4>
                    <div class="flex flex-wrap gap-2 text-rose-400">
                        <span class="px-2.5 py-1.5 bg-rose-50 rounded text-[11px] font-semibold border border-rose-100 text-gray-600">PIX </span>
                        <span class="px-2.5 py-1.5 bg-rose-50 rounded text-[11px] font-semibold border border-rose-100 text-gray-600">Cartão de Crédito</span>
                        <span class="px-2.5 py-1.5 bg-rose-50 rounded text-[11px] font-semibold border border-rose-100 text-gray-600">Boleto</span>
                    </div>
                </div>

            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-4">
                <p>&copy; 2026 Nasib Clothing. Todos os direitos reservados.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-rose-500">Termos de Uso</a>
                    <a href="#" class="hover:text-rose-500">Privacidade</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Shopping Cart Slide-over Drawer Modal -->
    <div id="cart-drawer" class="fixed inset-0 z-50 pointer-events-none">
        <!-- Overlay backdrop -->
        <div id="cart-overlay" class="cart-drawer-overlay absolute inset-0 bg-charcoal/40 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div id="cart-content" class="cart-drawer-content w-screen max-w-md bg-white shadow-2xl flex flex-col transform translate-x-full pointer-events-auto">
                
                <!-- Drawer Header -->
                <div class="p-5 border-b border-rose-100 flex items-center justify-between bg-rose-50">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="shopping-bag" class="w-5 h-5 text-rose-600"></i>
                        <h3 class="font-serif font-bold text-lg text-charcoal">Seu Carrinho</h3>
                        <span id="cart-drawer-count-badge" class="bg-rose-200 text-rose-800 text-xs px-2 py-0.5 rounded-full font-semibold">0 itens</span>
                    </div>
                    <button id="cart-close-btn" class="p-2 rounded-full text-gray-400 hover:text-charcoal hover:bg-rose-100/50 transition">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Free Shipping Progress Bar -->
                <div class="px-5 py-3 bg-rose-100/40 border-b border-rose-100">
                    <div class="flex justify-between text-xs font-medium text-gray-700 mb-1.5" id="shipping-progress-text">
                        <span>Frete Grátis</span>
                        <span>Falta R$ 299,00</span>
                    </div>
                    <div class="w-full bg-white rounded-full h-2 overflow-hidden border border-rose-200">
                        <div id="shipping-bar-fill" class="bg-rose-500 h-2 rounded-full transition-all duration-500" style="width: 0%;"></div>
                    </div>
                </div>

                <!-- Drawer Cart Items Body -->
                <div id="cart-items-container" class="flex-1 overflow-y-auto p-5 space-y-4 custom-scrollbar">
                    <!-- Items rendered dynamically -->
                </div>

                <!-- Drawer Footer Summary -->
                <div class="p-5 border-t border-rose-100 bg-cream-50 space-y-4">
                    <div class="space-y-1.5 text-xs text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span id="cart-subtotal-text" class="font-semibold text-charcoal">R$ 0,00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Frete Estimado</span>
                            <span id="cart-shipping-text" class="text-rose-600 font-semibold">Calculando...</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-charcoal pt-2 border-t border-rose-200/60">
                            <span>Total</span>
                            <span id="cart-total-text" class="text-rose-600 text-base">R$ 0,00</span>
                        </div>
                    </div>

                    <button id="checkout-btn" class="w-full py-3.5 bg-rose-600 hover:bg-rose-700 text-white rounded-full font-medium text-sm tracking-wide shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                        <span>Finalizar Compra</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Quick View Product Modal -->
    <div id="quickview-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-charcoal/50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-3xl w-full overflow-hidden shadow-2xl border border-rose-100 relative animate-fade-in max-h-[90vh] overflow-y-auto">
            <button id="quickview-close-btn" class="absolute top-4 right-4 z-10 p-2 rounded-full bg-white/80 hover:bg-rose-100 text-gray-600 transition shadow">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div id="quickview-modal-content" class="grid grid-cols-1 md:grid-cols-2">
                <!-- Content injected via JS -->
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-2 pointer-events-none"></div>

    <!-- Application Logic Script -->
    <script>
        // Sample Product Database
        const PRODUCTS = [
            {
                id: 1,
                name: "Vestido Midi Rosé Plissado",
                category: "vestidos",
                price: 289.90,
                oldPrice: 349.90,
                rating: 4.9,
                reviews: 28,
                badge: "Mais Vendido",
                image: "https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=600&q=80",
                description: "Vestido midi confeccionado em tecido leve e fluido com efeito plissado elegante. Decote em V sutil e cintura acentuada por laço delicado."
            },
            {
                id: 2,
                name: "Bolsa Couro Nude Mármore",
                category: "acessorios",
                price: 199.00,
                oldPrice: null,
                rating: 4.8,
                reviews: 14,
                badge: "Novo",
                image: "https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80",
                description: "Bolsa transversal estruturada em tom nude rosado com ferragens banhadas a ouro. Acompanha alça ajustável adicional."
            },
            {
                id: 3,
                name: "Sandália Salto Bloco Satin",
                category: "calcados",
                price: 249.90,
                oldPrice: 299.00,
                rating: 4.7,
                reviews: 19,
                badge: "Oferta",
                image: "https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=600&q=80",
                description: "Sandália feminina em cetim rosa bebê com salto bloco confortável de 6cm. Palmilha acolchoada extra macia."
            },
            {
                id: 4,
                name: "Perfume Eau de Parfum Rosé",
                category: "beleza",
                price: 320.00,
                oldPrice: null,
                rating: 5.0,
                reviews: 42,
                badge: "Exclusivo",
                image: "https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=600&q=80",
                description: "Fragrância delicada e marcante com notas de pétalas de rosa, peônia e toque sutil de baunilha de Madagascar."
            },
            {
                id: 5,
                name: "Colar Perlas e Cristal Rosa",
                category: "acessorios",
                price: 119.90,
                oldPrice: 149.90,
                rating: 4.6,
                reviews: 9,
                badge: null,
                image: "https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=600&q=80",
                description: "Colar banhado a ouro 18k com mini pérolas d'água doce e pingente em cristal rosa lapidado a mão."
            },
            {
                id: 6,
                name: "Vestido Evasê Curto Off-White",
                category: "vestidos",
                price: 219.90,
                oldPrice: null,
                rating: 4.9,
                reviews: 31,
                badge: "Novidades",
                image: "https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=600&q=80",
                description: "Vestido curto modelagem evasê com mangas levemente bufantes e acabamento impecável em renda delicada."
            },
            {
                id: 7,
                name: "Scarpin Couro Rosé Gold",
                category: "calcados",
                price: 279.00,
                oldPrice: 329.00,
                rating: 4.8,
                reviews: 16,
                badge: "Oferta",
                image: "https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=600&q=80",
                description: "Scarpin clássico bico fino com brilho sutil rosado. Salto fino elegância na medida certa para eventos formais."
            },
            {
                id: 8,
                name: "Batom Hidratante Velvet Velvet",
                category: "beleza",
                price: 79.90,
                oldPrice: null,
                rating: 4.9,
                reviews: 54,
                badge: null,
                image: "https://images.unsplash.com/photo-1586495777744-4413f21062fa?auto=format&fit=crop&w=600&q=80",
                description: "Batom acabamento aveludado de longa duração com ácido hialurônico para lábios macios e hidratados o dia todo."
            }
        ];

        // State Management
        let cart = [];
        let wishlist = new Set();
        let activeCategory = 'todos';
        let searchQuery = '';

        // DOM Elements
        const productGrid = document.getElementById('product-grid');
        const cartDrawer = document.getElementById('cart-drawer');
        const cartOverlay = document.getElementById('cart-overlay');
        const cartContent = document.getElementById('cart-content');
        const cartToggleBtn = document.getElementById('cart-toggle-btn');
        const cartCloseBtn = document.getElementById('cart-close-btn');
        const cartBadge = document.getElementById('cart-badge');
        const cartItemsContainer = document.getElementById('cart-items-container');
        const cartSubtotalText = document.getElementById('cart-subtotal-text');
        const cartTotalText = document.getElementById('cart-total-text');
        const cartShippingText = document.getElementById('cart-shipping-text');
        const shippingProgressText = document.getElementById('shipping-progress-text');
        const shippingBarFill = document.getElementById('shipping-bar-fill');
        const cartDrawerCountBadge = document.getElementById('cart-drawer-count-badge');
        const wishlistBtn = document.getElementById('wishlist-btn');
        const wishlistCount = document.getElementById('wishlist-count');
        const quickviewModal = document.getElementById('quickview-modal');
        const quickviewModalContent = document.getElementById('quickview-modal-content');
        const quickviewCloseBtn = document.getElementById('quickview-close-btn');
        const searchInput = document.getElementById('search-input');
        const searchInputMobile = document.getElementById('search-input-mobile');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        // Initialization
        window.addEventListener('DOMContentLoaded', () => {
            renderProducts();
            updateCartUI();
            lucide.createIcons();

            // Mobile menu toggle
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Cart Drawer open/close
            cartToggleBtn.addEventListener('click', openCart);
            cartCloseBtn.addEventListener('click', closeCart);
            cartOverlay.addEventListener('click', closeCart);

            // Quick View Close
            quickviewCloseBtn.addEventListener('click', closeQuickView);
            quickviewModal.addEventListener('click', (e) => {
                if (e.target === quickviewModal) closeQuickView();
            });

            // Category Filter Handlers
            document.querySelectorAll('.category-pill').forEach(pill => {
                pill.addEventListener('click', (e) => {
                    document.querySelectorAll('.category-pill').forEach(btn => {
                        btn.classList.remove('bg-rose-500', 'text-white', 'shadow-sm');
                        btn.classList.add('bg-rose-50', 'text-charcoal');
                    });

                    e.target.classList.remove('bg-rose-50', 'text-charcoal');
                    e.target.classList.add('bg-rose-500', 'text-white', 'shadow-sm');

                    activeCategory = e.target.dataset.category;
                    renderProducts();
                });
            });

            document.getElementById('reset-filter').addEventListener('click', () => {
                const allBtn = document.querySelector('[data-category="todos"]');
                if (allBtn) allBtn.click();
            });

            // Search event listener
            const handleSearch = (e) => {
                searchQuery = e.target.value.toLowerCase().trim();
                renderProducts();
            };
            searchInput.addEventListener('input', handleSearch);
            searchInputMobile.addEventListener('input', handleSearch);

            // Checkout Handler
            document.getElementById('checkout-btn').addEventListener('click', () => {
                if (cart.length === 0) {
                    showToast("Seu carrinho está vazio!", "info");
                    return;
                }
                showToast("Redirecionando para o pagamento seguro...", "success");
            });

            // Newsletter Handler
            document.getElementById('newsletter-form').addEventListener('submit', (e) => {
                e.preventDefault();
                showToast("Inscrição realizada com sucesso! Confira seu cupom.", "success");
                e.target.reset();
            });
        });

        // Render Product Grid
        function renderProducts() {
            let filtered = PRODUCTS.filter(p => {
                const matchesCategory = (activeCategory === 'todos') || 
                                        (activeCategory === 'novidades' && p.badge === 'Novo') ||
                                        (p.category === activeCategory);
                const matchesSearch = p.name.toLowerCase().includes(searchQuery) || p.description.toLowerCase().includes(searchQuery);
                return matchesCategory && matchesSearch;
            });

            document.getElementById('product-count-text').innerText = `Exibindo ${filtered.length} produto(s)`;

            if (filtered.length === 0) {
                productGrid.innerHTML = `
                    <div class="col-span-full py-12 text-center text-gray-500">
                        <i data-lucide="package-open" class="w-12 h-12 mx-auto text-rose-300 mb-3"></i>
                        <p class="text-base font-serif font-semibold">Nenhum produto encontrado</p>
                        <p class="text-xs text-gray-400 mt-1">Tente ajustar seus termos de busca ou filtros.</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            productGrid.innerHTML = filtered.map(product => {
                const isWishlisted = wishlist.has(product.id);
                return `
                <div class="group bg-white rounded-3xl p-3 border border-rose-100 hover:shadow-xl hover:border-rose-200 transition-all duration-300 flex flex-col justify-between relative">
                    
                    <!-- Image Container -->
                    <div class="aspect-[3/4] rounded-2xl overflow-hidden relative bg-rose-50 mb-3">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        
                        ${product.badge ? `
                            <span class="absolute top-2.5 left-2.5 bg-white/90 backdrop-blur-md text-rose-700 font-bold text-[10px] px-2.5 py-1 rounded-full shadow-xs uppercase tracking-wider">
                                ${product.badge}
                            </span>
                        ` : ''}

                        <!-- Wishlist Toggle Button -->
                        <button onclick="toggleWishlist(${product.id})" class="absolute top-2.5 right-2.5 p-2 rounded-full bg-white/80 backdrop-blur-md text-gray-400 hover:text-rose-500 transition shadow-xs">
                            <i data-lucide="heart" class="w-4 h-4 ${isWishlisted ? 'fill-rose-500 text-rose-500' : ''}"></i>
                        </button>

                        <!-- Hover Overlay Actions -->
                        <div class="absolute inset-x-3 bottom-3 opacity-0 group-hover:opacity-100 transition duration-300 flex gap-2">
                            <button onclick="openQuickView(${product.id})" class="flex-1 bg-white/90 hover:bg-white text-charcoal text-xs font-semibold py-2.5 rounded-xl backdrop-blur-md shadow-sm transition">
                                Espiar
                            </button>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="p-1 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-1 text-amber-400 text-xs mb-1">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
                                <span class="text-charcoal font-semibold text-[11px]">${product.rating}</span>
                                <span class="text-gray-400 text-[10px]">(${product.reviews})</span>
                            </div>
                            <h3 class="font-serif font-bold text-base text-charcoal group-hover:text-rose-600 transition line-clamp-1">${product.name}</h3>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <div>
                                ${product.oldPrice ? `<span class="text-[11px] text-gray-400 line-through block">R$ ${product.oldPrice.toFixed(2).replace('.', ',')}</span>` : ''}
                                <span class="text-rose-600 font-bold text-base">R$ ${product.price.toFixed(2).replace('.', ',')}</span>
                            </div>

                            <button onclick="addToCart(${product.id})" class="p-2.5 bg-rose-100 hover:bg-rose-500 text-rose-700 hover:text-white rounded-xl transition shadow-xs" title="Adicionar ao Carrinho">
                                <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                </div>
            `;
            }).join('');

            lucide.createIcons();
        }

        // Cart Logic
        function addToCart(productId, quantity = 1) {
            const product = PRODUCTS.find(p => p.id === productId);
            if (!product) return;

            const existingIndex = cart.findIndex(item => item.id === productId);
            if (existingIndex > -1) {
                cart[existingIndex].quantity += quantity;
            } else {
                cart.push({ ...product, quantity });
            }

            updateCartUI();
            showToast(`${product.name} adicionado ao carrinho!`, "success");
            openCart();
        }

        function updateCartQuantity(productId, delta) {
            const index = cart.findIndex(item => item.id === productId);
            if (index > -1) {
                cart[index].quantity += delta;
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
            }
            updateCartUI();
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCartUI();
            showToast("Item removido do carrinho.", "info");
        }

        function updateCartUI() {
            // Badges & Counter
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartBadge.innerText = totalItems;
            cartDrawerCountBadge.innerText = `${totalItems} itens`;

            // Subtotal
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartSubtotalText.innerText = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;

            // Free shipping calculation
            const freeShippingThreshold = 299.00;
            if (subtotal >= freeShippingThreshold || subtotal === 0) {
                cartShippingText.innerText = subtotal === 0 ? "R$ 0,00" : "GRÁTIS";
                cartTotalText.innerText = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
            } else {
                const shippingCost = 19.90;
                cartShippingText.innerText = `R$ ${shippingCost.toFixed(2).replace('.', ',')}`;
                cartTotalText.innerText = `R$ ${(subtotal + shippingCost).toFixed(2).replace('.', ',')}`;
            }

            // Progress bar
            const percentage = Math.min((subtotal / freeShippingThreshold) * 100, 100);
            shippingBarFill.style.width = `${percentage}%`;

            if (subtotal >= freeShippingThreshold) {
                shippingProgressText.innerHTML = `<span>Parabéns!</span> <span class="text-rose-600 font-bold">Você ganhou Frete Grátis! 🎉</span>`;
            } else {
                const remaining = freeShippingThreshold - subtotal;
                shippingProgressText.innerHTML = `<span>Frete Grátis</span> <span>Faltam R$ ${remaining.toFixed(2).replace('.', ',')}</span>`;
            }

            // Render Cart Drawer Items
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = `
                    <div class="text-center py-12 text-gray-400 space-y-3">
                        <i data-lucide="shopping-bag" class="w-12 h-12 mx-auto text-rose-200"></i>
                        <p class="text-sm font-medium">Seu carrinho está vazio</p>
                        <button onclick="closeCart()" class="text-xs text-rose-500 font-semibold hover:underline">Continuar comprando</button>
                    </div>
                `;
            } else {
                cartItemsContainer.innerHTML = cart.map(item => `
                    <div class="flex items-center space-x-3 p-3 bg-rose-50/50 rounded-2xl border border-rose-100">
                        <img src="${item.image}" alt="${item.name}" class="w-16 h-20 object-cover rounded-xl bg-white">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-serif font-bold text-xs text-charcoal truncate">${item.name}</h4>
                            <p class="text-xs text-rose-600 font-bold mt-0.5">R$ ${item.price.toFixed(2).replace('.', ',')}</p>
                            
                            <div class="flex items-center space-x-2 mt-2">
                                <div class="flex items-center border border-rose-200 rounded-lg bg-white">
                                    <button onclick="updateCartQuantity(${item.id}, -1)" class="px-2 py-0.5 text-xs text-gray-600 hover:text-rose-600">-</button>
                                    <span class="px-2 text-xs font-semibold text-charcoal">${item.quantity}</span>
                                    <button onclick="updateCartQuantity(${item.id}, 1)" class="px-2 py-0.5 text-xs text-gray-600 hover:text-rose-600">+</button>
                                </div>
                            </div>
                        </div>
                        <button onclick="removeFromCart(${item.id})" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg transition">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                `).join('');
            }

            lucide.createIcons();
        }

        // Cart Drawer Drawer Toggle Handlers
        function openCart() {
            cartDrawer.classList.remove('pointer-events-none');
            cartOverlay.classList.remove('opacity-0', 'pointer-events-none');
            cartContent.classList.remove('translate-x-full');
        }

        function closeCart() {
            cartContent.classList.add('translate-x-full');
            cartOverlay.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                cartDrawer.classList.add('pointer-events-none');
            }, 300);
        }

        // Wishlist Toggle Handler
        function toggleWishlist(productId) {
            if (wishlist.has(productId)) {
                wishlist.delete(productId);
                showToast("Removido dos favoritos.", "info");
            } else {
                wishlist.add(productId);
                showToast("Adicionado aos favoritos! ❤️", "success");
            }

            wishlistCount.innerText = wishlist.size;
            wishlistCount.style.opacity = wishlist.size > 0 ? '1' : '0';
            renderProducts();
        }

        // Quick View Modal
        function openQuickView(productId) {
            const product = PRODUCTS.find(p => p.id === productId);
            if (!product) return;

            quickviewModalContent.innerHTML = `
                <div class="aspect-[3/4] bg-rose-50">
                    <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-6 md:p-8 flex flex-col justify-between">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-rose-500 font-bold">${product.category}</span>
                        <h2 class="font-serif text-2xl font-bold text-charcoal mt-1">${product.name}</h2>
                        
                        <div class="flex items-center space-x-2 mt-2 text-xs">
                            <div class="flex text-amber-400">
                                <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            </div>
                            <span class="font-bold text-charcoal">${product.rating}</span>
                            <span class="text-gray-400">(${product.reviews} avaliações)</span>
                        </div>

                        <p class="text-xs text-gray-600 mt-4 leading-relaxed">${product.description}</p>

                        <div class="mt-6">
                            <span class="text-xs text-gray-400 block mb-1">Tamanho:</span>
                            <div class="flex gap-2">
                                <button class="w-8 h-8 rounded-full border border-rose-200 text-xs font-semibold hover:border-rose-500 focus:bg-rose-500 focus:text-white transition">P</button>
                                <button class="w-8 h-8 rounded-full border border-rose-200 text-xs font-semibold hover:border-rose-500 focus:bg-rose-500 focus:text-white transition">M</button>
                                <button class="w-8 h-8 rounded-full border border-rose-200 text-xs font-semibold hover:border-rose-500 focus:bg-rose-500 focus:text-white transition">G</button>
                            </div>
                        </div>

                        <div class="mt-6 flex items-baseline space-x-3">
                            <span class="text-2xl font-bold text-rose-600">R$ ${product.price.toFixed(2).replace('.', ',')}</span>
                            ${product.oldPrice ? `<span class="text-sm text-gray-400 line-through">R$ ${product.oldPrice.toFixed(2).replace('.', ',')}</span>` : ''}
                        </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-rose-100 flex gap-3">
                        <button onclick="addToCart(${product.id}); closeQuickView();" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white font-semibold py-3.5 rounded-full text-xs uppercase tracking-wider transition shadow-md">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            `;

            quickviewModal.classList.remove('hidden');
            lucide.createIcons();
        }

        function closeQuickView() {
            quickviewModal.classList.add('hidden');
        }

        // Notification Toast System
        function showToast(message, type = "success") {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const bgColor = type === "success" ? "bg-rose-600 text-white" : "bg-charcoal text-white";
            const icon = type === "success" ? "check-circle" : "info";

            toast.className = `flex items-center space-x-2 px-4 py-3 rounded-2xl shadow-xl text-xs font-medium ${bgColor} animate-fade-in pointer-events-auto border border-white/20`;
            toast.innerHTML = `
                <i data-lucide="${icon}" class="w-4 h-4"></i>
                <span>${message}</span>
            `;

            container.appendChild(toast);
            lucide.createIcons();

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.4s ease';
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }
    </script>
</body>
</html>