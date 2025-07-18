<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente Clínico - {{ $expediente->nombre_paciente }}</title>
    <style>
        @page {
            margin: 1.5cm;
            size: A4;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #667eea;
            font-size: 22px;
            margin: 0;
            font-weight: bold;
        }

        .header .subtitle {
            color: #666;
            font-size: 12px;
            margin-top: 3px;
        }

        .credentials-grid {
            display: table;
            width: 100%;
            margin: 5px auto 0 auto;
        }

        .credentials-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: center;
        }

        .credential-item {
            font-size: 12px;
            color: #666;
            margin-bottom: 2px;
        }

        .patient-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .patient-info h3 {
            color: #667eea;
            margin: 0 0 8px 0;
            font-size: 14px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 3px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 2px 8px 2px 0;
            color: #495057;
        }

        .info-value {
            display: table-cell;
            padding: 2px 0;
        }

        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section h3 {
            color: #667eea;
            font-size: 14px;
            margin: 0 0 8px 0;
            border-bottom: 2px solid #667eea;
            padding-bottom: 3px;
        }

        .section-content {
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #fff;
        }

        .vital-signs {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .vital-signs .info-row {
            border-bottom: 1px solid #eee;
        }

        .vital-signs .info-row:last-child {
            border-bottom: none;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .page-number {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 10px;
            border-top: 1px solid #dee2e6;
            padding-top: 5px;
        }

        .no-data {
            color: #999;
            font-style: italic;
        }

        .important {
            font-weight: bold;
            color: #dc3545;
        }

        .date-time {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-bottom: 20px;
        }

        .consultation-date {
            text-align: center;
            font-size: 12px;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #667eea;
            padding-bottom: 5px;
        }

        .page-number {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 10px;
        }

        .page-break {
            page-break-before: always;
            margin-top: 0;
            padding-top: 0;
        }

        .page1-content {
            page-break-after: always;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        /* Asegurar que no haya páginas en blanco */
        .page2-content {
            min-height: 100vh;
        }

        /* Estilos para padecimientos adicionales */
        .additional-ailment {
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .ailment-header {
            background-color: #667eea;
            color: white;
            padding: 8px 12px;
            font-size: 12px;
            border-radius: 5px 5px 0 0;
        }

        .ailment-content {
            padding: 10px 12px;
            font-size: 11px;
            line-height: 1.4;
        }

        .ailment-separator {
            height: 10px;
            border-bottom: 1px dashed #dee2e6;
            margin: 10px 0;
        }

        /* Forzar que el contenido de la página 2 comience inmediatamente */
        .page-break:first-child {
            page-break-before: auto;
        }

        /* Eliminar espacios extra que puedan causar páginas en blanco */
        body {
            margin: 0;
            padding: 0;
        }

        .page-break .header {
            margin-top: 0;
            padding-top: 0;
        }

        /* Eliminar el salto de página automático */
        .page1-content {
            page-break-after: auto;
        }

        /* Estilos para la información de contacto */
        .contact-info {
            margin-top: 10px;
            text-align: center;
        }

        .contact-grid {
            display: table;
            width: 100%;
            margin: 0 auto;
        }

        .contact-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .contact-item {
            margin-bottom: 3px;
            font-size: 11px;
        }

        .contact-label {
            font-weight: bold;
            color: #333;
            margin-right: 8px;
        }

        .contact-value {
            color: #333;
        }
    </style>
</head>
<body>
    <!-- PÁGINA 1 -->
    <div class="page1-content">
        <div class="date-time">
            Generado el: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </div>

        <div class="consultation-date">
            Fecha de Consulta: {{ $expediente->fecha_atencion ? \Carbon\Carbon::parse($expediente->fecha_atencion)->format('d/m/Y') : 'N/A' }}
        </div>

        <div class="header">
            <h1>EXPEDIENTE CLÍNICO</h1>
            <div class="subtitle">SISTEMA DE AGENDAMIENTO MÉDICO INTELIGENTE</div>
            <div class="subtitle">Dra. Maricela Mayorga Martinez</div>
            <div class="subtitle">Egresada de la Universidad Autonoma del Edo. de Hidalgo - UAEH</div>
            <div class="credentials-grid">
                <div class="credentials-column">
                    <div class="credential-item">Posgraduada por la UNAM en la SSDDF</div>
                    <div class="credential-item">Hospital Pediatrico Coyoacan</div>
                    <div class="credential-item">Certificada por el Consejo mexicano de Pediatria no. 11496</div>
                </div>
                <div class="credentials-column">
                    <div class="credential-item">Cedula de pediatra : 4512474</div>
                    <div class="credential-item">Cedula profesional : 2390718</div>
                    <div class="credential-item">Reg. SSA 0146-02</div>
                </div>
            </div>
            <div class="contact-info">
                <div class="contact-grid">
                    <div class="contact-column">
                        <div class="contact-item">
                            <div class="contact-label">Teléfono:</div>
                            <div class="contact-value">01 763 737 60 93</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Teléfono:</div>
                            <div class="contact-value">01 738 725 19 37</div>
                        </div>
                    </div>
                    <div class="contact-column">
                        <div class="contact-item">
                            <div class="contact-label">Celular:</div>
                            <div class="contact-value">773 130 31 70</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Paciente -->
        <div class="patient-info">
            <h3>INFORMACIÓN DEL PACIENTE</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nombre Completo:</div>
                    <div class="info-value">{{ $expediente->nombre_paciente }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha de Consulta:</div>
                    <div class="info-value">{{ $expediente->fecha_atencion ? \Carbon\Carbon::parse($expediente->fecha_atencion)->format('d/m/Y') : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Número de Visita:</div>
                    <div class="info-value">{{ $expediente->numero_visita ?: '1' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Edad:</div>
                    <div class="info-value">{{ $expediente->edad }} años</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Género:</div>
                    <div class="info-value">{{ $expediente->genero }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Domicilio:</div>
                    <div class="info-value">{{ $expediente->domicilio ?: 'No especificado' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ocupación:</div>
                    <div class="info-value">{{ $expediente->ocupacion ?: 'No especificada' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha de Elaboración:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($expediente->fecha_elaboracion)->format('d/m/Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Hora de Elaboración:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($expediente->hora_elaboracion)->format('H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Tipo de Interrogatorio -->
        <div class="section">
            <h3>TIPO DE INTERROGATORIO</h3>
            <div class="section-content">
                {{ $expediente->tipo_interrogatorio ?: 'No especificado' }}
            </div>
        </div>

        <!-- Antecedentes -->
        <div class="section">
            <h3>ANTECEDENTES</h3>
            <div class="section-content">
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Heredo-familiares:</div>
                        <div class="info-value">{{ $expediente->antecedentes_heredo_familiares ?: 'No especificados' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Personales No Patológicos:</div>
                        <div class="info-value">{{ $expediente->antecedentes_personales_no_patologicos ?: 'No especificados' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Personales Patológicos:</div>
                        <div class="info-value">{{ $expediente->antecedentes_personales_patologicos ?: 'No especificados' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Perinatales:</div>
                        <div class="info-value">{{ $expediente->antecedentes_perinatales ?: 'No especificados' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desarrollo -->
        <div class="section">
            <h3>DESARROLLO</h3>
            <div class="section-content">
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Alimentación:</div>
                        <div class="info-value">{{ $expediente->alimentacion ?: 'No especificada' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Inmunizaciones:</div>
                        <div class="info-value">{{ $expediente->inmunizaciones ?: 'No especificadas' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Desarrollo Psicomotor:</div>
                        <div class="info-value">{{ $expediente->desarrollo_psicomotor ?: 'No especificado' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- PÁGINA 2 -->
    <div class="page-break page2-content">
        <div class="date-time">
            Generado el: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </div>

        <div class="consultation-date">
            Fecha de Consulta: {{ $expediente->fecha_atencion ? \Carbon\Carbon::parse($expediente->fecha_atencion)->format('d/m/Y') : 'N/A' }} | Visita #{{ $expediente->numero_visita ?: '1' }}
        </div>

        <div class="header">
            <h1>EXPEDIENTE CLÍNICO</h1>
            <div class="subtitle">SISTEMA DE AGENDAMIENTO MÉDICO INTELIGENTE</div>
            <div class="subtitle">Dra. Maricela Mayorga Martinez</div>
            <div class="subtitle">Egresada de la Universidad Autonoma del Edo. de Hidalgo - UAEH</div>
            <div class="credentials-grid">
                <div class="credentials-column">
                    <div class="credential-item">Posgraduada por la UNAM en la SSDDF</div>
                    <div class="credential-item">Hospital Pediatrico Coyoacan</div>
                    <div class="credential-item">Certificada por el Consejo mexicano de Pediatria no. 11496</div>
                </div>
                <div class="credentials-column">
                    <div class="credential-item">Cedula de pediatra : 4512474</div>
                    <div class="credential-item">Cedula profesional : 2390718</div>
                    <div class="credential-item">Reg. SSA 0146-02</div>
                </div>
            </div>
            <div class="contact-info">
                <div class="contact-grid">
                    <div class="contact-column">
                        <div class="contact-item">
                            <div class="contact-label">Teléfono:</div>
                            <div class="contact-value">01 763 737 60 93</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Teléfono:</div>
                            <div class="contact-value">01 738 725 19 37</div>
                        </div>
                    </div>
                    <div class="contact-column">
                        <div class="contact-item">
                            <div class="contact-label">Celular:</div>
                            <div class="contact-value">773 130 31 70</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Padecimiento Actual -->
        <div class="section">
            <h3>PADECIMIENTO ACTUAL</h3>
            <div class="section-content">
                {{ $expediente->padecimiento_actual ?: 'No especificado' }}
            </div>
        </div>

        @if($expediente->padecimientos_adicionales && count($expediente->padecimientos_adicionales) > 0)
        <!-- Padecimientos Adicionales -->
        <div class="section">
            <h3>PADECIMIENTOS ADICIONALES</h3>
            <div class="section-content">
                @foreach($expediente->padecimientos_adicionales as $padecimiento)
                    <div class="additional-ailment">
                        <div class="ailment-header">
                            <strong>Padecimiento Adicional #{{ $padecimiento['numero'] }}</strong>
                        </div>
                        <div class="ailment-content">
                            {{ $padecimiento['descripcion'] }}
                        </div>
                    </div>
                    @if(!$loop->last)
                        <div class="ailment-separator"></div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Interrogatorio por Sistemas -->
        <div class="section">
            <h3>INTERROGATORIO POR SISTEMAS</h3>
            <div class="section-content">
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Cardiovascular:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_cardiovascular ?: 'Sin alteraciones' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Respiratorio:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_respiratorio ?: 'Sin alteraciones' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Gastrointestinal:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_gastrointestinal ?: 'Sin alteraciones' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Genitourinario:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_genitourinario ?: 'Sin alteraciones' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Hematolinfático:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_hematolinfatico ?: 'Sin alteraciones' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Nervioso:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_nervioso ?: 'Sin alteraciones' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Musculoesquelético:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_musculo_esqueletico ?: 'Sin alteraciones' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Piel y Mucosas:</div>
                        <div class="info-value">{{ $expediente->interrogatorio_piel_mucosas ?: 'Sin alteraciones' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signos Vitales -->
        <div class="section">
            <h3>SIGNOS VITALES</h3>
            <div class="section-content">
                <div class="vital-signs">
                    <div class="info-row">
                        <div class="info-label">Tensión Arterial:</div>
                        <div class="info-value">{{ $expediente->signos_ta ?: 'No registrado' }} mmHg</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Temperatura:</div>
                        <div class="info-value">{{ $expediente->signos_temp ?: 'No registrada' }} °C</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Frecuencia Cardíaca:</div>
                        <div class="info-value">{{ $expediente->signos_frec_c ?: 'No registrada' }} lpm</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Frecuencia Respiratoria:</div>
                        <div class="info-value">{{ $expediente->signos_frec_r ?: 'No registrada' }} rpm</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Peso:</div>
                        <div class="info-value">{{ $expediente->signos_peso ?: 'No registrado' }} kg</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Talla:</div>
                        <div class="info-value">{{ $expediente->signos_talla ?: 'No registrada' }} cm</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exploración Física -->
        <div class="section">
            <h3>EXPLORACIÓN FÍSICA</h3>
            <div class="section-content">
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Habitus:</div>
                        <div class="info-value">{{ $expediente->exploracion_habitus ?: 'Normal' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Cabeza:</div>
                        <div class="info-value">{{ $expediente->exploracion_cabeza ?: 'Normal' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Cuello:</div>
                        <div class="info-value">{{ $expediente->exploracion_cuello ?: 'Normal' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tórax:</div>
                        <div class="info-value">{{ $expediente->exploracion_torax ?: 'Normal' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Abdomen:</div>
                        <div class="info-value">{{ $expediente->exploracion_abdomen ?: 'Normal' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Genitales:</div>
                        <div class="info-value">{{ $expediente->exploracion_genitales ?: 'Normal' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Extremidades:</div>
                        <div class="info-value">{{ $expediente->exploracion_extremidades ?: 'Normal' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Piel:</div>
                        <div class="info-value">{{ $expediente->exploracion_piel ?: 'Normal' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados de Laboratorio -->
        <div class="section">
            <h3>RESULTADOS DE LABORATORIO</h3>
            <div class="section-content">
                {{ $expediente->resultados_laboratorio ?: 'No se realizaron estudios de laboratorio' }}
            </div>
        </div>

        <!-- Estudios de Gabinete -->
        <div class="section">
            <h3>ESTUDIOS DE GABINETE</h3>
            <div class="section-content">
                {{ $expediente->estudios_gabinete ?: 'No se realizaron estudios de gabinete' }}
            </div>
        </div>

        <!-- Diagnósticos -->
        <div class="section">
            <h3>DIAGNÓSTICOS</h3>
            <div class="section-content">
                <div class="important">{{ $expediente->diagnosticos ?: 'No especificados' }}</div>
            </div>
        </div>

        <!-- Tratamiento -->
        <div class="section">
            <h3>TRATAMIENTO</h3>
            <div class="section-content">
                {{ $expediente->tratamiento ?: 'No especificado' }}
            </div>
        </div>

        <!-- Pronóstico -->
        <div class="section">
            <h3>PRONÓSTICO</h3>
            <div class="section-content">
                {{ $expediente->pronostico ?: 'No especificado' }}
            </div>
        </div>

        <div class="footer">
            <p>Este documento es generado automáticamente por el Sistema de Administración Médica Integral</p>
            <p>Expediente Clínico ID: {{ $expediente->id }}</p>
        </div>
    </div>
</body>
</html>
