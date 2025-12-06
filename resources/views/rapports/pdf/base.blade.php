<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rapport') - Pharmacie</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
            @top-center {
                content: "Pharmacie - @yield('report-type', 'Rapport')";
                font-family: Arial, sans-serif;
                font-size: 10px;
                color: #666;
                border-bottom: 1px solid #ddd;
                padding-bottom: 5px;
            }
            @bottom-center {
                content: "Page " counter(page) " sur " counter(pages);
                font-family: Arial, sans-serif;
                font-size: 10px;
                color: #666;
                border-top: 1px solid #ddd;
                padding-top: 5px;
            }
            @bottom-right {
                content: "Généré le {{ now()->format('d/m/Y à H:i') }}";
                font-family: Arial, sans-serif;
                font-size: 8px;
                color: #999;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #336699;
        }

        .header h1 {
            font-size: 24px;
            color: #336699;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .header .period {
            font-size: 12px;
            color: #333;
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            border-left: 4px solid #336699;
        }

        .stat-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #336699;
            margin-bottom: 5px;
        }

        .stat-card .label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #336699;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 20px;
            background: #336699;
            margin-right: 10px;
            border-radius: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table.main-table {
            border: 1px solid #ddd;
        }

        th {
            background: #336699;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #e3f2fd;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary { background: #336699; color: white; }
        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #212529; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-info { background: #17a2b8; color: white; }
        .badge-secondary { background: #6c757d; color: white; }

        .amount {
            font-weight: bold;
            color: #28a745;
        }

        .amount.negative {
            color: #dc3545;
        }

        .rank {
            background: #ffc107;
            color: #212529;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 10px;
        }

        .rank.top-3 {
            background: linear-gradient(45deg, #ffd700, #ffb347);
            color: #8b4513;
        }

        .summary-box {
            background: #e3f2fd;
            border: 1px solid #336699;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }

        .summary-box h3 {
            color: #336699;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-style: italic;
        }

        .no-data::before {
            content: "📊";
            display: block;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .critical {
            background: #ffebee !important;
            border-left: 4px solid #dc3545 !important;
        }

        .warning {
            background: #fff8e1 !important;
            border-left: 4px solid #ffc107 !important;
        }

        .success {
            background: #e8f5e8 !important;
            border-left: 4px solid #28a745 !important;
        }

        .page-break {
            page-break-before: always;
        }

        .footer-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            font-size: 10px;
            color: #666;
            text-align: center;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 8px;
            margin: 5px 0;
        }

        @media print {
            .no-print { display: none !important; }
            
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
    </style>
    @yield('extra-styles')
</head>
<body>
    <div class="header">
        <h1>@yield('title', 'Rapport')</h1>
        <div class="subtitle">@yield('subtitle', 'Pharmacie - Système de gestion')</div>
        @if(isset($dateFrom) && isset($dateTo))
            <div class="period">
                Période: {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}
            </div>
        @endif
    </div>

    @yield('content')

    <div class="footer-info">
        <p><strong>Pharmacie</strong> - Rapport généré automatiquement</p>
        <p>Ce document est confidentiel et destiné uniquement à un usage interne</p>
    </div>
</body>
</html>