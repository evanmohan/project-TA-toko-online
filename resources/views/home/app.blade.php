<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Store</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0698b5b56f.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #fafafa;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding-top: 100px;
            color: #212529 !important;
        }

        :root {
            --grey: #6c757d;
            --dark-grey: #495057;
            --light-grey: #e9ecef;
        }

        /* ===========================
           NAVBAR WRAPPER
        ============================ */
        .navbar-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(90deg, var(--grey), var(--dark-grey));
            color: #212529 !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* ===========================
           TOP NAVBAR
        ============================ */
        .top-navbar {
            width: 100%;
            padding: 8px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .top-navbar a {
            color: #212529 !important;
            font-weight: 600;
            text-decoration: none;
        }

        .top-navbar a:hover {
            color: #000 !important;
        }

        /* ===========================
           MAIN NAVBAR
        ============================ */
        .main-navbar {
            padding: 12px 30px;
            display: flex;
            justify-content: center;
            /* Tengah */
            align-items: center;
            gap: 25px;

            max-width: 1200px;
            /* Batasi lebar agar tidak melebar ke seluruh layar */
            /* margin: 0 auto; */
            /* MENENGAHKAN NAVBAR */
            width: 100%;
        }


        .main-navbar .logo img {
            height: 45px;
        }

        .main-navbar .logo h4 {
            color: #212529 !important;
            margin: 0;
            font-weight: bold;
        }

        .main-navbar .search-bar {
            flex: 1;
            max-width: 550px;
            position: relative;
        }

        .main-navbar .search-bar input {
            width: 100%;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .main-navbar .search-bar button {
            position: absolute;
            right: 3px;
            top: 3px;
            bottom: 3px;
            width: 45px;
            border: none;
            background: var(--grey);
            color: #212529 !important;
            border-radius: 6px;
        }

        .icons a {
            color: #212529 !important;
            font-weight: 600;
            text-decoration: none;
            position: relative;
        }

        .icons .badge {
            background: red;
            position: absolute;
            top: -5px;
            right: -10px;
        }

        /* ===========================
           FOOTER
        ============================ */
        footer {
            margin-top: 50px;
            background: linear-gradient(90deg, var(--grey), var(--dark-grey));
            color: #212529 !important;
            padding: 40px 0;
        }

        footer a {
            color: #212529 !important;
            font-weight: 500;
            text-decoration: none;
        }

        footer a:hover {
            color: #000 !important;
        }


        /* ============================================================
           RESPONSIVE SHOPEE-LIKE NAVBAR
        ============================================================ */

        /* Tablet */
        @media (max-width: 992px) {
            .main-navbar {
                flex-direction: column;
                justify-content: center;
                text-align: center;
            }

            .main-navbar .search-bar {
                max-width: 100%;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .top-navbar {
                flex-direction: column;
                text-align: center;
                gap: 6px;
            }

            .top-navbar div:first-child {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 5px;
            }

            .main-navbar {
                flex-direction: column;
                gap: 15px;
                padding: 15px 20px;
            }

            .main-navbar .logo {
                justify-content: center;
            }

            .main-navbar .search-bar {
                width: 100%;
                max-width: 100% !important;
            }

            .main-navbar .icons {
                justify-content: center;
                gap: 25px;
            }

            .icons .badge {
                top: -7px;
                right: -12px;
            }
        }


        /* Extra small */
        @media (max-width: 480px) {
            .top-navbar {
                font-size: 12px;
                padding: 5px 10px;
            }

            .main-navbar .logo h4 {
                font-size: 16px;
            }

            .main-navbar .search-bar input {
                font-size: 13px;
            }

            .icon-link span {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar-wrapper">
        <!-- TOP NAVBAR -->
        <div class="top-navbar container">
            <div>
                <a href="#"><i class="bi bi-info-circle me-1"></i>Tentang Kami</a>
                <span>|</span>
                <a href="#"><i class="bi bi-question-circle me-1"></i>Bantuan</a>
                <span>|</span>
                <a href="#"><i class="bi bi-telephone me-1"></i>Hubungi Kami</a>
            </div>

            <div class="dropdown">
                @auth
                    <a class="dropdown-toggle text-dark text-decoration-none d-flex align-items-center" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->username }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="#" class="dropdown-item">Edit Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">@csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>

                @else
                    <a href="{{ route('login') }}">Masuk</a> |
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </div>

        <!-- MAIN NAVBAR -->
        <div class="main-navbar container">

            <a href="{{ route('home') }}" class="logo d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                <h4>Second Store</h4>
            </a>

            <div class="search-bar position-relative">
                <form action="{{ route('product.search') }}" method="GET" class="search-bar position-relative">
                    <input type="text" name="search" placeholder="Cari produk..." required>
                    <button type="submit"><i class="bi bi-search"></i></button>
                </form>
                
            </div>

            <div class="icons d-flex align-items-center gap-4">
                <a href="{{ route('keranjang.index') }}" class="icon-link">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span>Keranjang</span>
                    @if(isset($cartCount) && $cartCount > 0)
                        <span class="badge">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('payment.index') }}" class="icon-link">
                        <i class="bi bi-clock-history fs-5"></i>
                        <span>Riwayat</span>
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    <!-- CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row text-start">
                <div class="col-md-3 mb-3">
                    <h6>INFORMASI</h6>
                    <a href="#">Tentang Kami</a><br>
                    <a href="#">Kebijakan Privasi</a><br>
                    <a href="#">Syarat & Ketentuan</a>
                </div>

                <div class="col-md-3 mb-3">
                    <h6>LAYANAN</h6>
                    <a href="#">Hubungi Kami</a><br>
                    <a href="#">Pengembalian Barang</a><br>
                    <a href="#">Bantuan</a>
                </div>

                <div class="col-md-3 mb-3">
                    <h6>EKSTRA</h6>
                    <a href="#">Promo</a><br>
                    <a href="#">Diskon</a><br>
                    <a href="#">Voucher</a>
                </div>

                <div class="col-md-3 mb-3">
                    <h6>AKUN</h6>
                    <a href="#">Akun Saya</a><br>
                    <a href="#">Keranjang</a><br>
                    <a href="#">Riwayat Belanja</a>
                </div>
            </div>

            <div class="text-center mt-4">
                &copy; {{ date('Y') }} Second Store
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const resultsDiv = document.getElementById('searchResults');
            let timeout = null;

            searchInput.addEventListener('keyup', function () {
                clearTimeout(timeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    resultsDiv.style.display = 'none';
                    resultsDiv.innerHTML = '';
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/produk/live-search?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length === 0) {
                                resultsDiv.innerHTML = '<div class="p-2 text-muted small">Tidak ada hasil</div>';
                            } else {
                                resultsDiv.innerHTML = data.map(item => `
                            <a href="/produk/${item.id}" class="d-flex align-items-center text-decoration-none text-dark p-2 border-bottom">
                                <img src="${item.image ? '/storage/' + item.image : '/assets/images/default-product.png'}"
                                     width="50" height="50" class="me-2" style="object-fit:cover;">
                                <div>
                                    <div class="fw-semibold">${item.nama_produk}</div>
                                    <div class="text-muted small">
                                        Rp ${parseInt(item.harga).toLocaleString('id-ID')}
                                    </div>
                                </div>
                            </a>
                        `).join('');
                            }

                            resultsDiv.style.display = 'block';
                        });
                }, 300);
            });

            document.addEventListener('click', function (e) {
                if (!resultsDiv.contains(e.target) && e.target !== searchInput) {
                    resultsDiv.style.display = 'none';
                }
            });
        });
    </script>


</body>

</html>
