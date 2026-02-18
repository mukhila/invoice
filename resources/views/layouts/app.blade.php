<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Aurum & Co. - Premium Jewelry Collection">

        <title>@yield('title', 'Aurum & Co. | Premium Jewelry')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header>
            <div class="container">
                <nav>
                    <a href="/" class="logo">Aurum & Co.</a>
                    <div class="nav-links">
                        <a href="#">Collections</a>
                        <a href="#">New Arrivals</a>
                        <a href="#">Bespoke</a>
                        <a href="#">Our Story</a>
                    </div>
                    <div class="nav-actions" style="display: flex; align-items: center; margin-left: 20px;">
                        <a href="{{ route('user.login') }}" style="color:white; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Login</a>
                    </div>
                </nav>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-col" style="flex: 2;">
                        <a href="/" class="logo">Aurum & Co.</a>
                        <p style="margin-top: 1rem; color: #999; max-width: 300px;">
                            Crafting eternal moments with sustainable luxury and timeless design.
                        </p>
                    </div>
                    <div class="footer-col">
                        <h4>Shop</h4>
                        <ul>
                            <li><a href="#">High Jewelry</a></li>
                            <li><a href="#">Engagement</a></li>
                            <li><a href="#">Watches</a></li>
                            <li><a href="#">Gifts</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Sustainability</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <div class="footer-col newsletter">
                        <h4>Newsletter</h4>
                        <p style="color: #999; margin-bottom: 1rem;">Subscribe for exclusive updates.</p>
                        <form onsubmit="event.preventDefault(); alert('Subscribed!');">
                            <input type="email" placeholder="Your email address">
                            <button class="btn btn-primary" style="width: 100%;">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="copyright">
                    &copy; {{ date('Y') }} Aurum & Co. All rights reserved.
                </div>
            </div>
        </footer>
    </body>
</html>
