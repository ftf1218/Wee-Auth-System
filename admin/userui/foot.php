<script type="text/javascript">
		get_xiaoxi2();
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?6cac99dda8a8368c5fa2d9268895478c";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script> 
</section>
</div>
</section>
<div class="app-footer wrapper-sm b-t bg-light text-xs">
        <span class="pull-right">1.0.0 <a href="/." class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span>
        <strong>Copyright</strong> 白云 © 2017 
    </div>
</div> 
<!-- 通用JS开始 -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
<script src="http://libs.useso.com/js/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="./userui/sweetalert.min.js"></script>
<script src="./userui/app-tooltip-demo.js"></script>
<script type="text/javascript">
  +function ($) {
	$(function(){
	  // class
	  $(document).on('click', '[data-toggle^="class"]', function(e){
		e && e.preventDefault();
		console.log('abc');
		var $this = $(e.target), $class , $target, $tmp, $classes, $targets;
		!$this.data('toggle') && ($this = $this.closest('[data-toggle^="class"]'));
		$class = $this.data()['toggle'];
		$target = $this.data('target') || $this.attr('href');
		$class && ($tmp = $class.split(':')[1]) && ($classes = $tmp.split(','));
		$target && ($targets = $target.split(','));
		$classes && $classes.length && $.each($targets, function( index, value ) {
		  if ( $classes[index].indexOf( '*' ) !== -1 ) {
			var patt = new RegExp( '\\s' + 
				$classes[index].
				  replace( /\*/g, '[A-Za-z0-9-_]+' ).
				  split( ' ' ).
				  join( '\\s|\\s' ) + 
				'\\s', 'g' );
			$($this).each( function ( i, it ) {
			  var cn = ' ' + it.className + ' ';
			  while ( patt.test( cn ) ) {
				cn = cn.replace( patt, ' ' );
			  }
			  it.className = $.trim( cn );
			});
		  }
		  ($targets[index] !='#') && $($targets[index]).toggleClass($classes[index]) || $this.toggleClass($classes[index]);
		});
		$this.toggleClass('active');
	  });

	  // collapse nav
	  $(document).on('click', 'nav a', function (e) {
		var $this = $(e.target), $active;
		$this.is('a') || ($this = $this.closest('a'));
		
		$active = $this.parent().siblings( ".active" );
		$active && $active.toggleClass('active').find('> ul:visible').slideUp(200);
		
		($this.parent().hasClass('active') && $this.next().slideUp(200)) || $this.next().slideDown(200);
		$this.parent().toggleClass('active');
		
		$this.next().is('ul') && e.preventDefault();

		setTimeout(function(){ $(document).trigger('updateNav'); }, 300);      
	  });
	});
  }(jQuery);
  </script>
</body>
</html>