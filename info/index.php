<!DOCTYPE html>
<html lang="ja">
    <head>
        <link rel="icon" href="/image/icon.ico">
    </head>
    <body>
        <p id=device></p>
        <script src="platform.js"></script>
        <script type="text/javascript">
            $("#device").text(platform.description);
        </script>
    </body>
</html>    