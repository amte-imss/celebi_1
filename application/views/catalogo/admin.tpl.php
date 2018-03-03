<?php
if(isset($output)){
    foreach($output->css_files as $file):
?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php
    endforeach;
?>

<?php
    foreach($output->js_files as $file):
?>
    <script src="<?php echo $file; ?>"></script>
<?php
    endforeach;
}
?>

<div class="body">
    <div class="header">
        <h2>Agregar curso</h2>
    </div><br><br>
    <div class="lead">
        <div class="table">
            <!-- table-container-fluid panel -->
            <?php
            if(isset($output)){
                echo $output->output;
            }
            ?>
        </div>
    </div>
</div>
