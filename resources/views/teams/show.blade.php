<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tim {{ $team->name ?? 'Tanpa Nama' }} | D'MASIF</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .header-detail {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .detail-card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
            border: none;
        }
        .debater-card {
            border-left: 4px solid #0d6efd;
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }
        .debater-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .payment-status {
            font-size: 1rem;
            padding: 8px 15px;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
            display: inline-block;
        }
        .back-button {
            transition: all 0.3s ease;
        }
        .back-button:hover {
            transform: translateX(-5px);
        }
        .print-only {
            display: none;
        }
        @media print {
            .no-print {
                display: none;
            }
            .print-only {
                display: block;
            }
            body {
                padding-top: 0;
                background-color: white;
            }
            .detail-card, .debater-card {
                box-shadow: none;
                border: 1px solid #dee2e6;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-detail text-center">
            <div class="d-flex justify-content-between align-items-center px-4">
                <a href="{{ route('teams.index') }}" class="btn btn-light back-button no-print">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <h2 class="mb-0 flex-grow-1 text-center">
                    <i class="fas fa-users me-2"></i> Detail Tim {{ $team->name ?? 'Tanpa Nama' }}
                </h2>
                <div style="width: 120px;" class="no-print"></div>
            </div>
        </div>

        <!-- Team Info Card -->
        <div class="card detail-card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i> Informasi Tim</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-3">
                            <span class="info-label"><i class="fas fa-tag me-2"></i>Nama Tim:</span>
                            <span class="fw-bold">{{ $team->name ?? '-' }}</span>
                        </p>
                        <p class="mb-3">
                            <span class="info-label"><i class="fas fa-calendar-alt me-2"></i>Tanggal Daftar:</span>
                            {{ $team->created_at ? $team->created_at->format('d F Y H:i') : '-' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-3">
                            <span class="info-label"><i class="fas fa-money-bill-wave me-2"></i>Metode Pembayaran:</span>
                            <span class="badge bg-info text-dark">{{ $team->payment_method ?? '-' }}</span>
                        </p>
                        <p class="mb-3">
                            <span class="info-label"><i class="fas fa-check-circle me-2"></i>Status Pembayaran:</span>
                            <span class="badge rounded-pill {{ ($team->payment_validated ?? false) ? 'bg-success' : 'bg-warning' }} payment-status">
                                {{ ($team->payment_validated ?? false) ? 'Valid' : 'Belum Valid' }}
                                <i class="fas {{ ($team->payment_validated ?? false) ? 'fa-check' : 'fa-clock' }} ms-1"></i>
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h5><i class="fas fa-comment-dots me-2"></i> Alasan Mengikuti Lomba</h5>
                    <div class="p-3 bg-light rounded">
                        {{ $team->reason ?? 'Tidak ada alasan yang dicantumkan' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Debaters Section -->
        <h3 class="mb-4"><i class="fas fa-user-friends me-2"></i> Anggota Tim</h3>
        <div class="row">
            @forelse($team->debaters ?? [] as $debater)
            <div class="col-md-6 mb-4">
                <div class="card h-100 debater-card">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">
                            <i class="fas fa-user me-2"></i> 
                            {{ ucfirst(str_replace('_', ' ', $debater->position ?? 'debater')) }}: {{ $debater->name ?? '-' }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p>
                                    <span class="info-label"><i class="fas fa-id-card me-2"></i>NPM:</span>
                                    {{ $debater->npm ?? '-' }}
                                </p>
                                <p>
                                    <span class="info-label"><i class="fas fa-graduation-cap me-2"></i>Program Studi:</span>
                                    {{ $debater->study_program ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <span class="info-label"><i class="fas fa-venus-mars me-2"></i>Jenis Kelamin:</span>
                                    {{ $debater->gender ?? '-' }}
                                </p>
                                <p>
                                    <span class="info-label"><i class="fas fa-phone me-2"></i>No. HP:</span>
                                    {{ $debater->phone ?? '-' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h5><i class="fas fa-map-marker-alt me-2"></i> Alamat Lengkap</h5>
                            <div class="p-3 bg-light rounded">
                                {{ $debater->address ?? 'Alamat tidak tersedia' }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i> Terdaftar: {{ $debater->created_at ? $debater->created_at->diffForHumans() : '-' }}
                        </small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Tidak ada data debater yang tersedia
                </div>
            </div>
            @endforelse
        </div>

        <!-- Additional Actions -->
        <div class="d-flex justify-content-between mt-4 mb-5 no-print">
            <a href="{{ route('teams.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
            <div>
                <button class="btn btn-outline-primary me-2" id="printButton">
                    <i class="fas fa-print me-2"></i> Cetak
                </button>
                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i> Edit Data
                </a>
            </div>
        </div>
    </div>

    <!-- Print Header (hidden until printing) -->
    <div class="print-only text-center mb-4">
        <h2>Detail Tim {{ $team->name ?? 'Tanpa Nama' }}</h2>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tombol cetak
            document.getElementById('printButton').addEventListener('click', function() {
                window.print();
            });
            
            // Log untuk debugging
            console.log('Detail page loaded for team:', {!! json_encode($team) !!});
        });
    </script>
</body>
</html>