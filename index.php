<?php

    $firstUrl = 'https://crm.amir';
    $secondUrl = 'https://crm_admin.amir';
?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api Server Tester</title>
    <link href="tailwind.min.css" rel="stylesheet">
</head>
<body class=" text-white">

<header class="bg-gray-800 text-white py-4">
    <div class="container mx-auto text-center">
        Api Request Tester
    </div>
</header>

<!-- Table -->
<div class="container mx-auto p-4">
    <table class="w-full table-auto border-collapse border">
        <thead>
        <tr>
            <th class="bg-gray-800 text-white border p-2">Request ID</th>
            <th class="bg-gray-800 text-white border p-2">Url</th>
            <th class="bg-gray-800 text-white border p-2">Status Code</th>
            <th class="bg-gray-800 text-white border p-2">Response Time (ms)</th>
        </tr>
        </thead>
        <tbody id="response-body">
        <tr class="text-center" style="display: none" id="sample_response_item">
            <td class="req-id border p-2 text-black"></td>
            <td class="req-host border p-2 text-black"></td>
            <td class="req-status-code border p-2 text-black"></td>
            <td class="req-time border p-2 text-black"></td>
        </tr>
        <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

<div class="container mx-auto p-4">
    <div class="alert alert-info text-center">
        <span class="first-site"><?php echo $firstUrl; ?></span> = <span class="first-site-responses-time"></span>
        <span class="second-site"><?php echo $secondUrl; ?></span> = <span class="second-site-responses-time"></span>
    </div>
</div>

<script src="axios.min.js"></script>
<script src="jquery.js"></script>
<script src="app.js"></script>

</body>
</html>
