<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticker</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/cruid@1.0.0/index.min.js"></script>
    
</head>

<body style="background-color: white">

    @php
        //Configure the Google Client
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');

        //Referencing the Google credentials file for the API
        $path = 'C:\xampp\htdocs\InfoTicker\credentials.json';
        $client->setAuthConfig($path);

        $service = new \Google_Service_Sheets($client);

        //Fetching the spreadsheet ID
        $spreadsheetId = '1230MzB26-3HlNzMnc5KgkKsPr0zEZvyEB6StdE2B-sQ';
        $spreadsheet = $service->spreadsheets->get($spreadsheetId);
        //var_dump($spreadsheet);

        $range = 'Sheet1!B2:B7';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $rows = $response->getValues();
        
    @endphp

    {{-- Form to popuate the spraedsheet with the info you want. --}}
    <div class="container" style="padding-top: 6rem">

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Send a message to the Ticker</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div>
                    <form class="" name="Form-Submit">
                        <div class="mb-3 p-3">
                            <label for="examleFormControlInput1" class="form-label">Name</label>
                            <input class="form-control" name="Request by" type="text" placeholder="Name" required>
                        </div>
                        <div class="p-3">
                            <label for="examleFormControlInput1" class="form-label">Message</label>
                            <textarea class="form-control" name="Message" type="text" placeholder="Message" rows="3" required></textarea>
                        </div>
                        <div class="p-3">
                        <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>   
    {{-- The image shown on the application --}}
    <div style="text-align: center;">
        <img class="img" src="..\img\img.jpg">
    </div>

    {{-- The ticker section of the application. --}}
    <div class="ticker-conatiner">
        <div class="ticker-wrapper">
            <div class="ticker">
                @foreach ($rows as $item)
                  <div class="ticker_item"><?php echo str_replace(array('[',']','"',','), " ", json_encode($item))?></div>     
                @endforeach   
            </div>
        </div>
    </div>

    <div class="but">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModalCenter">
            Add Message
        </button>
    </div>

</div>

</body>
<script>
    const scriptURL = 'https://script.google.com/macros/s/AKfycbzQd6goPcAXsdtwWjJrQMyHd8RrDuo9PW20mYenjn7w3fku0wTtJ6yAUfDNj7n142yt/exec'
      const form = document.forms['Form-Submit']
      form.addEventListener('submit', e => {
      e.preventDefault()
      fetch(scriptURL, { method: 'POST', body: new FormData(form)})
      .then(response => console.log('Success!', response))
      .catch(error => console.error('Error!', error.message))
      });

</script>
</html>