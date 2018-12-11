<!-- Vendor JS -->
<script src="<?=base_url('assets')?>/vendor/slick/slick.min.js">
</script>
<script src="<?=base_url('assets')?>/vendor/wow/wow.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/animsition/animsition.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="<?=base_url('assets')?>/vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="<?=base_url('assets')?>/vendor/circle-progress/circle-progress.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?=base_url('assets')?>/vendor/chartjs/Chart.bundle.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="<?=base_url('assets')?>/js/main.js"></script>
<?php if (isset($scripts)) {
    foreach($scripts as $script) {?>
        <script src="<?=base_url('assets/').$script?>"></script>
    <?php }}?>
<?php if (isset($styles)) {
    foreach($styles as $style) {?>
        <link href="<?=base_url('assets/').$style?>" rel="stylesheet" media="all">
    <?php }}?>
</body>

</html>
<!-- end document-->