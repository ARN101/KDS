<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost in Discourse | KUET Debating Society</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlack: '#000000',
                        brandWhite: '#FFFFFF',
                        brandRed: '#ED1C24',
                        brandGreen: '#006837',
                        glassBg: 'rgba(15, 15, 15, 0.75)',
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #000000;
            background-image: radial-gradient(circle at 50% 50%, rgba(237, 28, 36, 0.08) 0%, rgba(0, 0, 0, 0) 70%);
        }
    </style>
</head>
<body class="text-brandWhite min-h-screen flex items-center justify-center overflow-hidden relative">
    
    
    <div class="absolute inset-0 z-0 opacity-20 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brandRed rounded-full filter blur-[120px]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-brandGreen rounded-full filter blur-[120px]"></div>
    </div>

    
    <div class="relative z-10 text-center px-6 max-w-lg">
        <h1 class="font-serif text-8xl md:text-9xl text-brandRed font-bold tracking-tighter mb-4 animate-pulse">404</h1>
        <h2 class="font-serif text-2xl md:text-3xl text-brandWhite font-semibold mb-6 italic">"Lost in Discourse"</h2>
        <p class="text-gray-400 font-sans font-light leading-relaxed mb-8">
            The thesis you are looking for has been rejected. The argument at this address does not exist or has been moved to another chamber.
        </p>
        
        
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']) === '/' ? '' : dirname($_SERVER['SCRIPT_NAME']) ?>/" class="inline-flex items-center justify-center px-8 py-3 bg-transparent border border-brandRed hover:bg-brandRed text-brandWhite text-sm font-semibold tracking-wider uppercase transition-all duration-300 rounded shadow-lg shadow-brandRed/20 hover:shadow-brandRed/40">
            Return to Arena
        </a>
    </div>

</body>
</html>
