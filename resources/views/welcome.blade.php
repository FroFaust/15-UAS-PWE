<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pre-Order Kantin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #ffffff;
        }

        .brand {
            color: #0d6efd;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .hero {
            min-height: 520px;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #eaf3ff, #ffffff);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero-title span {
            color: #0d6efd;
        }

        .hero-text {
            color: #6c757d;
            font-size: 1.1rem;
            max-width: 550px;
        }

        .hero-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .food-icon {
            font-size: 5rem;
        }

        .feature-card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            height: 100%;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #eaf3ff;
            color: #0d6efd;
            border-radius: 14px;
            font-size: 1.7rem;
        }

        .cta {
            background-color: #0d6efd;
            border-radius: 20px;
            color: white;
        }

        footer {
            background-color: #ffffff;
        }

        @media (max-width: 768px) {
            .hero {
                min-height: auto;
                padding: 70px 0;
            }

            .hero-title {
                font-size: 2.3rem;
            }

            .hero-card {
                margin-top: 40px;
            }
        }
    </style>
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg border-bottom">
        <div class="container py-2">

            <a href="{{ route('home') }}" class="navbar-brand brand">
                Pre-Order Kantin
            </a>

            <div class="d-flex gap-2">
                <a href="{{ route('login') }}"
                   class="btn btn-outline-primary px-4">
                    Login
                </a>

                <a href="{{ url('/register') }}"
                   class="btn btn-primary px-4">
                    Register
                </a>
            </div>

        </div>
    </nav>


    {{-- Hero Section --}}
    <section class="hero">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-7">

                    <h1 class="hero-title mb-4">
                        Pesan Makanan Jadi
                        <span>Lebih Mudah.</span>
                    </h1>

                    <p class="hero-text mb-4">
                        Membantu kamu memesan makanan favorit
                        dengan lebih mudah. Pilih menu, masukkan ke keranjang,
                        lalu lakukan checkout tanpa proses yang ribet.
                    </p>

                    <div class="d-flex gap-3 flex-wrap">

                        <a href="{{ route('login') }}"
                           class="btn btn-primary btn-lg px-4">
                            Mulai Memesan
                        </a>

                        <a href="{{ url('/register') }}"
                           class="btn btn-outline-secondary btn-lg px-4">
                            Buat Akun
                        </a>

                    </div>

                </div>


                <div class="col-lg-5">

                    <div class="hero-card text-center">

                        <div class="food-icon mb-3">
                            🍔
                        </div>

                        <h3 class="fw-bold">
                            Pre-Order Kantin
                        </h3>

                        <p class="text-muted mb-0">
                            Pre-Order Makananmu tanpa harus mengantri!
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- Features --}}
    <section class="py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">
                    Kenapa Pre-Order?
                </h2>

                <p class="text-muted">
                    Proses pemesanan lebih sederhana tanpa mengantri.
                </p>

            </div>


            <div class="row g-4">

                {{-- Feature 1 --}}
                <div class="col-md-4">

                    <div class="feature-card p-4">

                        <div class="feature-icon mb-4">
                            🍽️
                        </div>

                        <h5 class="fw-bold">
                            Pilih Menu
                        </h5>

                        <p class="text-muted mb-0">
                            Lihat berbagai makanan yang tersedia
                            dan pilih makanan sesuai keinginan.
                        </p>

                    </div>

                </div>


                {{-- Feature 2 --}}
                <div class="col-md-4">

                    <div class="feature-card p-4">

                        <div class="feature-icon mb-4">
                            🛒
                        </div>

                        <h5 class="fw-bold">
                            Kelola Keranjang
                        </h5>

                        <p class="text-muted mb-0">
                            Atur jumlah makanan dan lihat total
                            harga sebelum melakukan checkout.
                        </p>

                    </div>

                </div>


                {{-- Feature 3 --}}
                <div class="col-md-4">

                    <div class="feature-card p-4">

                        <div class="feature-icon mb-4">
                            📦
                        </div>

                        <h5 class="fw-bold">
                            Pantau Pesanan
                        </h5>

                        <p class="text-muted mb-0">
                            Lihat riwayat pesanan dan status
                            pesanan yang telah dibuat.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- CTA --}}
    <section class="py-5">

        <div class="container">

            <div class="cta p-5 text-center">

                <h2 class="fw-bold mb-3">
                    Siap Memesan Makanan?
                </h2>

                <p class="mb-4">
                    Buat akun dan mulai pesan makanan favoritmu
                    melalui Pre-Order Kantin.
                </p>

                <a href="{{ url('/register') }}"
                   class="btn btn-light btn-lg px-4">
                    Daftar Sekarang
                </a>

            </div>

        </div>

    </section>


    {{-- Footer --}}
    <footer class="border-top py-4">

        <div class="container text-center">

            <p class="mb-1 fw-bold">
                Pre-Order Kantin
            </p>

            <p class="text-muted mb-0">
                Pre-Order Kantin berbasis web menggunakan Laravel.
            </p>

        </div>

    </footer>

</body>

</html>

