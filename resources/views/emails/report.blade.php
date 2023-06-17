<!DOCTYPE html>
<html>

<head>
    <title>Medical Report</title>
    <style>
        .footer{
            items-align:center
        }
    </style>
</head>

<body>
    <div>
        <h1><u>{{ $data['patient_name'] }} - medical data</u></h1>

        <h2>Below is your taken medical data</h2>
        <p><strong>Xray : </strong> {{ $data['xray'] }}</p>
        <p><strong>Ultra Scan : </strong> {{ $data['ultrasound_scan'] }}</p>
        <p><strong>CT Scan : </strong> {{ $data['ct_scan'] }}</p>
        <p><strong>MRI : </strong> {{ $data['mri'] }}</p>
        <br/>

        <hr/><br/>

        <p>Feel free to contact us for any futher questions</p>
        <p>Mobile : (012) 2324234234</p>
        <p>Email : <a mailto='peopleoperations@kompletecare.com'>peopleoperations@kompletecare.com</a> </p>

    </div>

    <div class="footer">
    <hr/>
        <h3>Francis Rick Lartey</h3>
    <hr/>
    </div>

</body>

</html>
