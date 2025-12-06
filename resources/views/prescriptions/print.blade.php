<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordonnance - {{ $prescription->prescription_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        
        .prescription {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .prescription::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #336699 0%, #4a90e2 100%);
        }
        
        .header {
            text-align: center;
            padding-bottom: 30px;
            margin-bottom: 30px;
            border-bottom: 3px solid #336699;
            position: relative;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .logo {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 25px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            border: 4px solid #f8f9fa;
            position: relative;
        }
        
        .logo img {
            max-width: 80px !important;
            max-height: 80px !important;
            border-radius: 50%;
        }
        
        .logo i {
            color: #336699 !important;
            font-size: 48px !important;
        }
        
        .system-info {
            text-align: left;
        }
        
        .system-name {
            font-size: 42px;
            font-weight: 700;
            color: #336699;
            margin-bottom: 5px;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .system-subtitle {
            color: #336699;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .pharmacy-info {
            color: #888;
            font-size: 12px;
            font-weight: 400;
        }
        
        .prescription-title {
            text-align: center;
            margin: 30px 0;
            font-size: 22px;
            font-weight: 700;
            color: #336699;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 12px;
            border: 2px solid #336699;
            position: relative;
        }
        
        .prescription-title::before {
            content: '📋';
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
        }
        
        .status-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: none;
            border-left: 5px solid #17a2b8;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 0 10px 10px 0;
            color: #0c5460;
            font-weight: 500;
        }
        
        .info-section {
            margin-bottom: 25px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .patient-info {
            background: linear-gradient(135deg, #e8f4fd 0%, #d1ecf1 100%);
            border-left: 5px solid #336699;
            padding: 20px;
        }
        
        .doctor-info {
            background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);
            border-left: 5px solid #28a745;
            padding: 20px;
        }
        
        .allergies-alert {
            background: linear-gradient(135deg, #f8d7da 0%, #f1c2c7 100%);
            border-left: 5px solid #dc3545;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 12px 12px 0;
            color: #721c24;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }
        
        .medical-notes {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-left: 5px solid #ffc107;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 12px 12px 0;
        }
        
        .pharmacist-notes {
            background: linear-gradient(135deg, #e8f4fd 0%, #d6eaff 100%);
            border-left: 5px solid #007bff;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 12px 12px 0;
        }
        
        .info-title {
            font-weight: 700;
            color: #336699;
            font-size: 16px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .info-title::before {
            content: '▶';
            margin-right: 10px;
            color: #336699;
        }
        
        .info-line {
            margin-bottom: 8px;
            font-weight: 400;
        }
        
        .info-line strong {
            color: #336699;
            font-weight: 600;
        }
        
        .medications-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .medications-table th {
            background: linear-gradient(135deg, #336699 0%, #4a90e2 100%);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .medications-table td {
            border: none;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 12px;
            background: white;
        }
        
        .medications-table tbody tr:nth-child(even) td {
            background: #f8f9fa;
        }
        
        .medications-table tbody tr:hover td {
            background: rgba(51, 102, 153, 0.05);
        }
        
        .medications-table .text-center {
            text-align: center;
        }
        
        .prescription-footer {
            margin-top: 40px;
            border-top: 3px solid #336699;
            padding-top: 30px;
        }
        
        .warning-section {
            text-align: center;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            padding: 20px;
            border-radius: 12px;
            border: 2px solid #ffc107;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
        }
        
        .warning-section strong {
            color: #856404;
            font-size: 16px;
            font-weight: 700;
        }
        
        .warning-section .warning-text {
            color: #856404;
            font-size: 13px;
            margin-top: 10px;
        }
        
        .signatures {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .signature-box {
            flex: 1;
            height: 100px;
            border: 2px solid #336699;
            text-align: center;
            padding: 15px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .signature-box strong {
            color: #336699;
            font-weight: 600;
            font-size: 13px;
        }
        
        .footer-info {
            text-align: center;
            font-size: 11px;
            color: #666;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #336699 0%, #4a90e2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(51, 102, 153, 0.4);
        }
        
        @media print {
            body {
                margin: 0;
                padding: 10px;
                background: white;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            .prescription {
                border-radius: 0;
                box-shadow: none;
                padding: 20px;
            }
            
            .no-print {
                display: none !important;
            }
            
            .medications-table th {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            .signature-box {
                page-break-inside: avoid;
            }
            
            .allergies-alert {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        
        .badge-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: #212529;
        }
        
        .badge-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        
        .badge-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
        }
        
        .delivery-progress {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }
        
        .progress-complete {
            background: #d4edda;
            color: #155724;
        }
        
        .progress-partial {
            background: #fff3cd;
            color: #856404;
        }
        
        .progress-pending {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Imprimer
    </button>

    <div class="prescription">
        <!-- En-tête avec logo PHARMACIA -->
        <div class="header">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="PHARMACIA Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <i class="fas fa-pills" style="display: none;"></i>
                </div>
                <div class="system-info">
                    <div class="system-name">PHARMACIA</div>
                    <div class="system-subtitle">Pharmacie Moderne & Professionnelle</div>
                    <div class="pharmacy-info">
                        Système de Gestion de Pharmacie<br>
                        123 Avenue de la Santé, 75001 Paris<br>
                        Tél: 01 23 45 67 89 | Email: contact@pharmacia.com
                    </div>
                </div>
            </div>
        </div>

        <!-- Titre de l'ordonnance -->
        <div class="prescription-title">
            ORDONNANCE N° {{ $prescription->prescription_number }}
        </div>

        <!-- Statut de l'ordonnance -->
        <div class="status-info">
            <strong>📊 Statut de l'ordonnance:</strong> 
            <span class="badge badge-{{ $prescription->status === 'completed' ? 'success' : ($prescription->status === 'partially_delivered' ? 'warning' : ($prescription->isExpired() ? 'danger' : 'info')) }}">
                {{ $prescription->status_label }}
            </span>
            @if($prescription->isExpired())
                - <span style="color: #dc3545; font-weight: 700;">⚠️ EXPIRÉE</span> (depuis le {{ $prescription->expiry_date->format('d/m/Y') }})
            @elseif($prescription->isAboutToExpire())
                - <span style="color: #ffc107; font-weight: 700;">⚠️ EXPIRE BIENTÔT</span> ({{ $prescription->expiry_date->diffInDays(now()) }} jour(s) restant(s))
            @endif
        </div>

        <!-- Alerte allergies -->
        @if($prescription->client->allergies)
            <div class="allergies-alert">
                <strong>⚠️ ALLERGIES CONNUES DU PATIENT:</strong> {{ $prescription->client->allergies }}
            </div>
        @endif

        <!-- Informations patient -->
        <div class="info-section patient-info">
            <div class="info-title">👤 INFORMATIONS PATIENT</div>
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <div class="info-line"><strong>Nom complet:</strong> {{ $prescription->client->full_name }}</div>
                    @if($prescription->client->date_of_birth)
                        <div class="info-line"><strong>Date de naissance:</strong> {{ $prescription->client->date_of_birth->format('d/m/Y') }}</div>
                        <div class="info-line"><strong>Âge:</strong> {{ $prescription->client->age }} ans</div>
                    @endif
                    @if($prescription->client->address)
                        <div class="info-line"><strong>Adresse:</strong> {{ $prescription->client->address }}</div>
                    @endif
                </div>
                <div style="flex: 1; min-width: 250px;">
                    @if($prescription->client->phone)
                        <div class="info-line"><strong>📞 Téléphone:</strong> {{ $prescription->client->phone }}</div>
                    @endif
                    @if($prescription->client->insurance_number)
                        <div class="info-line"><strong>🏥 N° Assurance:</strong> {{ $prescription->client->insurance_number }}</div>
                    @endif
                    @if($prescription->client->city)
                        <div class="info-line"><strong>🏙️ Ville:</strong> {{ $prescription->client->city }} {{ $prescription->client->postal_code }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informations médecin -->
        <div class="info-section doctor-info">
            <div class="info-title">👨‍⚕️ MÉDECIN PRESCRIPTEUR</div>
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <div class="info-line"><strong>Docteur:</strong> {{ $prescription->doctor_name }}</div>
                    @if($prescription->doctor_speciality)
                        <div class="info-line"><strong>Spécialité:</strong> {{ $prescription->doctor_speciality }}</div>
                    @endif
                    @if($prescription->doctor_phone)
                        <div class="info-line"><strong>📞 Téléphone:</strong> {{ $prescription->doctor_phone }}</div>
                    @endif
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <div class="info-line"><strong>📅 Date de prescription:</strong> {{ $prescription->prescription_date->format('d/m/Y') }}</div>
                    <div class="info-line"><strong>⏰ Validité jusqu'au:</strong> {{ $prescription->expiry_date->format('d/m/Y') }}</div>
                    <div class="info-line"><strong>👤 Créée par:</strong> {{ $prescription->createdBy->name }}</div>
                </div>
            </div>
        </div>

        <!-- Notes médicales -->
        @if($prescription->medical_notes)
            <div class="medical-notes">
                <strong>📝 NOTES MÉDICALES</strong>
                <p style="margin: 10px 0 0 0; font-weight: 400;">{{ $prescription->medical_notes }}</p>
            </div>
        @endif

        <!-- Tableau des médicaments -->
        <table class="medications-table">
            <thead>
                <tr>
                    <th>💊 MÉDICAMENT</th>
                    <th class="text-center">📦 QTÉ PRESCRITE</th>
                    <th class="text-center">✅ QTÉ DÉLIVRÉE</th>
                    <th>💉 POSOLOGIE</th>
                    <th>📋 INSTRUCTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->prescriptionItems as $item)
                    <tr>
                        <td>
                            <strong style="color: #336699;">{{ $item->product_name }}</strong>
                            @if($item->product && $item->product->dosage)
                                <br><small style="color: #666;">Dosage: {{ $item->product->dosage }}</small>
                            @endif
                            @if($item->duration_days)
                                <br><small style="color: #17a2b8; font-weight: 500;">⏱️ Durée: {{ $item->duration_days }} jour(s)</small>
                            @endif
                            @if(!$item->hasValidProduct())
                                <br><small style="color: #dc3545; font-weight: 500;">⚠️ Produit non disponible</small>
                            @endif
                        </td>
                        <td class="text-center" style="font-weight: 600;">{{ $item->quantity_prescribed }}</td>
                        <td class="text-center">
                            <span style="font-weight: 600; color: {{ $item->quantity_delivered == $item->quantity_prescribed ? '#28a745' : ($item->quantity_delivered > 0 ? '#ffc107' : '#6c757d') }};">
                                {{ $item->quantity_delivered }}
                            </span>
                            @if($item->remaining_quantity > 0)
                                <br><span class="delivery-progress progress-partial">Reste: {{ $item->remaining_quantity }}</span>
                            @elseif($item->quantity_delivered == $item->quantity_prescribed)
                                <br><span class="delivery-progress progress-complete">✓ Complet</span>
                            @elseif($item->quantity_delivered == 0)
                                <br><span class="delivery-progress progress-pending">En attente</span>
                            @endif
                        </td>
                        <td style="font-weight: 600; color: #336699;">{{ $item->dosage_instructions }}</td>
                        <td>{{ $item->instructions ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Notes du pharmacien -->
        @if($prescription->pharmacist_notes)
            <div class="pharmacist-notes">
                <strong>💊 NOTES DU PHARMACIEN</strong>
                <p style="margin: 10px 0 0 0; font-weight: 400;">{{ $prescription->pharmacist_notes }}</p>
            </div>
        @endif

        <!-- Pied de page -->
        <div class="prescription-footer">
            <div class="warning-section">
                <strong>⚠️ INSTRUCTIONS IMPORTANTES POUR LE PATIENT</strong><br><br>
                <div class="warning-text" style="text-align: left;">
                    ✓ Respectez scrupuleusement la posologie prescrite par votre médecin<br>
                    ✓ Ne modifiez pas les doses sans avis médical<br>
                    ✓ Terminez le traitement même si vous vous sentez mieux<br>
                    ✓ En cas d'effets indésirables, consultez immédiatement votre médecin ou pharmacien<br>
                    ✓ Conservez les médicaments dans leur emballage d'origine<br>
                    ✓ Vérifiez les dates d'expiration avant utilisation
                </div>
            </div>

            <!-- Informations d'impression -->
            <div style="display: flex; justify-content: space-between; margin-bottom: 30px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px; border-radius: 10px;">
                <div>
                    <strong>📅 Date d'impression:</strong> {{ now()->format('d/m/Y à H:i') }}
                </div>
                <div>
                    <strong>👤 Imprimé par:</strong> {{ $prescription->createdBy->name }}
                </div>
                <div>
                    <strong>📊 Progression:</strong> {{ $prescription->delivery_percentage ?? 0 }}%
                </div>
            </div>

            <!-- Signatures -->
            <div class="signatures">
                <div class="signature-box">
                    <strong>✍️ Signature du médecin</strong>
                    <div style="margin-top: 10px; color: #666; font-weight: 500;">Dr {{ $prescription->doctor_name }}</div>
                </div>
                <div class="signature-box">
                    <strong>🏥 Cachet et signature<br>du pharmacien</strong>
                    <div style="margin-top: 10px; color: #666; font-weight: 500;">{{ auth()->user()->name ?? 'Pharmacien' }}</div>
                </div>
            </div>

            <div class="footer-info">
                <strong style="color: #336699;">PHARMACIA - Pharmacie Moderne & Professionnelle</strong><br>
                Système de Gestion de Pharmacie<br>
                N° SIRET: 123 456 789 00012 | Pharmacien responsable: {{ auth()->user()->name ?? 'Pharmacien' }}<br>
                📞 Contact: 01 23 45 67 89 | 📧 contact@pharmacia.com<br><br>
                <em>Cette ordonnance fait foi pour la délivrance des médicaments prescrits</em><br>
                <small>Document généré automatiquement le {{ now()->format('d/m/Y à H:i:s') }}</small>
            </div>
        </div>
    </div>

    <script>
        // Fermer la fenêtre après impression (optionnel)
        window.onafterprint = function() {
            // window.close(); // Décommentez si vous voulez fermer automatiquement
        }
        
        // Animation d'impression
        document.querySelector('.print-button').addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    </script>
</body>
</html>