<!DOCTYPE html>
<html>
<head>
    <title>Treatment Checklist PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; color: #007bff; }
        h4 { margin-top: 20px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        ul { list-style-type: none; padding: 0; }
        li { margin: 5px 0; }
        .yes { color: green; font-weight: bold; }
        .no { color: red; font-weight: bold; }
        .footer { text-align: center; margin-top: 40px; font-size: 11px; color: #888; }
    </style>
</head>
<body>
    <h2>KONTROLLBLATT</h2>
    <p><strong>Coworker Name:</strong> {{ $treatment->coworker_name }}</p>

    <h4>VOR DRUCK</h4>
    <ul>
        <li>Attachments am Modell: <span class="{{ $treatment->attachments_model ? 'yes' : 'no' }}">{{ $treatment->attachments_model ? 'Yes' : 'No' }}</span></li>
        <li>Bars am Modell: <span class="{{ $treatment->bars_model ? 'yes' : 'no' }}">{{ $treatment->bars_model ? 'Yes' : 'No' }}</span></li>
        <li>Name am Modell = Patient: <span class="{{ $treatment->name_patient ? 'yes' : 'no' }}">{{ $treatment->name_patient ? 'Yes' : 'No' }}</span></li>
        <li>Modell passt zu SetUp am Dashboard: <span class="{{ $treatment->model_dashboard ? 'yes' : 'no' }}">{{ $treatment->model_dashboard ? 'Yes' : 'No' }}</span></li>
        <li>CutOuts / Hooks / Wings vorhanden: <span class="{{ $treatment->cutouts_hooks ? 'yes' : 'no' }}">{{ $treatment->cutouts_hooks ? 'Yes' : 'No' }}</span></li>
        <li>Schnittlinie passt: <span class="{{ $treatment->schnittlinie ? 'yes' : 'no' }}">{{ $treatment->schnittlinie ? 'Yes' : 'No' }}</span></li>
    </ul>

    <h4>TIEFZIEHEN & SCHNEIDEN</h4>
    <ul>
        <li>Zahlen vergleichen: <span class="{{ $treatment->zahlen_vergleichen ? 'yes' : 'no' }}">{{ $treatment->zahlen_vergleichen ? 'Yes' : 'No' }}</span></li>
        <li>Cut Outs auf der Schiene: <span class="{{ $treatment->cutouts_schiene ? 'yes' : 'no' }}">{{ $treatment->cutouts_schiene ? 'Yes' : 'No' }}</span></li>
    </ul>

    <h4>VOR DEM EINPACKEN</h4>
    <ul>
        <li>Folie runtergenommen: <span class="{{ $treatment->folie_runtergenommen ? 'yes' : 'no' }}">{{ $treatment->folie_runtergenommen ? 'Yes' : 'No' }}</span></li>
        <li>Richtig einpacken - Zahlen: <span class="{{ $treatment->richtig_einpacken ? 'yes' : 'no' }}">{{ $treatment->richtig_einpacken ? 'Yes' : 'No' }}</span></li>
        <li>Richtiger ASR Zettel: <span class="{{ $treatment->richtiger_asr ? 'yes' : 'no' }}">{{ $treatment->richtiger_asr ? 'Yes' : 'No' }}</span></li>
    </ul>

    <div class="footer">
        Generated on {{ date('d M Y, H:i') }}
    </div>
</body>
</html>