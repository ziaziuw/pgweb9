Untuk menampilkan tabel dengan data `longitude`, `latitude`, dan `kecamatan` dari database, saya akan menambahkan kode PHP yang mengambil data dari tabel `tabel_pddk` di database dan menampilkannya dalam bentuk tabel HTML. Berikut adalah kode lengkap dengan tabel tambahan untuk menampilkan data yang diambil dari database.

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kabupaten Sleman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            width: 100%;
            height: 600px;
        }

        main {
            margin-top: 80px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kabupaten Sleman</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#deskripsi">Deskripsi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#penduduk">Penduduk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#peta">Peta</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kritiksaran">Kritik dan Saran</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Pembuat</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container border border-warning rounded">
            <div class="alert alert-warning text-center" role="alert">
                <h1>KABUPATEN SLEMAN</h1>
                <h4>Provinsi Daerah Istimewa Yogyakarta</h4>
            </div>

            <!-- Section Penduduk (Tabel dari Database) -->
            <div class="card mt-4">
                <div class="card-header alert alert-warning">
                    <h4 id="penduduk">Data Penduduk</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Kecamatan</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Koneksi ke database
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "pgweb8";

                            // Membuat koneksi
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Cek koneksi
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Ambil data dari tabel_pddk
                            $sql = "SELECT Kecamatan, Latitude, Longitude FROM tabel_pddk";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $row["Kecamatan"] . "</td>
                                            <td>" . $row["Latitude"] . "</td>
                                            <td>" . $row["Longitude"] . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>Tidak ada data</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section Peta -->
            <div class="card mt-4">
                <div class="card-header alert alert-warning">
                    <h4 id="peta">Peta</h4>
                </div>
                <div class="card-body">
                    <div id="map"></div>
                </div>
            </div>

            <!-- Kritik dan Saran Section -->
            <div class="card mt-4">
                <div class="card-header alert alert-warning">
                    <h4 id="kritiksaran">Kritik dan Saran</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Isikan nama Anda">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="kritik" class="form-label">Kritik dan saran</label>
                            <textarea class="form-control" id="kritik" name="kritik" rows="3"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Section -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pembuat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Nama: Adinda Fauzia Azizah<br>
                            NIM: 23/515141/SV/22484<br>
                            Kelas: A
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Initialize map
        var map = L.map("map").setView([-7.7681, 110.296], 12);

        // Add base map layer
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php
        // Display markers on map
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT Kecamatan, Latitude, Longitude FROM tabel_pddk";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lat = $row["Latitude"];
                $long = $row["Longitude"];
                $info = $row["Kecamatan"];
                echo "L.marker([$lat, $long]).addTo(map).bindPopup('$info');";
            }
        }
        $conn->close();
        ?>
    </script>
</body>
</html>
