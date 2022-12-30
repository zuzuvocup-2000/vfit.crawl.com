<?php if(!isset($member) || !is_array($member) || count($member) == 0){ ?>
	<script>
		$(document).ready(function(){
			UIkit.modal("#login_hd").show();
			$('.modal-auth-general').removeClass('block')
            $('.wrap-modal-login').addClass('block')
		})
	</script>
<?php } ?>

<div class="wrap-buy-lesson">
	<div class="uk-container uk-container-center">
		<div class="heading-1 uk-text-center uk-width-2-3 mb30" style="margin:auto"><span>Enter Code Lesson <?php echo $object['title'] ?></span></div>
		<div class="slide-information va-buy-lesson">
			<form class="uk-form form "method="post">
	            <div class="form-row mb20">
	                <input type="text" placeholder="Enter Your Code Lesson..." name="code" class="input-text ">
	            </div>
	            <div class="form-row">
	                <button class="button btn-submit" name="create" value="">Get Started</button>
	            </div>
	        </form>
		</div>
	</div>
</div>