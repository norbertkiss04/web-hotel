<?php
function formatPrice($price) {
    return number_format($price, 0, ',', '.');
}
function formatDate($date) {
    return date("Y.m.d.", strtotime($date));

}
?>