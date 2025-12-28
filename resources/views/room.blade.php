<!DOCTYPE html>
<html>
<head>
    <title>Stanza {{ $room->code }}</title>
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app">
        <room-component room-code="{{ $room->code }}"></room-component>
    </div>
</body>
</html>

