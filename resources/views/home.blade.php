@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <p>Elegance Redefined</p>
            <h1>Timeless Beauty <br> For Every Moment</h1>
            
            @if(isset($todayRate))
            <div style="background: rgba(0, 0, 0, 0.6); padding: 15px; border: 1px solid #d4af37; display: inline-block; margin-bottom: 20px; border-radius: 5px;">
                <p style="margin-bottom: 5px; font-size: 0.9rem; letter-spacing: 2px;">TODAY'S GOLD RATE</p>
                <h3 style="color: #d4af37; margin: 0; font-family: 'Playfair Display', serif;">
                    Rs. {{ number_format($todayRate->rate_per_gram, 2) }} <span style="font-size: 0.8rem; color: #fff;">/ gram</span>
                </h3>
            </div>
            <br>
            @endif

            <a href="#collection" class="btn">Explore Collection</a>
        </div>
    </section>

    <!-- Featured Collection -->
    <section id="collection" class="collection">
        <div class="container">
            <div class="section-title">
                <span>Curated Selection</span>
                <h2>Iconic Pieces</h2>
            </div>

            <div class="product-grid">
                <!-- Product 1 -->
                <div class="product-card">
                    <img src="{{ asset('images/necklace.png') }}" alt="Diamond Tennis Necklace" class="product-image">
                    <h3 class="product-title">Celestial Diamond Necklace</h3>
                    <p class="product-price">$12,500</p>
                    <button class="btn" style="margin-top: 1rem; width: 100%;">View Detail</button>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <img src="{{ asset('images/ring.png') }}" alt="Gold Solitaire Ring" class="product-image">
                    <h3 class="product-title">Royal Solitaire Ring</h3>
                    <p class="product-price">$8,900</p>
                    <button class="btn" style="margin-top: 1rem; width: 100%;">View Detail</button>
                </div>

                 <!-- Product 3 (Placeholder for layout balance) -->
                 <div class="product-card">
                    <div style="background: #f0f0f0; width: 100%; height: 350px; display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem;">
                        <span style="color:#ccc; font-family: 'Playfair Display'; font-style: italic;">Coming Soon</span>
                    </div>
                    <h3 class="product-title">Vintage Sapphire Earings</h3>
                    <p class="product-price">$4,200</p>
                    <button class="btn" style="margin-top: 1rem; width: 100%;">View Detail</button>
                </div>
            </div>
            
            <div class="text-center" style="margin-top: 4rem;">
                <a href="#" class="btn btn-primary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Brand Story / Divider -->
    <section class="about">
        <div class="container about-content">
            <h2>The Art of Jewelry</h2>
            <p>
                At Aurum & Co., we believe that every piece of jewelry tells a story. 
                Our artisans meticulously craft each item with the finest materials, 
                blending traditional techniques with modern design to create heirs 
                for generations to come.
            </p>
            <a href="#" class="btn">Read Our Story</a>
        </div>
    </section>
@endsection
