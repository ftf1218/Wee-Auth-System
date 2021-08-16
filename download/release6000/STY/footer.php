<?
/*
 * @FilePath: /STY/footer.php
 * @author: Wibus
 * @Date: 2021-04-17 16:06:35
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-13 15:07:37
 * Coding With IU
 */
if (defined('FOOTER')){ $footer = FOOTER; };
$this->need($footer);
?>

<link
href="https://cdn.bootcss.com/font-awesome/5.13.0/css/all.css"
rel="stylesheet">
<script async="async" src="<?php echo $GLOBALS['assetURL']; ?>js/STY.main.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/wee-design/Wee.js/src/wee.min.js"></script>
<script async="async" src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

<!-- <link rel="stylesheet" href="<?php echo $GLOBALS['assetURL'] ?>css/sqplayer.css" type="text/css">
<script async="async" src="<?php echo $GLOBALS['assetURL'] ?>js/sqplayer.js"></script> -->

<script>
    STY_Method.documentLoad();
    let STY_component = {
"HEADNAV": "<? echo HEADNAV ?>",
"CAROUSEL": "<? echo CAROUSEL ?>",
"LIST": "<? echo SLIST ?>",
"ARCHIEVE": "<? echo ARCHIEVE ?>",
"FOOTER": "<? echo FOOTER ?>",
    }
</script>

<?php 
// Imouse 鼠标
if (!empty($this->options->Show) && in_array('IMouse', $this->options->Show)): ?>
    <script src="https://cdn.jsdelivr.net/gh/rikumi/imouse@master/dist/index.js"></script>
    <script>
      window.addEventListener('DOMContentLoaded', () => IMouse.default.init({
  defaultBackgroundColor: <?php $this->options->IMouseDefaultBackgroundColor(); ?>,
  activeBackgroundColor: <?php $this->options->IMouseActiveBackgroundColor();?>,
  defaultSize: <?php $this->options->IMouseDefaultSize(); ?>,
  activeSite: <?php $this->options->IMouseActiveSize(); ?>,
  hoverPadding: <?php $this->options->IMouseHoverPadding(); ?>,
  activePadding: <?php $this->options->IMouseActivePadding(); ?>,
  selectionHeight: <?php $this->options->IMouseSelectionHeight();?>,
  selectionWidth: <?php $this->options->IMouseSelectionWidth();?>,
  selectionRadus: <?php $this->options->IMouseSelectionRadius();?>,
}))
    </script>
<?php endif; ?>

<?php if (!empty($this->options->Show) && in_array('Pjax', $this->options->Show)): ?>
<script>
document.addEventListener('pjax:send', function () {
    document.body.classList.add("loading")
    STY_Method.Pjax_Start();
})
document.addEventListener('pjax:complete', function () {
    document.body.classList.remove("loading")
    STY_Method.Pjax_Complete();
})
</script>
<?php endif; ?>

<!-- User Like -->
<? $GLOBALS['options']->footer() ?>
<script>
    <? $GLOBALS['options']->js() ?>
</script>
<style>
    <? $GLOBALS['options']->css() ?>
</style>



</body>

</html>