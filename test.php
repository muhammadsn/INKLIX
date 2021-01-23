<?php
echo urldecode("
    Actually, there is not a way to directly delete a cookie. Just use setcookie with expiration date in the past, to trigger the removal mechanism in your browser.
");