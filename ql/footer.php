<?php
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> -->
    <link href="footer.css" rel="stylesheet">
</head>

<body>
    <div class="sticky-top">
        <footer class="bd-footer py-5 mt-5 bg-light">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="https://getbootstrap.jp/" aria-label="Bootstrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="d-block me-2" viewBox="0 0 118 94" role="img">
                                <title>Bootstrap</title>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path>
                            </svg>
                            <span class="fs-5">Bootstrap</span>
                        </a>
                        <ul class="list-unstyled small text-muted my-4">
                            <li>
                                <svg class="bi bi-envelope" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14 3H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"></path>
                                    <path d="M.05 3.555C.017 3.698 0 3.847 0 4v.697l5.803 3.546L0 11.801V12c0 .306.069.596.192.856l6.57-4.027L8 9.586l1.239-.757 6.57 4.027c.122-.26.191-.55.191-.856v-.2l-5.803-3.557L16 4.697V4c0-.153-.017-.302-.05-.445L8 8.414.05 3.555z"></path>
                                </svg>
                                <a href="mailto:">
                                    そんなのも教えないよ</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-2 offset-lg-1 mb-3">
                        <h5>Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="https://getbootstrap.jp/">Home</a></li>
                            <li class="mb-2"><a href="https://getbootstrap.jp/docs/5.0/">Docs</a></li>
                            <li class="mb-2"><a href="https://getbootstrap.jp/docs/5.0/examples/">Examples</a></li>
                            <li class="mb-2"><a href="https://opencollective.com/bootstrap">Themes</a></li>
                            <li class="mb-2"><a href="https://blog.getbootstrap.com/">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <h5>Guides</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="https://getbootstrap.jp/docs/5.0/getting-started/">Getting started</a></li>
                            <li class="mb-2"><a href="https://getbootstrap.jp/docs/5.0/examples/starter-template/">Starter template</a></li>
                            <li class="mb-2"><a href="https://getbootstrap.jp/docs/5.0/getting-started/webpack/">Webpack</a></li>
                            <li class="mb-2"><a href="https://getbootstrap.jp/docs/5.0/getting-started/parcel/">Parcel</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <h5>Projects</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="https://github.com/twbs/bootstrap">Bootstrap 5</a></li>
                            <li class="mb-2"><a href="https://github.com/twbs/bootstrap/tree/v4-dev">Bootstrap 4</a></li>
                            <li class="mb-2"><a href="https://github.com/twbs/icons">Icons</a></li>
                            <li class="mb-2"><a href="https://github.com/twbs/rfs">RFS</a></li>
                            <li class="mb-2"><a href="https://github.com/twbs/bootstrap-npm-starter">npm starter</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <h5>Community</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="https://github.com/twbs/bootstrap/issues">Issues</a></li>
                            <li class="mb-2"><a href="https://github.com/twbs/bootstrap/discussions">Discussions</a></li>
                            <li class="mb-2"><a href="https://github.com/sponsors/twbs">Corporate sponsors</a></li>
                            <li class="mb-2"><a href="https://opencollective.com/bootstrap">Open Collective</a></li>
                            <li class="mb-2"><a href="https://bootstrap-slack.herokuapp.com/">Slack</a></li>
                            <li class="mb-2"><a href="https://stackoverflow.com/questions/tagged/bootstrap-5">Stack Overflow</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <p class="text-muted">©︎<?php echo $year; ?> T.Y</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
</body>

</html>