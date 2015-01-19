<?php
// Форма в админке
function form_admin_widget(){
?>
	<div class="wrap">
            <h2>Настройка виджета</h2>
            <form method="post" action="options.php">
                <?php wp_nonce_field('update-options'); ?>
                <h3>Введите текст:</h3>
                <input type="text" name="wclinik_1c_url" value="<?php echo get_option('wclinik_1c_url') ?>" /><br /><br />
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="wclinik_1c_url" />
                <input type="submit" name="update" value="Сохранить">
            </form>
	</div>
<?php
}
?>
