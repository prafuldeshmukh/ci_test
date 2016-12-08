<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Edit Blogs</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="username">Title</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Enter a title" value="<?php echo $blogs_single->title;?>">
					
				</div>
				<div class="form-group">
					<label for="email">Content</label>
					<textarea name="content" id="content" class="form-control"><?php echo $blogs_single->description;?></textarea>
					<!-- <input type="email" class="form-control" id="email" name="email" placeholder="Enter Content"> -->
					
				</div>
					<div class="form-group">
					<input type="submit" class="btn btn-default" value="Submit">
					<a href="<?= site_url('user/login') ?>" type="button" class="btn btn-success">Back</a>
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->