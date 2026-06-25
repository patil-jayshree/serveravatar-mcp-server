<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authorize Application</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { font-size: 24px; margin-bottom: 20px; }
        .client-info { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .client-name { font-weight: bold; font-size: 18px; }
        .scopes { margin: 15px 0; }
        .scope { background: #e8f4fd; padding: 8px 12px; border-radius: 4px; margin: 5px 0; font-size: 14px; }
        .buttons { display: flex; gap: 10px; margin-top: 25px; }
        button { flex: 1; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .approve { background: #28a745; color: white; }
        .deny { background: #dc3545; color: white; }
        .approve:hover { background: #218838; }
        .deny:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Authorize Application</h1>
        <div class="client-info">
            <div class="client-name">{{ $client->name }}</div>
            <p>This application is requesting access to your account.</p>
        </div>
        
        @if(count($scopes) > 0)
        <div class="scopes">
            <strong>Requested permissions:</strong>
            @foreach($scopes as $scope)
                <div class="scope">{{ $scope->id }}</div>
            @endforeach
        </div>
        @endif
        
        <form method="POST" action="{{ url('/oauth/authorize') }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <input type="hidden" name="approve" value="1">
            <div class="buttons">
                <button type="submit" class="approve">Authorize</button>
                <button type="button" class="deny" onclick="document.getElementById('deny-form').submit();">Deny</button>
            </div>
        </form>
        
        <form id="deny-form" method="POST" action="{{ url('/oauth/authorize') }}" style="display:none;">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <input type="hidden" name="deny" value="1">
        </form>
    </div>
</body>
</html>
