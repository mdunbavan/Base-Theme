<form method="get" class="search-form clearfix" class="search-form" action="<?php bloginfo( 'home' ); ?>/">
	<input class="search-text" type="text" name="s" id="search-text" value="<?php if ( is_search() ) echo esc_attr( get_search_query() ); else echo 'Search this site...'; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
	<input name="submit" type="submit" class="search-submit" value="Go" />
</form>