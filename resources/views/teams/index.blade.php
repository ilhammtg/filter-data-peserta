<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tim Debat D'MASIF</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        body {
            background-color: var(--light-bg);
            padding-top: 20px;
            padding-bottom: 20px;
        }
        
        .header {
            background-color: var(--secondary-color);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
        }
        
        .card-custom {
            border-radius: 10px;
            border: none;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }
        
        .card-header-custom {
            border-radius: 10px 10px 0 0 !important;
            background-color: var(--primary-color);
            color: white;
        }
        
        .team-item {
            margin-bottom: 1.5rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background-color: white;
        }
        
        .debater-card {
            border-left: 4px solid var(--primary-color);
            height: 100%;
        }
        
        .badge-payment {
            font-size: 0.85rem;
            padding: 0.35rem 0.75rem;
            font-weight: 500;
        }
        
        .filter-section {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .info-text {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .action-btn {
            min-width: 120px;
        }
        
        @media (max-width: 768px) {
            .filter-section .col-md-4 {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Notifikasi -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Header -->
        <div class="header text-center">
            <h1 class="mb-2"><i class="fas fa-users me-2"></i> Daftar Tim Debat D'MASIF</h1>
            <p class="mb-0">Sistem Manajemen Peserta Lomba Debat</p>
        </div>

        <div class="card card-custom mb-4 border-success">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-file-export me-2"></i> Export Data</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('teams.export') }}" class="btn btn-success">
            <i class="fas fa-download me-2"></i> Export ke Excel
        </a>
        <small class="text-muted ms-2">Download semua data dalam format Excel</small>
    </div>
</div>

        <!-- Import Section -->
        <div class="card card-custom mb-4">
            <div class="card-header card-header-custom">
                <h5 class="mb-0"><i class="fas fa-file-import me-2"></i> Import Data</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teams.import') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-md-8">
                        <label for="importFile" class="form-label">File Excel</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="importFile" name="file" accept=".xlsx,.xls" required>
                            <button class="btn btn-outline-secondary" type="button" id="clearFile">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="info-text mt-1">Format file: .xlsx atau .xls (max 2MB)</div>
                    </div>
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-success me-2 flex-grow-1">
                            <i class="fas fa-upload me-2"></i> Import
                        </button>
                        <a href="{{ asset('templates/template_import_tim.xlsx') }}" class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i> Template
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Reset Data Section -->
        <div class="card card-custom mb-4 border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-trash-alt me-2"></i> Reset Data</h5>
            </div>
            <div class="card-body">
                <form id="resetForm" action="{{ route('teams.reset') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        PERINGATAN: Aksi ini akan menghapus SEMUA data tim dan debater secara permanen!
                    </div>
                    <button type="button" id="resetButton" class="btn btn-danger">
                        <i class="fas fa-broom me-2"></i> Reset Semua Data
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <h5 class="mb-3"><i class="fas fa-filter me-2"></i> Filter Data</h5>
            <form method="GET" action="{{ url()->current() }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="team_name" class="form-label">Nama Tim</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" 
                               value="{{ request('team_name') }}" placeholder="Cari nama tim...">
                    </div>
                    <div class="col-md-4">
                        <label for="debater_name" class="form-label">Nama Debater</label>
                        <input type="text" name="debater_name" id="debater_name" class="form-control" 
                               value="{{ request('debater_name') }}" placeholder="Cari nama debater...">
                    </div>
                    <div class="col-md-4">
                        <label for="study_program" class="form-label">Program Studi</label>
                        <input type="text" name="study_program" id="study_program" class="form-control" 
                               value="{{ request('study_program') }}" placeholder="Program studi...">
                    </div>
                    <div class="col-md-4">
                        <label for="payment_status" class="form-label">Status Pembayaran</label>
                        <select name="payment_status" id="payment_status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('payment_status') == '1' ? 'selected' : '' }}>Valid</option>
                            <option value="0" {{ request('payment_status') == '0' ? 'selected' : '' }}>Belum Valid</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" class="form-select">
                            <option value="">Semua Metode</option>
                            <option value="Manual" {{ request('payment_method') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            <option value="Transfer" {{ request('payment_method') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="Online" {{ request('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2 action-btn">
                            <i class="fas fa-search me-1"></i> Terapkan Filter
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary action-btn">
                            <i class="fas fa-sync-alt me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Results Info -->
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> 
            Menampilkan <strong>{{ $teams->total() }}</strong> tim
            @if(request()->anyFilled(['team_name', 'debater_name', 'study_program', 'payment_status', 'payment_method']))
                (Hasil filter)
            @endif
        </div>
        
        <!-- Teams List -->
        @if($teams->isEmpty())
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i> Tidak ada tim yang ditemukan dengan kriteria filter tersebut.
            </div>
        @else
            @foreach($teams as $team)
            <div class="team-item">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">
                            <i class="fas fa-users me-2 text-primary"></i> {{ $team->name }}
                        </h4>
                        <span class="badge rounded-pill {{ $team->payment_validated ? 'bg-success' : 'bg-warning' }} badge-payment">
                            {{ $team->payment_validated ? 'Valid' : 'Belum Valid' }}
                            <i class="fas {{ $team->payment_validated ? 'fa-check-circle' : 'fa-clock' }} ms-1"></i>
                        </span>
                    </div>
                    
                    <div class="d-flex flex-wrap justify-content-between mb-3">
                        <div class="me-3 mb-2">
                            <span class="text-muted">
                                <i class="fas fa-comment-dots me-2"></i>
                                <strong>Alasan:</strong> {{ $team->reason ?: '-' }}
                            </span>
                        </div>
                        <div class="me-3 mb-2">
                            <span class="text-muted">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <strong>Metode:</strong> {{ $team->payment_method ?: '-' }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <strong>Daftar:</strong> {{ $team->created_at->format('d M Y H:i') }}
                            </span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mb-3"><i class="fas fa-user-friends me-2"></i> Anggota Tim</h5>
                    <div class="row g-3">
                        @foreach($team->debaters as $debater)
                        <div class="col-md-6">
                            <div class="card h-100 debater-card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-user me-2"></i> 
                                        {{ ucfirst(str_replace('_', ' ', $debater->position)) }}: {{ $debater->name }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1"><strong><i class="fas fa-id-card me-2"></i> NPM:</strong> {{ $debater->npm ?: '-' }}</p>
                                            <p class="mb-1"><strong><i class="fas fa-graduation-cap me-2"></i> Prodi:</strong> {{ $debater->study_program ?: '-' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1"><strong><i class="fas fa-venus-mars me-2"></i> Gender:</strong> {{ $debater->gender ?: '-' }}</p>
                                            <p class="mb-1"><strong><i class="fas fa-phone me-2"></i> HP:</strong> {{ $debater->phone ?: '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0"><strong><i class="fas fa-map-marker-alt me-2"></i> Alamat:</strong></p>
                                        <div class="ps-4 mt-1">{{ $debater->address ?: 'Alamat tidak tersedia' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    

                </div>
            </div>
            @endforeach
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $teams->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clear file input
            document.getElementById('clearFile').addEventListener('click', function() {
                document.getElementById('importFile').value = '';
            });
            
            // Reset confirmation
            document.getElementById('resetButton').addEventListener('click', function() {
                Swal.fire({
                    title: 'Yakin Reset Data?',
                    text: "Semua data tim dan debater akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('resetForm').submit();
                    }
                });
            });
            
            // Success message
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
            @endif
        });
    </script>
</body>
</html>