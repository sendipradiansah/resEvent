<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color:rgba(255, 140, 0, 1);">
        <div class="container d-flex justify-content-between align-items-center">
            <h4>Halaman User</h4>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('event') ? 'active' : '' }}" aria-current="page" href="{{ route('event.index') }}">Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reservation') ? 'active' : '' }}" href="{{ route('reservation.index') }}">Reservasi</a>
                    </li>
                    <li class="nav-item dropdown ms-5">
                        <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        //reload when back or forward page
        if (performance.navigation.type === 2) {
            location.reload();
        }
    </script>